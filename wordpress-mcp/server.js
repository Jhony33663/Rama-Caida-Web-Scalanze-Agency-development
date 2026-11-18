import { Server } from "@modelcontextprotocol/sdk/server/index.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} from "@modelcontextprotocol/sdk/types.js";
import { exec } from "child_process";
import { promisify } from "util";
import fs from "fs";

const execAsync = promisify(exec);

const PHP_BIN = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\lightning-services\\php-8.2.29+0\\bin\\win64\\php.exe";
const PHP_INI = `${process.env.APPDATA}\\Local\\run\\uHjdKG5fB\\conf\\php\\php.ini`;
const WP_CLI = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\bin\\wp-cli\\wp-cli.phar";
const SITE_PATH = "C:\\Users\\JMATA\\Local Sites\\rama-caida\\app\\public";

async function runWpCli(args) {
  const cmd = `"${PHP_BIN}" -c "${PHP_INI}" "${WP_CLI}" --path="${SITE_PATH}" ${args}`;
  try {
    const { stdout, stderr } = await execAsync(cmd, { maxBuffer: 10 * 1024 * 1024 });
    return { success: true, output: (stdout || "").trim(), error: (stderr || "").trim() };
  } catch (err) {
    return {
      success: false,
      output: (err.stdout || "").trim(),
      error: (err.stderr || err.message || "").trim(),
    };
  }
}

const server = new Server(
  {
    name: "wordpress-local-mcp",
    version: "1.0.0",
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

server.setRequestHandler(ListToolsRequestSchema, async () => {
  return {
    tools: [
      {
        name: "wp_cli",
        description: "Ejecuta cualquier comando de WP-CLI en el sitio local de Rama Caida (ej. 'post list', 'plugin list', 'option get siteurl')",
        inputSchema: {
          type: "object",
          properties: {
            command: {
              type: "string",
              description: "Comando de WP-CLI sin prefijo 'wp' (ej: 'post list --post_type=page --format=json')",
            },
          },
          required: ["command"],
        },
      },
      {
        name: "wp_list_pages",
        description: "Lista todas las páginas de WordPress con su ID, título, estado y URL",
        inputSchema: {
          type: "object",
          properties: {
            status: {
              type: "string",
              description: "Estado de las páginas a consultar (publish, draft, any). Por defecto 'any'",
            },
          },
        },
      },
      {
        name: "wp_create_page",
        description: "Crea una nueva página en WordPress con opción de habilitar Elementor",
        inputSchema: {
          type: "object",
          properties: {
            title: { type: "string", description: "Título de la página" },
            slug: { type: "string", description: "Slug o enlace permanente (opcional)" },
            content: { type: "string", description: "Contenido HTML o texto base" },
            status: { type: "string", description: "publish o draft (por defecto publish)" },
            enable_elementor: { type: "boolean", description: "Si se debe inicializar como página de Elementor Canvas/Full Width" },
          },
          required: ["title"],
        },
      },
      {
        name: "wp_get_elementor_data",
        description: "Obtiene la estructura JSON de widgets y secciones de Elementor (_elementor_data) de una página",
        inputSchema: {
          type: "object",
          properties: {
            page_id: { type: "number", description: "ID de la página" },
          },
          required: ["page_id"],
        },
      },
      {
        name: "wp_save_elementor_data",
        description: "Guarda la estructura JSON de Elementor (_elementor_data) en una página y activa el modo Elementor",
        inputSchema: {
          type: "object",
          properties: {
            page_id: { type: "number", description: "ID de la página" },
            elementor_json: { type: "string", description: "JSON estructurado de secciones/columnas/widgets de Elementor" },
          },
          required: ["page_id", "elementor_json"],
        },
      },
      {
        name: "wp_get_site_info",
        description: "Obtiene información general del sitio: URL, título, tema activo y versión de WordPress",
        inputSchema: {
          type: "object",
          properties: {},
        },
      },
    ],
  };
});

server.setRequestHandler(CallToolRequestSchema, async (request) => {
  const { name, arguments: args } = request.params;

  if (name === "wp_cli") {
    const res = await runWpCli(args.command);
    return {
      content: [{ type: "text", text: res.output || res.error || "Done." }],
    };
  }

  if (name === "wp_list_pages") {
    const status = args.status || "any";
    const res = await runWpCli(`post list --post_type=page --post_status=${status} --fields=ID,post_title,post_name,post_status,post_date --format=json`);
    return {
      content: [{ type: "text", text: res.output || res.error }],
    };
  }

  if (name === "wp_create_page") {
    const status = args.status || "publish";
    let cmd = `post create --post_type=page --post_title="${args.title.replace(/"/g, '\\"')}" --post_status=${status} --porcelain`;
    if (args.slug) cmd += ` --post_name="${args.slug}"`;
    if (args.content) cmd += ` --post_content="${args.content.replace(/"/g, '\\"')}"`;

    const res = await runWpCli(cmd);
    const newId = parseInt(res.output.trim(), 10);

    if (newId && args.enable_elementor) {
      await runWpCli(`post meta update ${newId} _elementor_edit_mode "builder"`);
      await runWpCli(`post meta update ${newId} _wp_page_template "elementor_header_footer"`);
    }

    return {
      content: [{ type: "text", text: `Page created with ID: ${newId}` }],
    };
  }

  if (name === "wp_get_elementor_data") {
    const res = await runWpCli(`post meta get ${args.page_id} _elementor_data`);
    return {
      content: [{ type: "text", text: res.output || "{}" }],
    };
  }

  if (name === "wp_save_elementor_data") {
    // Write JSON to temp file to prevent escaping issues on command line
    const tmpFile = `C:\\Type_b\\Clientes\\RAMA CAIDA\\wordpress-mcp\\tmp_${args.page_id}.json`;
    fs.writeFileSync(tmpFile, args.elementor_json, "utf8");

    // Update using PHP script via wp eval
    const evalCode = `
      $data = file_get_contents('${tmpFile.replace(/\\/g, "/")}');
      update_post_meta(${args.page_id}, '_elementor_data', wp_slash($data));
      update_post_meta(${args.page_id}, '_elementor_edit_mode', 'builder');
      update_post_meta(${args.page_id}, '_wp_page_template', 'elementor_header_footer');
      echo 'Saved elementor data successfully';
    `.replace(/\n/g, " ");

    const res = await runWpCli(`eval "${evalCode.replace(/"/g, '\\"')}"`);
    try { fs.unlinkSync(tmpFile); } catch (e) {}

    return {
      content: [{ type: "text", text: res.output || res.error }],
    };
  }

  if (name === "wp_get_site_info") {
    const resUrl = await runWpCli("option get siteurl");
    const resTitle = await runWpCli("option get blogname");
    const resTheme = await runWpCli("theme list --status=active --field=name");
    const resVersion = await runWpCli("core version");

    const info = {
      site_url: resUrl.output,
      site_name: resTitle.output,
      active_theme: resTheme.output,
      wp_version: resVersion.output,
      plugins: ["elementor", "elementor-pro", "elementskit-lite", "jeg-elementor-kit", "header-footer-elementor", "wpforms-lite"],
    };

    return {
      content: [{ type: "text", text: JSON.stringify(info, null, 2) }],
    };
  }

  throw new Error(`Tool not found: ${name}`);
});

async function main() {
  const transport = new StdioServerTransport();
  await server.connect(transport);
}

main().catch((err) => {
  console.error("Fatal error:", err);
  process.exit(1);
});
