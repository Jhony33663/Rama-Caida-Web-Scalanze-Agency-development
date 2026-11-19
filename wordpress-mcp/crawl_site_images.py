import os
import re
import urllib.request
import urllib.parse
import ssl
from collections import OrderedDict

base_url = "https://www.ramacaida.us"
output_dir = r"C:\Type_b\Clientes\RAMA CAIDA\assets\web_images"
os.makedirs(output_dir, exist_ok=True)

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36'
}

def fetch_html(url):
    print(f"Fetching page: {url}")
    req = urllib.request.Request(url, headers=headers)
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
            return resp.read().decode('utf-8', errors='ignore')
    except Exception as e:
        print(f"  Error fetching {url}: {e}")
        return ""

# Known pages to scrape
pages_to_crawl = [
    "/",
    "/about",
    "/merchandising-sales",
    "/services-6-1",
    "/events",
    "/contact",
    "/appointments",
    "/new-dropdown"
]

crawled = set()
all_image_urls = OrderedDict()

for path in pages_to_crawl:
    if path in crawled:
        continue
    crawled.add(path)
    url = urllib.parse.urljoin(base_url, path)
    html = fetch_html(url)
    if not html:
        continue

    # Also discover other internal links
    found_links = re.findall(r'href=["\'](/[^"\'\s#?]+|https?://(?:www\.)?ramacaida\.us/[^"\'\s#?]+)["\']', html)
    for fl in found_links:
        parsed = urllib.parse.urlparse(fl)
        clean_path = parsed.path
        if clean_path and clean_path not in crawled and not clean_path.endswith(('.jpg', '.png', '.css', '.js', '.pdf')):
            if not any(clean_path.startswith(x) for x in ['/cart', '/api', '/static']):
                pages_to_crawl.append(clean_path)

    # 1. Squarespace CDN images
    # e.g. https://images.squarespace-cdn.com/content/v1/...
    sq_matches = re.findall(r'https?://(?:images|static1)\.squarespace\.com/[^\s"\'<>\\)]+', html)
    for m in sq_matches:
        # Strip trailing formatting or quotes
        clean_url = m.split('?')[0].rstrip('",\';')
        if '/content/v1/' in clean_url or '/static/' in clean_url:
            all_image_urls[clean_url] = True

    # 2. General img src and data-src / data-image
    img_attrs = re.findall(r'(?:data-src|data-image|src)=["\']([^"\'\s>]+)["\']', html)
    for attr in img_attrs:
        clean = attr.split('?')[0].rstrip('",\';')
        if clean.startswith('//'):
            clean = 'https:' + clean
        elif clean.startswith('/'):
            clean = urllib.parse.urljoin(base_url, clean)
        if any(clean.lower().endswith(ext) for ext in ['.jpg', '.jpeg', '.png', '.webp', '.svg', '.gif']) or 'squarespace' in clean:
            all_image_urls[clean] = True

print(f"\nTotal unique image URLs discovered across all pages: {len(all_image_urls)}")

downloaded_files = []
index = 1

for img_url in all_image_urls.keys():
    # Append ?format=2500w for highest resolution from Squarespace CDN
    download_url = img_url
    if 'squarespace' in img_url and '?' not in img_url:
        download_url = img_url + "?format=2500w"

    # Extract filename from path
    parsed = urllib.parse.urlparse(img_url)
    raw_name = urllib.parse.unquote(os.path.basename(parsed.path))
    
    # Clean filename
    clean_name = re.sub(r'[^a-zA-Z0-9_\-\.]', '_', raw_name)
    if not clean_name or clean_name == '_':
        clean_name = f"image_{index:03d}.jpg"
    elif not any(clean_name.lower().endswith(ext) for ext in ['.jpg', '.jpeg', '.png', '.webp', '.svg', '.gif']):
        clean_name += ".jpg"

    target_path = os.path.join(output_dir, clean_name)
    
    # Avoid overwriting distinct images with identical base name
    if os.path.exists(target_path):
        clean_name = f"{index:03d}_{clean_name}"
        target_path = os.path.join(output_dir, clean_name)

    print(f"Downloading [{index}/{len(all_image_urls)}]: {clean_name}")
    try:
        req = urllib.request.Request(download_url, headers=headers)
        with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
            content = resp.read()
            if len(content) > 100:  # Valid image payload
                with open(target_path, 'wb') as f:
                    f.write(content)
                size_kb = len(content) / 1024
                downloaded_files.append((clean_name, size_kb, img_url))
                print(f"  -> Saved ({size_kb:.1f} KB)")
            else:
                print("  -> Skipped (empty or error response)")
    except Exception as e:
        print(f"  -> Failed: {e}")
    index += 1

print("\n" + "="*60)
print(f"SUMMARY: Successfully downloaded {len(downloaded_files)} images from https://www.ramacaida.us/")
print(f"Saved into: {output_dir}")
print("="*60)

for name, size_kb, url in downloaded_files:
    print(f"{name:<45} | {size_kb:7.1f} KB")
