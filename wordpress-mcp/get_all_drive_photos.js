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

async function getFolderFiles(folderId) {
  const html = await fetchUrl(`https://drive.google.com/drive/folders/${folderId}`);
  
  // Extract subfolders
  const folderMatches = [];
  const folderRegex = /aria-label="([^"]+?)\s+Shared\s+folder"[^>]*data-id="([a-zA-Z0-9_-]{25,})"/gi;
  let m;
  while ((m = folderRegex.exec(html)) !== null) {
    folderMatches.push({ name: m[1], id: m[2] });
  }

  // Extract photos
  const files = [];
  const ariaRegex = /aria-label="([^"]+?\.(jpg|jpeg|png|webp|JPG|PNG))[^"]*"[^>]*data-id="([a-zA-Z0-9_-]{25,})"/gi;
  while ((m = ariaRegex.exec(html)) !== null) {
    files.push({ name: m[1], id: m[3] });
  }
  const jsonRegex = /\\x5b\\x22([a-zA-Z0-9_-]{25,})\\x22,\\x5b\\x22[^\\]+\\x22\\x5d,\\x22([^\\"]+\.(jpg|jpeg|png|webp|JPG|PNG))\\x22/gi;
  while ((m = jsonRegex.exec(html)) !== null) {
    files.push({ id: m[1], name: m[2] });
  }

  const uniqueFiles = Array.from(new Map(files.map(f => [f.name, f])).values());
  const uniqueFolders = Array.from(new Map(folderMatches.map(f => [f.name, f])).values());
  return { folders: uniqueFolders, files: uniqueFiles };
}

(async () => {
  const demos = await getFolderFiles('1zJQ6Mvt0qJmNYAKP5tveVy3CRwjpl50k');
  console.log('Demos Cafe subfolders:', demos.folders);
  
  for (const f of demos.folders) {
    const sub = await getFolderFiles(f.id);
    console.log(`Subfolder "${f.name}" (${f.id}): found ${sub.files.length} files`);
    if (sub.files.length > 0) {
      console.log('Sample files:', sub.files.slice(0, 5));
    }
  }
})();
