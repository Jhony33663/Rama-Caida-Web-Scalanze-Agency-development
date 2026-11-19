from PIL import Image

logos = [
    'logo_orange_clean',
    'logo_primary_clean',
    'logo_isotipo_mango_clean',
    'logo_no_subtext_clean'
]

for name in logos:
    src = f"C:/Type_b/Clientes/RAMA CAIDA/assets/{name}.png"
    dst = f"C:/Type_b/Clientes/RAMA CAIDA/assets/webp_all/{name}.webp"
    im = Image.open(src)
    im.save(dst, 'WEBP', lossless=True, quality=100)
    print(f"Saved {dst}")
