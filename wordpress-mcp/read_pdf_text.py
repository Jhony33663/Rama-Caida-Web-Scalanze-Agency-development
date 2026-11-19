import fitz

doc = fitz.open("C:/Type_b/Clientes/RAMA CAIDA/assets/RAMA_CAIDA_LOGO.pdf")
for i, page in enumerate(doc):
    text = page.get_text()
    print(f"=== PAGE {i+1} ===")
    print(text.strip() if text.strip() else "[No selectable text (likely vectors/shapes)]")
