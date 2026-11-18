import urllib.request
import os
import fitz  # PyMuPDF

assets_dir = r"C:\Type_b\Clientes\RAMA CAIDA\assets"
os.makedirs(assets_dir, exist_ok=True)

pdf_path = os.path.join(assets_dir, "RAMA_CAIDA_LOGO.pdf")
logo_png_path = os.path.join(assets_dir, "rama-caida-logo.png")

# Download Logo PDF
url = "https://drive.usercontent.google.com/download?id=1c6F5qqhfElEOA9b3gYmfWQn9o3BS59M5&export=download"
print("Downloading RAMA_CAIDA_LOGO.pdf...")
urllib.request.urlretrieve(url, pdf_path)
print(f"Downloaded PDF size: {os.path.getsize(pdf_path)} bytes")

# Convert first page of PDF to 300 DPI transparent PNG
doc = fitz.open(pdf_path)
page = doc[0]
pix = page.get_pixmap(dpi=300, alpha=True)
pix.save(logo_png_path)
print(f"Rendered {logo_png_path} ({pix.width}x{pix.height}) - size: {os.path.getsize(logo_png_path)} bytes")
