import https from 'https';

function fetchUrl(url) {
  return new Promise((resolve, reject) => {
    https.get(url, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => resolve(data));
    }).on('error', reject);
  });
}

(async () => {
  const html = await fetchUrl('https://drive.google.com/drive/folders/1zJQ6Mvt0qJmNYAKP5tveVy3CRwjpl50k');
  ['Buen Dia', 'Colcafe', 'Santo Domingo', 'Sello Rojo'].forEach(name => {
    let idx = html.indexOf(name);
    while (idx !== -1) {
      console.log(`=== ${name} ===`);
      console.log(html.substring(Math.max(0, idx - 150), Math.min(html.length, idx + 250)));
      idx = html.indexOf(name, idx + 1);
    }
  });
})();
