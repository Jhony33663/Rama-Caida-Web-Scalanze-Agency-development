import urllib.request

req = urllib.request.Request('http://rama-caida.local/', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')

print("=== VERIFICATION RESULTS ===")
print("1. santo-domingo-02.webp in HTML:", 'santo-domingo-02.webp' in html)
print("2. rama-scroll-panel in HTML:", 'rama-scroll-panel' in html)
print("3. rama-cta-glass-card in HTML:", 'rama-cta-glass-card' in html)
print("4. rama-portfolio-section in HTML:", 'rama-portfolio-section' in html)
print("5. scrollbar-color CSS in HTML:", 'scrollbar-color' in html)
print("6. bon-o-bon-02 (hero) in HTML:", 'bon-o-bon-02.webp' in html)
