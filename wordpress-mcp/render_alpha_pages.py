import fitz
from PIL import Image

doc = fitz.open("C:/Type_b/Clientes/RAMA CAIDA/assets/RAMA_CAIDA_LOGO.pdf")

# Page 3 has:
# 01 Full logo (Rama in green, mango C, PRODUCT SAMPLING)
# 02 Logo without subtext
# 03 Isotipo (Mango C)
# Page 5 has:
# Variantes cromáticas:
# 1st: Green with mango C
# 2nd: Yellow
# 3rd: Red
# 4th: Orange
# 5th: Gray

print("Rendering page 3 and page 5 with transparent background...")
for pno in [3, 5, 6]:
    page = doc[pno - 1]
    pix = page.get_pixmap(dpi=300, alpha=True)
    pix.save(f"C:/Type_b/Clientes/RAMA CAIDA/assets/page_{pno}_alpha.png")
    print(f"Saved page_{pno}_alpha.png")
