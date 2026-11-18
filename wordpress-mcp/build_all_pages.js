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
  const { stdout } = await execAsync(cmd, { maxBuffer: 20 * 1024 * 1024 });
  return (stdout || "").trim();
}

async function savePageElementor(pageId, content) {
  const tmpFile = `C:\\Type_b\\Clientes\\RAMA CAIDA\\wordpress-mcp\\tmp_p${pageId}.json`;
  fs.writeFileSync(tmpFile, JSON.stringify(content), "utf8");

  const evalCode = `
    $data = file_get_contents('${tmpFile.replace(/\\/g, "/")}');
    update_post_meta(${pageId}, '_elementor_data', wp_slash($data));
    update_post_meta(${pageId}, '_elementor_edit_mode', 'builder');
    update_post_meta(${pageId}, '_wp_page_template', 'elementor_header_footer');
    echo 'Saved page ${pageId} successfully';
  `.replace(/\n/g, " ");

  const res = await wp(`eval "${evalCode.replace(/"/g, '\\"')}"`);
  console.log(`Page ${pageId}:`, res);
  try { fs.unlinkSync(tmpFile); } catch (e) {}
}

// Deep clone
function clone(obj) {
  return JSON.parse(JSON.stringify(obj));
}

// Generic recursive text replacer for widgets
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

// -------------------------------------------------------------
// 1. HOME (ID 6) - based on home-1.json
// -------------------------------------------------------------
function buildHomePage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\home-1.json`, "utf8"));
  const content = clone(raw.content);

  // Hero Section
  replaceInWidget(content, n => n.widgetType === "heading" && /WE ARE/i.test(n.settings?.title), n => {
    n.settings.title = "RAMA CAIDA";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /DIGITAL\s+AGENCY/i.test(n.settings?.title), n => {
    n.settings.title = "FIELD MARKETING SUPERPOWERS";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><strong>¡Libera tus superpoderes de marketing en el campo!</strong> Since 2017, we turn ordinary brands into truly unforgettable and memorable experiences across the Northeast US (from Virginia to Massachusetts).</p>";
  });
  replaceInWidget(content, n => n.widgetType === "button" && /Get in touch/i.test(n.settings?.text), n => {
    n.settings.text = "SCHEDULE AN APPOINTMENT";
    n.settings.link = { url: "http://rama-caida.local/contact/", is_external: "", nofollow: "" };
  });

  // Services Titles
  replaceInWidget(content, n => n.widgetType === "heading" && /PRODUCT ENGINEERING/i.test(n.settings?.title), n => {
    n.settings.title = "MERCHANDISING & SALES";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /UI AND UX DESIGN/i.test(n.settings?.title), n => {
    n.settings.title = "STREET MARKETING";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /DIGITAL MARKETING/i.test(n.settings?.title), n => {
    n.settings.title = "EVENTS & ACTIVATIONS";
  });

  // About Section inside Home
  replaceInWidget(content, n => n.widgetType === "heading" && /ABOUT US/i.test(n.settings?.title), n => {
    n.settings.title = "GET TO KNOW US";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Sed ut perspiciatis/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Since 2017, Rama Caida Product Sampling & Brand Awareness has proudly been your go-to partner for turning ordinary brands into truly unforgettable experiences. Operating from Virginia all the way up to Massachusetts, our playful and energetic spirit drives us to delight and engage consumers every step of the way.</p>";
  });

  // CTA Section
  replaceInWidget(content, n => n.widgetType === "heading" && /WORK WITH US/i.test(n.settings?.title), n => {
    n.settings.title = "GRAB YOUR SPOT";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Curabitur vulputate/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p>";
  });

  return content;
}

// -------------------------------------------------------------
// 2. MERCHANDISING & SALES (ID 7) - based on service-1.json
// -------------------------------------------------------------
function buildMerchandisingPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\service-1.json`, "utf8"));
  const content = clone(raw.content);

  // Hero
  replaceInWidget(content, n => n.widgetType === "heading" && /SERVICE/i.test(n.settings?.title), n => {
    n.settings.title = "MERCHANDISING & SALES";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><strong>Retail Specialists:</strong> Having the right team interacting with category managers, store managers, and buyers in the field is essential. These experts carry ideas all the way to the shelves and into the hands of customers with enthusiasm and storytelling.</p>";
  });

  // Service details
  replaceInWidget(content, n => n.widgetType === "heading" && /WEB DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "MERCHANDISERS";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /MOBILE DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "NEURO SALES";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /DESKTOP DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "STRATEGY SALES PACKAGES";
  });

  return content;
}

// -------------------------------------------------------------
// 3. STREET MARKETING (ID 8) - based on service-2.json
// -------------------------------------------------------------
function buildStreetMarketingPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\service-2.json`, "utf8"));
  const content = clone(raw.content);

  replaceInWidget(content, n => n.widgetType === "heading" && /SERVICE/i.test(n.settings?.title), n => {
    n.settings.title = "STREET MARKETING";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><strong>Surprise them. Delight them. Make them remember you.</strong> <em>Sorpréndelos. Encántalos. Haz que te recuerden.</em> We take your brand out of the ordinary and into streets, plazas, and fairs turning everyday moments into playful brand experiences.</p>";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /RESEARCH/i.test(n.settings?.title), n => {
    n.settings.title = "STREET TEAMS & 360 BOOTHS";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /WIREFRAMING/i.test(n.settings?.title), n => {
    n.settings.title = "INTERACTIVE MARKETING";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /PROTOTYPING/i.test(n.settings?.title), n => {
    n.settings.title = "PLAN • ACTIVATE • LEARN";
  });

  return content;
}

// -------------------------------------------------------------
// 4. EVENTS (ID 9) - based on service-1.json
// -------------------------------------------------------------
function buildEventsPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\service-1.json`, "utf8"));
  const content = clone(raw.content);

  replaceInWidget(content, n => n.widgetType === "heading" && /SERVICE/i.test(n.settings?.title), n => {
    n.settings.title = "EVENTS & DEMOS";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p><strong>Where your brand meets its fans.</strong> <em>Donde tu marca conoce a sus fans.</em> From major festivals to retail demo stations, we create joyful experiences where consumers can see, touch, and taste before they buy.</p>";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /WEB DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "POP UP EVENTS";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /MOBILE DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "RETAIL ACTIVATIONS (DEMOS)";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /DESKTOP DEVELOPMENT/i.test(n.settings?.title), n => {
    n.settings.title = "MEET OUR ACTIVATORS";
  });

  return content;
}

// -------------------------------------------------------------
// 5. GET TO KNOW US (ID 10) - based on about-us.json
// -------------------------------------------------------------
function buildAboutPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\about-us.json`, "utf8"));
  const content = clone(raw.content);

  replaceInWidget(content, n => n.widgetType === "heading" && /ABOUT US/i.test(n.settings?.title), n => {
    n.settings.title = "GET TO KNOW US";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /OUR STORY/i.test(n.settings?.title), n => {
    n.settings.title = "OUR ORIGINS";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Rama Caida was born out of the cumbersome experience I had searching for quality supermarket demonstrators for a beautiful grocery product line. The frustration later transformed into the opportunity to create an enterprise and make a lasting difference in the industry.<br><strong>— Francia Franco, 2022</strong></p>";
  });
  replaceInWidget(content, n => n.widgetType === "heading" && /OUR MISSION/i.test(n.settings?.title), n => {
    n.settings.title = "OUR MISSION & CORE VALUES";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Pellentesque/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Our core values define every interaction: <strong>Transparency, Trust, Social Responsibility, Excellence, Teamwork, Innovation, and Community Engagement.</strong></p>";
  });

  return content;
}

// -------------------------------------------------------------
// 6. JOIN US (ID 11) - based on our-team.json
// -------------------------------------------------------------
function buildJoinUsPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\our-team.json`, "utf8"));
  const content = clone(raw.content);

  replaceInWidget(content, n => n.widgetType === "heading" && /OUR TEAM/i.test(n.settings?.title), n => {
    n.settings.title = "JOIN THE TEAM";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Are you outgoing, self-motivated, and bilingual with a passion for adventure? We are hiring: <strong>Merchandisers, Sales Staff, Activators (Demo Reps), and Drivers</strong> across NJ, NY, CT, PA, MA, RI, MD, DE, VA, and remote in LATAM!</p>";
  });

  // Team member names -> Real team members from testimonials
  const names = [
    { name: "Andrea Cuervo G", role: "Elizabeth, NJ" },
    { name: "Angelica Rivera", role: "Brooklyn, NY" },
    { name: "Maitte Ribadeneira", role: "LATAM Remote" },
    { name: "Maria Lopez", role: "Bridgeport, CT" },
    { name: "Jessica Camacho", role: "LATAM Remote" },
    { name: "Alex Garcia", role: "LATAM Remote (Office Coord.)" }
  ];

  let nameIndex = 0;
  replaceInWidget(content, n => n.widgetType === "heading" && n.settings?.title && !/JOIN|TEAM|TESTIMONIAL/i.test(n.settings?.title), n => {
    if (nameIndex < names.length) {
      n.settings.title = names[nameIndex].name;
      nameIndex++;
    }
  });

  return content;
}

// -------------------------------------------------------------
// 7. CONTACT US (ID 12) - based on contact-us.json
// -------------------------------------------------------------
function buildContactPage() {
  const raw = JSON.parse(fs.readFileSync(`${KIT_DIR}\\contact-us.json`, "utf8"));
  const content = clone(raw.content);

  replaceInWidget(content, n => n.widgetType === "heading" && /CONTACT/i.test(n.settings?.title), n => {
    n.settings.title = "GRAB YOUR SPOT";
  });
  replaceInWidget(content, n => n.widgetType === "text-editor" && /Lorem ipsum/i.test(n.settings?.editor), n => {
    n.settings.editor = "<p>Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p><p><strong>Address:</strong> 137 1/2 Washington Ave., Suite 306, Belleville NJ 07109<br><strong>Email:</strong> danicp.ramacaidasampling@gmail.com<br><strong>Toll Free:</strong> (888) 973-3122</p>";
  });

  return content;
}

// -------------------------------------------------------------
// Main execution
// -------------------------------------------------------------
async function main() {
  console.log("Starting full page generation...");

  await savePageElementor(6, buildHomePage());
  await savePageElementor(7, buildMerchandisingPage());
  await savePageElementor(8, buildStreetMarketingPage());
  await savePageElementor(9, buildEventsPage());
  await savePageElementor(10, buildAboutPage());
  await savePageElementor(11, buildJoinUsPage());
  await savePageElementor(12, buildContactPage());

  // Clear Elementor CSS Cache
  const evalCode = `\\Elementor\\Plugin::$instance->files_manager->clear_cache(); echo 'Elementor cache cleared';`;
  await wp(`eval "${evalCode}"`);

  console.log("All 7 pages successfully assembled and styled!");
}

main().catch(console.error);
