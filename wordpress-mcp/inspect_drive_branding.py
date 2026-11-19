import re

with open('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/drive_branding.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Find any occurrences of file extensions
matches = re.findall(r'([a-zA-Z0-9_\-\. ]+\.(?:png|jpg|jpeg|svg|ai|pdf|eps))', text, re.IGNORECASE)
unique_files = sorted(list(set(matches)))
print('Found files in branding:', len(unique_files))
for f in unique_files:
    print(' -', f)

# Find folder names and IDs
folders = re.findall(r'\[\"([a-zA-Z0-9_-]{25,40})\",\[\"([^\"]+)\"\]', text)
print('Found items with IDs:', len(folders))
for item in folders[:20]:
    print(' -', item)
