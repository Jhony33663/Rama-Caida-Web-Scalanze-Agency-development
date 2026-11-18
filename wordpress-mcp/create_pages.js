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

const pages = [
  { title: "Merchandising & Sales", slug: "merchandising-sales" },
  { title: "Street Marketing", slug: "street-marketing" },
  { title: "Events", slug: "events" },
  { title: "Get to Know Us", slug: "about" },
  { title: "Join Us", slug: "join-us" },
  { title: "Contact Us", slug: "contact" }
];

async function main() {
  // Set page 6 as front page
  await wp("option update show_on_front page");
  await wp("option update page_on_front 6");
  console.log("Set Home (ID 6) as front page");

  for (const p of pages) {
    const id = await wp(`post create --post_type=page --post_title="${p.title}" --post_name="${p.slug}" --post_status=publish --porcelain`);
    const cleanId = id.split("\n").filter(l => /^\d+$/.test(l.trim())).pop();
    if (cleanId) {
      await wp(`post meta update ${cleanId} _elementor_edit_mode "builder"`);
      await wp(`post meta update ${cleanId} _wp_page_template "elementor_header_footer"`);
      console.log(`Created: ${p.title} (ID: ${cleanId})`);
    }
  }

  // Delete sample page
  await wp("post delete 2 --force");
  console.log("Cleaned sample page.");
}

main().catch(console.error);
