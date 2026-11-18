import fs from 'fs';

const kitDir = 'C:/Type_b/Clientes/RAMA CAIDA/runda-kit/templates';
const files = fs.readdirSync(kitDir).filter(f => f.endsWith('.json'));

const urls = new Set();
files.forEach(f => {
  const content = fs.readFileSync(kitDir + '/' + f, 'utf8');
  const matches = content.match(/https?:\/\/[^\s"'\\<>]+\.(jpg|jpeg|png|webp|svg)/gi) || [];
  matches.forEach(m => urls.add(m));
});

console.log('Total unique image URLs in kit:', urls.size);
console.log('Sample URLs:', Array.from(urls).slice(0, 15));
