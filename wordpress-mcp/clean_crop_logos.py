from PIL import Image
import numpy as np

def clean_crop(img_path, output_path, x_min_ratio, x_max_ratio, y_min_ratio, y_max_ratio):
    im = Image.open(img_path).convert('RGBA')
    w, h = im.size
    
    box = (int(w * x_min_ratio), int(h * y_min_ratio), int(w * x_max_ratio), int(h * y_max_ratio))
    sub = im.crop(box)
    
    arr = np.array(sub)
    r, g, b, a = arr[:,:,0], arr[:,:,1], arr[:,:,2], arr[:,:,3]
    
    # Make background transparent (white or near-white)
    white_mask = (r > 240) & (g > 240) & (b > 240)
    arr[white_mask, 3] = 0
    
    res = Image.fromarray(arr)
    bbox = res.getbbox()
    if bbox:
        res = res.crop(bbox)
        # Add 15px padding
        padded = Image.new('RGBA', (res.width + 30, res.height + 30), (0, 0, 0, 0))
        padded.paste(res, (15, 15))
        padded.save(output_path, 'PNG')
        print(f"Saved clean {output_path} ({padded.width}x{padded.height})")
    else:
        print(f"Error finding bbox for {output_path}")

# Page 3 Primary logo (exclude '01' by starting at x=0.22)
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_primary_clean.png', 0.22, 0.85, 0.25, 0.42)

# Page 3 No subtext logo (exclude '02' by starting at x=0.22)
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_no_subtext_clean.png', 0.22, 0.85, 0.45, 0.60)

# Page 3 Isotipo Mango (exclude '03')
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_isotipo_mango_clean.png', 0.35, 0.65, 0.67, 0.88)

# Page 5 Orange logo (exclude swatch text on right by cutting x at 0.52)
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_5_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_orange_clean.png', 0.10, 0.52, 0.65, 0.80)

# Page 5 Yellow logo
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_5_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_yellow_clean.png', 0.10, 0.52, 0.32, 0.47)

# Page 5 Red logo
clean_crop('C:/Type_b/Clientes/RAMA CAIDA/assets/page_5_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_red_clean.png', 0.10, 0.52, 0.49, 0.64)
