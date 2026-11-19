import urllib.request
import re

req = urllib.request.Request('http://rama-caida.local/', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')

p1 = html.find('Our Services:')
p2 = html.find('Get to know us')
if p1 != -1 and p2 != -1:
    imgs = re.findall(r'<img[^>]+src="([^"]+)"', html[p1:p2])
    print("Services images found:", imgs)

p3 = html.find('PORTFOLIO:')
p4 = html.find('Join the Team:')
if p3 != -1 and p4 != -1:
    imgs_port = re.findall(r'<img[^>]+src="([^"]+)"', html[p3:p4])
    print("Portfolio images found:", imgs_port)
