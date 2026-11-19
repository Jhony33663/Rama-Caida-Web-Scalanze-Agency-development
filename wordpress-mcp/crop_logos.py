from PIL import Image
import numpy as np

def crop_and_save(img_path, output_path, y_min_ratio, y_max_ratio, x_min_ratio=0.15, x_max_ratio=0.85):
    im = Image.open(img_path).convert('RGBA')
    w, h = im.size
    
    # Sub-crop region
    box = (int(w * x_min_ratio), int(h * y_min_ratio), int(w * x_max_ratio), int(h * y_max_ratio))
    sub = im.crop(box)
    
    # If the background is white, make pure white transparent
    arr = np.array(sub)
    r, g, b, a = arr[:,:,0], arr[:,:,1], arr[:,:,2], arr[:,:,3]
    
    # White background threshold
    white_mask = (r > 240) & (g > 240) & (b > 240)
    arr[white_mask, 3] = 0
    
    res = Image.fromarray(arr)
    # Autocrop transparent borders
    bbox = res.getbbox()
    if bbox:
        res = res.crop(bbox)
        # Add a comfortable padding of 20px
        padded = Image.new('RGBA', (res.width + 40, res.height + 40), (0, 0, 0, 0))
        padded.paste(res, (20, 20))
        padded.save(output_path, 'PNG')
        print(f"Saved {output_path} (size: {padded.size})")
    else:
        print(f"Could not find bounding box for {output_path}")

# On Page 3:
# Top logo (01) is between y=0.25 and y=0.42
crop_and_save('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_primary_transparent.png', 0.25, 0.42)

# Logo without subtext (02) is between y=0.45 and y=0.60
crop_and_save('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_no_subtext.png', 0.45, 0.60)

# Isotipo mango (03) is between y=0.65 and y=0.88
crop_and_save('C:/Type_b/Clientes/RAMA CAIDA/assets/page_3_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_isotipo_mango.png', 0.65, 0.88)

# On Page 5:
# 4th logo is Orange (Variante Naranja ED6C36): between y=0.64 and y=0.80
crop_and_save('C:/Type_b/Clientes/RAMA CAIDA/assets/page_5_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_orange_transparent.png', 0.64, 0.80)

# 1st logo on page 5: Primary Green/Orange
crop_and_save('C:/Type_b/Clientes/RAMA CAIDA/assets/page_5_alpha.png', 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_primary_tight.png', 0.18, 0.33)
