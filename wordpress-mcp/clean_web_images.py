import os
from PIL import Image

web_dir = r"C:\Type_b\Clientes\RAMA CAIDA\assets\web_images"
valid_images = []

for f in os.listdir(web_dir):
    fp = os.path.join(web_dir, f)
    if os.path.isfile(fp):
        # Check if actually an image
        try:
            with Image.open(fp) as img:
                fmt = img.format
                w, h = img.size
                valid_images.append({
                    'filename': f,
                    'format': fmt,
                    'width': w,
                    'height': h,
                    'size_kb': os.path.getsize(fp) / 1024,
                    'path': fp
                })
        except Exception:
            # Not an image (e.g. css or js bundle)
            os.remove(fp)
            print(f"Removed non-image file: {f}")

print(f"\nTotal authentic images extracted from https://www.ramacaida.us/: {len(valid_images)}")
print("="*85)
print(f"{'Filename':<50} | {'Dimensions':<12} | {'Format':<6} | {'Size':<10}")
print("="*85)
for img in sorted(valid_images, key=lambda x: x['size_kb'], reverse=True):
    dim = str(img['width']) + "x" + str(img['height'])
    print(f"{img['filename']:<50} | {dim:<12} | {img['format']:<6} | {img['size_kb']:7.1f} KB")
