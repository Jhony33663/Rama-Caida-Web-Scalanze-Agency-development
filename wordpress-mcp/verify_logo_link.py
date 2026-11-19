import urllib.request
import re

req = urllib.request.Request('http://rama-caida.local/', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')

pos = html.find('logo_orange_clean')
if pos != -1:
    print("Found logo snippet:")
    print(html[pos-300:pos+300])
else:
    print("Logo not found")
