import os
from PIL import Image

in_dir = "C:/Type_b/Clientes/RAMA CAIDA/assets/logo_pages"
out_dir = "C:/Type_b/Clientes/RAMA CAIDA/assets/logo_pages_thumbs"
os.makedirs(out_dir, exist_ok=True)

for i in range(1, 14):
    in_file = os.path.join(in_dir, f"page_{i}.png")
    if os.path.exists(in_file):
        im = Image.open(in_file)
        im_thumb = im.resize((600, 600))
        out_file = os.path.join(out_dir, f"page_{i}_thumb.png")
        im_thumb.save(out_file)
        # Check dominant colors
        colors = im.getcolors(maxcolors=1000000)
        # Sort by count
        if colors:
            colors.sort(key=lambda x: x[0], reverse=True)
            top_colors = [c[1] for c in colors[:5]]
            print(f"Page {i}: top colors = {top_colors}")
