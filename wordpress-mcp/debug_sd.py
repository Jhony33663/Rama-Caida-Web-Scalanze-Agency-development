import urllib.request
import re

req = urllib.request.Request('http://rama-caida.local/', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')

matches = [m.start() for m in re.finditer('santo-domingo-01', html)]
print(f"Total occurrences of santo-domingo-01: {len(matches)}")
for idx in matches:
    print("--- Occurrence ---")
    print(html[idx-150:idx+200])

matches2 = [m.start() for m in re.finditer('santo-domingo-02', html)]
print(f"Total occurrences of santo-domingo-02: {len(matches2)}")
for idx in matches2:
    print("--- Occurrence 02 ---")
    print(html[idx-150:idx+200])
