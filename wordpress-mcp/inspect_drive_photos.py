import re

with open('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/drive_photos.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Look for shared folders
folders = re.findall(r'aria-label=\"([^\"]+?)\s+(?:Shared\s+folder|Carpeta\s+compartida)\"[^>]*data-id=\"([a-zA-Z0-9_-]{25,})\"', text, re.IGNORECASE)
print('Found subfolders:', len(folders))
for name, fid in folders:
    print(f"Folder: {name} -> {fid}")

# Also look for any folder names in json
json_folders = set(re.findall(r'\[\"([a-zA-Z0-9_-]{25,40})\",\[\"([^\"]+)\"\],\"application\/vnd\.google-apps\.folder\"', text))
print('JSON folders:', len(json_folders))
for fid, name in json_folders:
    print(f"JSON Folder: {name} -> {fid}")
