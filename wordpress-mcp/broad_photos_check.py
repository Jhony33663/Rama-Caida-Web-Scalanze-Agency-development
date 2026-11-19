import re

with open('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/drive_photos.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Look for all 25-40 char IDs
id_matches = re.findall(r'\"([a-zA-Z0-9_-]{28,35})\"', text)
print("Unique IDs:", len(set(id_matches)))

# Look for titles or names
names = re.findall(r'\"([^\"]{3,40}\.(?:jpg|jpeg|png|webp))\"', text, re.IGNORECASE)
print("Image names:", len(set(names)), set(names))

# Look for folder names
tooltips = re.findall(r'data-tooltip=\"([^\"]+)\"', text)
print("Tooltips:", tooltips)
