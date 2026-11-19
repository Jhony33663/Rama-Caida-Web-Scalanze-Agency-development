import urllib.request
import urllib.parse
import re
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE
headers = {'User-Agent': 'Mozilla/5.0'}

pages = [
    ('/', 'Home'),
    ('/about', 'About'),
    ('/merchandising-sales', 'Merchandising & Sales'),
    ('/services-6-1', 'Street Marketing'),
    ('/events', 'Events'),
    ('/contact', 'Contact')
]

mapping = {}

for path, name in pages:
    url = f'https://www.ramacaida.us{path}'
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req, context=ctx, timeout=10) as r:
            html = r.read().decode('utf-8', errors='ignore')
            imgs = set(re.findall(r'images\.squarespace-cdn\.com/content/v1/[^/]+/[^/]+/([^"\'\s<>\\?]+)', html))
            clean_list = [urllib.parse.unquote(i) for i in imgs]
            mapping[name] = clean_list
            print(f'=== {name} ({len(clean_list)} images) ===')
            for i in clean_list:
                print(f'  * {i}')
    except Exception as e:
        print(f'Error on {name}: {e}')
