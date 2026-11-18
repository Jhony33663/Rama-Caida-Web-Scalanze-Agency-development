import http from 'http';

const pages = [
  { name: 'Home', path: '/' },
  { name: 'Merchandising', path: '/merchandising-sales/' },
  { name: 'Street Marketing', path: '/street-marketing/' },
  { name: 'Events', path: '/events/' },
  { name: 'About', path: '/about/' },
  { name: 'Join Us', path: '/join-us/' },
  { name: 'Contact', path: '/contact/' }
];

async function checkPage(p) {
  return new Promise((resolve) => {
    http.get({
      host: 'localhost',
      port: 10004,
      path: p.path,
      headers: { Host: 'rama-caida.local' }
    }, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => {
        const bagigambarMatches = (data.match(/bagigambar/gi) || []).length;
        const localUploads = Array.from(new Set(data.match(/wp-content\/uploads\/[^\s"'<>\)]+/gi) || []));
        const hasLogo = data.includes('rama-caida-logo.png');
        resolve({
          name: p.name,
          deadExternalImages: bagigambarMatches,
          localImagesCount: localUploads.length,
          hasLogo
        });
      });
    }).on('error', (e) => resolve({ name: p.name, error: e.message }));
  });
}

(async () => {
  const results = [];
  for (const page of pages) {
    results.push(await checkPage(page));
  }
  console.table(results);
})();
