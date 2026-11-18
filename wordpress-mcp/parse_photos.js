import fs from 'fs';

const d = fs.readFileSync('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/drive_photos.html', 'utf8');

const titles = d.match(/data-tooltip="([^"]+)"/g) || [];
console.log('Tooltips count:', titles.length);
console.log('Sample tooltips:', titles.slice(0, 30));

const ids = d.match(/data-id="([^"]+)"/g) || [];
console.log('data-ids count:', ids.length);
console.log('Sample data-ids:', ids.slice(0, 30));

const titleMatch = d.match(/<title>(.*?)<\/title>/);
console.log('Page Title:', titleMatch ? titleMatch[1] : 'None');
