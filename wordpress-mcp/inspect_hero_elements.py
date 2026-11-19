import json

with open('runda-kit/templates/home-1.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

def dump_elements(elements, depth=0):
    for el in elements:
        w_type = el.get('widgetType') or el.get('elType')
        settings = el.get('settings', {})
        title = settings.get('title') or settings.get('text') or settings.get('editor')
        color = settings.get('title_color') or settings.get('text_color') or settings.get('custom_text_color') or settings.get('color')
        bg = settings.get('background_color')
        prefix = "  " * depth
        info = f"{prefix}- [{w_type}]"
        if title:
            info += f" text: '{str(title)[:50]}...'"
        if color:
            info += f" color: {color}"
        if bg:
            info += f" bg: {bg}"
        print(info)
        if el.get('elements'):
            dump_elements(el['elements'], depth + 1)

dump_elements(data['content'][0]['elements'])
