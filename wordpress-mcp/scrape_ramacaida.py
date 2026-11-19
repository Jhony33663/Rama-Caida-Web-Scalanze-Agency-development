import re
import urllib.parse

with open('ramacaida_us.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Check CMS / platform
if 'wix.com' in html or 'static.wixstatic.com' in html:
    print('Platform: Wix')
elif 'wp-content' in html:
    print('Platform: WordPress')
elif 'squarespace' in html:
    print('Platform: Squarespace')
elif 'webflow' in html:
    print('Platform: Webflow')
else:
    print('Platform: Custom or other')

# If Wix, search for wix static media URLs: https://static.wixstatic.com/media/...
wix_media = set(re.findall(r'https?://static\.wixstatic\.com/media/[a-zA-Z0-9_~]+(?:\.(?:jpg|jpeg|png|webp|gif|svg)|~mv2)', html, re.I))
print(f'Found {len(wix_media)} Wix media URLs')

# Also search standard images
standard_imgs = set(re.findall(r'https?://[^\s"\'<>\)]+\.(?:jpg|jpeg|png|webp|svg|gif)', html, re.I))
print(f'Found {len(standard_imgs)} total standard image URLs')

# Internal links
links = set(re.findall(r'href=["\'](https?://(?:www\.)?ramacaida\.us[^\s"\'<>]*|/[a-zA-Z0-9_\-\/]+)["\']', html, re.I))
print(f'Found {len(links)} links:')
for l in sorted(links):
    print(' *', l)

# Print some image samples
sample = list(wix_media) if wix_media else list(standard_imgs)
print('Sample images:')
for s in sample[:20]:
    print(' -', s)
