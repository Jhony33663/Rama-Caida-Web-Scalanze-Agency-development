import { exec } from "child_process";
import { promisify } from "util";
import fs from "fs";

const execAsync = promisify(exec);
const PHP_BIN = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\lightning-services\\php-8.2.29+0\\bin\\win64\\php.exe";
const PHP_INI = `${process.env.APPDATA}\\Local\\run\\uHjdKG5fB\\conf\\php\\php.ini`;
const WP_CLI = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\bin\\wp-cli\\wp-cli.phar";
const SITE_PATH = "C:\\Users\\JMATA\\Local Sites\\rama-caida\\app\\public";

async function wp(args) {
  const cmd = `"${PHP_BIN}" -c "${PHP_INI}" "${WP_CLI}" --path="${SITE_PATH}" ${args}`;
  const { stdout } = await execAsync(cmd);
  return (stdout || "").trim();
}

async function applyGlobalStyles() {
  const globalPath = "C:\\Type_b\\Clientes\\RAMA CAIDA\\runda-kit\\templates\\global.json";
  const raw = fs.readFileSync(globalPath, "utf8");
  const data = JSON.parse(raw);

  const activeKitId = await wp("option get elementor_active_kit");
  const kitId = parseInt(activeKitId.split("\n").filter(l => /^\d+$/.test(l.trim())).pop(), 10) || 5;

  const tmpFile = "C:\\Type_b\\Clientes\\RAMA CAIDA\\runda-kit\\tmp_global_settings.json";
  fs.writeFileSync(tmpFile, JSON.stringify(data.page_settings), "utf8");

  const evalCode = `
    $json = file_get_contents('${tmpFile.replace(/\\/g, "/")}');
    $settings = json_decode($json, true);
    update_post_meta(${kitId}, '_elementor_page_settings', $settings);
    // Regenerate CSS
    \\Elementor\\Plugin::$instance->files_manager->clear_cache();
    echo 'Global kit styles updated on kit ID ${kitId}';
  `.replace(/\n/g, " ");

  const res = await wp(`eval "${evalCode.replace(/"/g, '\\"')}"`);
  console.log(res);

  try { fs.unlinkSync(tmpFile); } catch (e) {}
}

applyGlobalStyles().catch(console.error);
