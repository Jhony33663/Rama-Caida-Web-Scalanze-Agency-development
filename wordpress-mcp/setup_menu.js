import { exec } from "child_process";
import { promisify } from "util";

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

async function main() {
  // Create Main Menu
  const menuRes = await wp('menu create "Main Menu" --porcelain');
  const menuId = menuRes.split("\n").filter(l => /^\d+$/.test(l.trim())).pop();
  console.log("Menu ID:", menuId);

  // 1. Services (custom link #)
  const srvRes = await wp(`menu item add-custom ${menuId} "Services" "#" --porcelain`);
  const srvId = srvRes.split("\n").filter(l => /^\d+$/.test(l.trim())).pop();

  // Sub-items
  await wp(`menu item add-post ${menuId} 7 --parent-id=${srvId}`); // Merchandising & Sales
  await wp(`menu item add-post ${menuId} 8 --parent-id=${srvId}`); // Street Marketing
  await wp(`menu item add-post ${menuId} 9 --parent-id=${srvId}`); // Events

  // 2. Get to Know Us
  await wp(`menu item add-post ${menuId} 10`);

  // 3. Join Us
  await wp(`menu item add-post ${menuId} 11`);

  // 4. Contact Us
  await wp(`menu item add-post ${menuId} 12`);

  // Assign to primary location
  await wp(`menu location assign ${menuId} primary`);
  await wp(`menu location assign ${menuId} main-menu`);
  console.log("Navigation menu successfully created and assigned!");
}

main().catch(console.error);
