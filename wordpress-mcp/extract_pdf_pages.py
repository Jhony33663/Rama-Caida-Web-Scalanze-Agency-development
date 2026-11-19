import fitz # PyMuPDF
import os

pdf_path = "C:/Type_b/Clientes/RAMA CAIDA/assets/RAMA_CAIDA_LOGO.pdf"
doc = fitz.open(pdf_path)

print(f"Number of pages in {pdf_path}: {len(doc)}")
out_dir = "C:/Type_b/Clientes/RAMA CAIDA/assets/logo_pages"
os.makedirs(out_dir, exist_ok=True)

for i in range(len(doc)):
    page = doc[i]
    # Render page at 300 DPI (approx 4.16x zoom)
    pix = page.get_pixmap(dpi=300)
    out_file = os.path.join(out_dir, f"page_{i+1}.png")
    pix.save(out_file)
    print(f"Saved {out_file} (width: {pix.width}, height: {pix.height})")

    # Also list text on the page
    text = page.get_text()
    if text.strip():
        print(f"Page {i+1} text:\n{text[:300]}...\n")
