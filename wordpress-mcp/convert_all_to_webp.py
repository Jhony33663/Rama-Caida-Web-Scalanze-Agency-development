import os
from PIL import Image

dirs_to_convert = [
    "C:/Type_b/Clientes/RAMA CAIDA/assets/photos",
    "C:/Type_b/Clientes/RAMA CAIDA/assets/web_images",
    "C:/Type_b/Clientes/RAMA CAIDA/assets"
]

webp_dir = "C:/Type_b/Clientes/RAMA CAIDA/assets/webp_all"
os.makedirs(webp_dir, exist_ok=True)

converted = {}

for d in dirs_to_convert:
    for fname in os.listdir(d):
        fpath = os.path.join(d, fname)
        if os.path.isfile(fpath) and fname.lower().endswith(('.jpg', '.jpeg', '.png')):
            base_name, _ = os.path.splitext(fname)
            out_name = f"{base_name}.webp"
            out_path = os.path.join(webp_dir, out_name)

            try:
                im = Image.open(fpath)
                
                # If PNG with transparency or logo, save lossless
                if im.mode in ('RGBA', 'LA') or 'logo' in fname.lower() or 'icon' in fname.lower():
                    im.save(out_path, 'WEBP', lossless=True, quality=100, method=6)
                else:
                    # Convert to RGB if needed
                    if im.mode != 'RGB':
                        im = im.convert('RGB')
                    # High-fidelity near-lossless 95%
                    im.save(out_path, 'WEBP', quality=95, method=6)

                orig_size = os.path.getsize(fpath)
                new_size = os.path.getsize(out_path)
                converted[fname] = {
                    'original': fpath,
                    'webp': out_path,
                    'orig_size_kb': round(orig_size / 1024, 1),
                    'webp_size_kb': round(new_size / 1024, 1)
                }
                print(f"Converted {fname} -> {out_name} ({round(orig_size/1024,1)}KB -> {round(new_size/1024,1)}KB)")
            except Exception as e:
                print(f"Error converting {fname}: {e}")

print(f"\nTotal files converted to WebP: {len(converted)}")
