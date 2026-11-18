import fs from 'fs';

const d = fs.readFileSync('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/drive_branding.html', 'utf8');

const idRegex = /\["([a-zA-Z0-9_-]{25,40})"/g;
let m;
const ids = new Set();
while ((m = idRegex.exec(d)) !== null) {
  ids.add(m[1]);
}
console.log('ID matches count:', ids.size);
console.log('Sample IDs:', Array.from(ids).slice(0, 15));

['logo', 'png', 'jpg', 'svg', 'ai', 'pdf', 'Rama', 'brand'].forEach(kw => {
  let idx = 0;
  let found = [];
  while ((idx = d.toLowerCase().indexOf(kw.toLowerCase(), idx)) !== -1 && found.length < 5) {
    found.push(d.substring(Math.max(0, idx - 40), Math.min(d.length, idx + 50)).replace(/[\r\n]+/g, ' '));
    idx += kw.length;
  }
  console.log(`Keyword "${kw}":`, found);
});
