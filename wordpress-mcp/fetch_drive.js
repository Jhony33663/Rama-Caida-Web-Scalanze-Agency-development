import https from 'https';
import fs from 'fs';

function fetchUrl(url) {
  return new Promise((resolve, reject) => {
    https.get(url, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => resolve(data));
    }).on('error', reject);
  });
}

async function scrapeDrive(folderId, name) {
  const url = `https://drive.google.com/drive/folders/${folderId}`;
  console.log(`Fetching ${name}...`);
  const html = await fetchUrl(url);

  // Extract filenames and IDs
  const fileRegex = /\["([a-zA-Z0-9_-]{25,})",\["([^"]+\.(png|jpg|jpeg|svg|pdf|webp))"/gi;
  let m;
  const files = [];
  while ((m = fileRegex.exec(html)) !== null) {
    files.push({ id: m[1], name: m[2] });
  }

  // Also try alternative regex in drive json data
  const simpleMatch = html.match(/"([a-zA-Z0-9_-]{28,})","([^"]+\.(png|jpg|jpeg|svg|pdf|webp))"/gi) || [];
  for (const s of simpleMatch) {
    const parts = s.replace(/"/g, '').split(',');
    if (parts.length >= 2) {
      files.push({ id: parts[0], name: parts[1] });
    }
  }

  console.log(`${name} found:`, files);
  return files;
}

(async () => {
  try {
    const branding = await scrapeDrive('1TilgTQUR2yXXUdu2lLPbYQsriWUU4sWM', 'BRANDING');
    const photos = await scrapeDrive('11dL46tr98KFCVyUa8CAB8KKhLPZzTsdb', 'PHOTOS');
  } catch (err) {
    console.error(err);
  }
})();
