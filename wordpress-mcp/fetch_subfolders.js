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

async function inspectFolder(folderId, name) {
  const html = await fetchUrl(`https://drive.google.com/drive/folders/${folderId}`);
  const titles = html.match(/data-tooltip="([^"]+)"/g) || [];
  const ids = html.match(/data-id="([^"]+)"/g) || [];
  
  // Extract file entries
  const ariaRegex = /aria-label="([^"]+?\.(jpg|jpeg|png|webp|JPG|PNG))[^"]*"[^>]*data-id="([a-zA-Z0-9_-]{25,})"/gi;
  let m;
  const files = [];
  while ((m = ariaRegex.exec(html)) !== null) {
    files.push({ name: m[1], id: m[3] });
  }

  // Also extract from raw json in html
  const jsonRegex = /\\x5b\\x22([a-zA-Z0-9_-]{25,})\\x22,\\x5b\\x22[^\\]+\\x22\\x5d,\\x22([^\\"]+\.(jpg|jpeg|png|webp|JPG|PNG))\\x22/gi;
  while ((m = jsonRegex.exec(html)) !== null) {
    files.push({ id: m[1], name: m[2] });
  }

  const unique = Array.from(new Map(files.map(f => [f.name, f])).values());
  console.log(`=== ${name} (${folderId}) ===`);
  console.log('Tooltips:', titles);
  console.log('Unique files:', unique);
  return unique;
}

(async () => {
  await inspectFolder('1o9PyWqt30jRufebzbFmzAWHbDSDxQHa4', 'BON O BON');
  await inspectFolder('1zJQ6Mvt0qJmNYAKP5tveVy3CRwjpl50k', 'DEMOS CAFE');
})();
