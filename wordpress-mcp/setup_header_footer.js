import fs from "fs";
import { exec } from "child_process";
import { promisify } from "util";

const execAsync = promisify(exec);

const PHP_BIN = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\lightning-services\\php-8.2.29+0\\bin\\win64\\php.exe";
const PHP_INI = `${process.env.APPDATA}\\Local\\run\\uHjdKG5fB\\conf\\php\\php.ini`;
const WP_CLI = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\bin\\wp-cli\\wp-cli.phar";
const SITE_PATH = "C:\\Users\\JMATA\\Local Sites\\rama-caida\\app\\public";
const KIT_DIR = "C:\\Type_b\\Clientes\\RAMA CAIDA\\runda-kit\\templates";

async function wp(args) {
  const cmd = `"${PHP_BIN}" -c "${PHP_INI}" "${WP_CLI}" --path="${SITE_PATH}" ${args}`;
  const { stdout } = await execAsync(cmd, { maxBuffer: 10 * 1024 * 1024 });
  return (stdout || "").trim();
}

function clone(obj) {
  return JSON.parse(JSON.stringify(obj));
}

function replaceInWidget(node, predicate, updater) {
  if (Array.isArray(node)) {
    node.forEach(item => replaceInWidget(item, predicate, updater));
  } else if (node && typeof node === "object") {
    if (predicate(node)) {
      updater(node);
    }
    for (const k of Object.keys(node)) {
      replaceInWidget(node[k], predicate, updater);
    }
  }
}

async function createHeaderFooter() {
  // 1. Prepare Header
  const headerRaw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\header.json`, "utf8"));
  const headerContent = clone(headerRaw.content);

  replaceInWidget(headerContent, n => n.widgetType === "button", n => {
    n.settings.text = "CONTACT US";
    n.settings.link = { url: "http://rama-caida.local/contact/", is_external: "", nofollow: "" };
  });

  // Link nav menu to our Menu 2 (Main Menu)
  replaceInWidget(headerContent, n => n.widgetType === "jkit_nav_menu", n => {
    n.settings.menu = "2";
  });

  // 2. Prepare Footer
  const footerRaw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\footer.json`, "utf8"));
  const footerContent = clone(footerRaw.content);

  replaceInWidget(footerContent, n => n.widgetType === "text-editor" && /Goodwin/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>137 1/2 Washington Ave., Suite 306<br>Belleville NJ 07109</p>";
  });
  replaceInWidget(footerContent, n => n.widgetType === "text-editor" && /runda@/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><a href='mailto:danicp.ramacaidasampling@gmail.com'>danicp.ramacaidasampling@gmail.com</a></p>";
  });
  replaceInWidget(footerContent, n => n.widgetType === "text-editor" && /509-364/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><strong>Toll Free:</strong> (888) 973-3122</p>";
  });
  replaceInWidget(footerContent, n => n.widgetType === "text-editor" && /Copyright/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>© 2026 Rama Caida Product Sampling & Brand Awareness. All rights reserved.</p>";
  });

  // Save Header in elementor-hf
  const tmpH = "C:\\Type_b\\Clientes\\RAMA CAIDA\\wordpress-mcp\\tmp_header.json";
  fs.writeFileSync(tmpH, JSON.stringify(headerContent), "utf8");

  // Save Footer in elementor-hf
  const tmpF = "C:\\Type_b\\Clientes\\RAMA CAIDA\\wordpress-mcp\\tmp_footer.json";
  fs.writeFileSync(tmpF, JSON.stringify(footerContent), "utf8");

  const evalCode = `
    // Create Header post
    $hId = wp_insert_post([
      'post_title' => 'Rama Caida Main Header',
      'post_type' => 'elementor-hf',
      'post_status' => 'publish'
    ]);
    $hData = file_get_contents('${tmpH.replace(/\\/g, "/")}');
    update_post_meta($hId, '_elementor_data', wp_slash($hData));
    update_post_meta($hId, '_elementor_edit_mode', 'builder');
    update_post_meta($hId, 'ehf_template_type', 'type_header');
    update_post_meta($hId, 'ehf_target_include_locations', ['entire_website']);

    // Create Footer post
    $fId = wp_insert_post([
      'post_title' => 'Rama Caida Main Footer',
      'post_type' => 'elementor-hf',
      'post_status' => 'publish'
    ]);
    $fData = file_get_contents('${tmpF.replace(/\\/g, "/")}');
    update_post_meta($fId, '_elementor_data', wp_slash($fData));
    update_post_meta($fId, '_elementor_edit_mode', 'builder');
    update_post_meta($fId, 'ehf_template_type', 'type_footer');
    update_post_meta($fId, 'ehf_target_include_locations', ['entire_website']);

    echo "Header ID: $hId, Footer ID: $fId created and assigned to entire website.";
  `.replace(/\n/g, " ");

  const res = await wp(`eval "${evalCode.replace(/"/g, '\\"')}"`);
  console.log(res);

  try { fs.unlinkSync(tmpH); fs.unlinkSync(tmpF); } catch (e) {}
}

createHeaderFooter().catch(console.error);
