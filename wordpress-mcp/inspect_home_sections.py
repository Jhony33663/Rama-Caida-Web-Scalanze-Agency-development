import json

with open('runda-kit/templates/home-1.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

for idx, sec in enumerate(data['content'][:5]):
    settings = sec.get('settings', {})
    bg = settings.get('background_background')
    bg_color = settings.get('background_color')
    bg_img = settings.get('background_image')
    margin = settings.get('margin')
    padding = settings.get('padding')
    print(f"Section {idx}: bg={bg}, color={bg_color}, img={bool(bg_img)}, margin={margin}, padding={padding}")
