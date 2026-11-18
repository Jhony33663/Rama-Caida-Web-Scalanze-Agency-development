import os
import re
import urllib.request
import urllib.parse

photos_dir = r"C:\Type_b\Clientes\RAMA CAIDA\assets\photos"
os.makedirs(photos_dir, exist_ok=True)

# 1. Bon O Bon photos from earlier scan
bon_o_bon_files = [
  {'id': '12DRTPUkVLQFl_eiK_gTuuWxToJQMbuDT', 'name': 'bon-o-bon-01.jpg'},
  {'id': '18HP1_kzT73waFipUi1hzDAbQoD1bgHRw', 'name': 'bon-o-bon-02.jpg'},
  {'id': '12Qt7iaaAHOh00GmG1qSP9CaZ31yHgY1T', 'name': 'bon-o-bon-03.jpg'},
  {'id': '11JktquDF41vmvbrHt_UO6uvOHKFhlCU5', 'name': 'bon-o-bon-04.jpg'},
  {'id': '1sfP39jpQVmVGzPV0yaJvvj5Krem9H3YL', 'name': 'bon-o-bon-05.jpg'},
  {'id': '1T_ER22mdo9oJhtVlqieMTM1clQtMPm0a', 'name': 'bon-o-bon-06.jpg'},
  {'id': '1exALsh2FA8bjfy21NDlvwnGm5vH5Htqq', 'name': 'bon-o-bon-07.jpg'},
  {'id': '17ZTe0QMXJcslF0eDI-aS_CfeGgBpbtMd', 'name': 'bon-o-bon-08.jpg'},
  {'id': '1ANRsGjg3I6XkBeRx7TB7slwpx-WguHey', 'name': 'bon-o-bon-09.jpg'},
  {'id': '1iwxHssFawvX2c7wmgR4W5oMTSgMI4N73', 'name': 'bon-o-bon-10.jpg'},
  {'id': '1Rf6nZge5kQ-RrIBMzdHiBobjrp8CK97Q', 'name': 'bon-o-bon-11.jpg'},
  {'id': '1uWm5vRab47zGj7BUI794AUlMhbE5bMVJ', 'name': 'bon-o-bon-12.jpg'},
  {'id': '1e0bJpulWiST6F3rHF32sCmFRHvDd9Eb6', 'name': 'bon-o-bon-13.jpg'},
  {'id': '1QJof-BCOqG3eyr0svUDqDb8qEp7KOalh', 'name': 'bon-o-bon-14.jpg'}
]

def fetch_folder_photos(folder_id, prefix):
    url = f"https://drive.google.com/drive/folders/{folder_id}"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req) as resp:
            html = resp.read().decode('utf-8', errors='ignore')
    except Exception as e:
        print(f"Error reading folder {folder_id}: {e}")
        return []

    # find files
    matches = re.findall(r'aria-label="([^"]+?\.(?:jpg|jpeg|png|webp|JPG|PNG))[^"]*"[^>]*data-id="([a-zA-Z0-9_-]{25,})"', html, re.I)
    json_matches = re.findall(r'\\x5b\\x22([a-zA-Z0-9_-]{25,})\\x22,\\x5b\\x22[^\\]+\\x22\\x5d,\\x22([^\\"]+\.(?:jpg|jpeg|png|webp|JPG|PNG))\\x22', html, re.I)
    
    files = {}
    for name, fid in matches:
        files[fid] = name
    for fid, name in json_matches:
        files[fid] = name

    results = []
    idx = 1
    for fid, fname in files.items():
        ext = os.path.splitext(fname)[1] or ".jpg"
        results.append({'id': fid, 'name': f"{prefix}-{idx:02d}{ext}"})
        idx += 1
    return results

all_photos = list(bon_o_bon_files)
subfolders = [
    ('1Eeo76Qv7FXqGf5Q3yZjEvmYLs-5aC0aB', 'buen-dia'),
    ('1PXr5jdjNEsqJNZQTdo_LZj6pr2jUH0r0', 'colcafe'),
    ('1HEOx20t35HZvD8GvW24AMSldejvArZlw', 'santo-domingo'),
    ('1cILrkH3Ktmuq8EPCkYdql9Hd82MM0fVU', 'sello-rojo')
]

for fid, prefix in subfolders:
    found = fetch_folder_photos(fid, prefix)
    print(f"Folder {prefix} found {len(found)} photos.")
    all_photos.extend(found)

print(f"Total photos to download: {len(all_photos)}")

downloaded = []
for p in all_photos:
    target_path = os.path.join(photos_dir, p['name'])
    if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
        downloaded.append(target_path)
        continue
    dl_url = f"https://drive.usercontent.google.com/download?id={p['id']}&export=download"
    try:
        urllib.request.urlretrieve(dl_url, target_path)
        if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
            print(f"Downloaded: {p['name']} ({os.path.getsize(target_path)} bytes)")
            downloaded.append(target_path)
        else:
            print(f"Skipped small/empty: {p['name']}")
    except Exception as e:
        print(f"Failed to download {p['name']}: {e}")

print(f"Successfully downloaded {len(downloaded)} campaign photos.")
