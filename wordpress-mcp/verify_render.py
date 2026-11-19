import urllib.request
import re

req = urllib.request.Request('http://rama-caida.local/', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')

print("=== CHECKING HERO IN HTML ===")
print("Contains bon-o-bon-02.webp:", 'bon-o-bon-02.webp' in html)
print("Contains bon-o-bon-01.webp:", 'bon-o-bon-01.webp' in html)

matches = re.findall(r'background-image:[^;}\"]+', html)
for m in matches:
    print("Found BG:", m)
