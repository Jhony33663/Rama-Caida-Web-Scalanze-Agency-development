import fs from 'fs';
import { exec } from 'child_process';
import { promisify } from 'util';

const execAsync = promisify(exec);
const PHP_BIN = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\lightning-services\\php-8.2.29+0\\bin\\win64\\php.exe";
const PHP_INI = `${process.env.APPDATA}\\Local\\run\\uHjdKG5fB\\conf\\php\\php.ini`;
const WP_CLI = "C:\\Users\\JMATA\\AppData\\Local\\Programs\\Local\\resources\\extraResources\\bin\\wp-cli\\wp-cli.phar";
const SITE_PATH = "C:\\Users\\JMATA\\Local Sites\\rama-caida\\app\\public";

async function wp(args) {
  const cmd = `"${PHP_BIN}" -c "${PHP_INI}" "${WP_CLI}" --path="${SITE_PATH}" ${args}`;
  const { stdout } = await execAsync(cmd, { maxBuffer: 20 * 1024 * 1024 });
  return stdout;
}

(async () => {
  const homeData = await wp(`post meta get 6 _elementor_data`);
  const headerData = await wp(`post meta get 22 _elementor_data`);

  console.log('--- FINDING BAGIGAMBAR IN HOME ---');
  let idx = 0;
  while ((idx = homeData.indexOf('bagigambar', idx)) !== -1) {
    console.log(homeData.substring(Math.max(0, idx - 80), Math.min(homeData.length, idx + 120)));
    idx += 'bagigambar'.length;
  }

  console.log('--- FINDING LOGO IN HEADER ---');
  idx = 0;
  while ((idx = headerData.indexOf('logo', idx)) !== -1) {
    console.log(headerData.substring(Math.max(0, idx - 80), Math.min(headerData.length, idx + 120)));
    idx += 'logo'.length;
  }
})();
