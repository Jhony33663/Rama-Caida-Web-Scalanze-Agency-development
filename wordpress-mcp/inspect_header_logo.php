<?php
$raw = get_post_meta(22, '_elementor_data', true);
$data = json_decode($raw, true);

function find_image_widgets($elements) {
    $found = [];
    foreach ($elements as $el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        if ($type === 'image' || $type === 'theme-site-logo' || $type === 'site-logo') {
            $found[] = $el;
        }
        if (!empty($el['elements'])) {
            $found = array_merge($found, find_image_widgets($el['elements']));
        }
    }
    return $found;
}

$images = find_image_widgets($data);
echo "Found " . count($images) . " image widgets in Header (post 22):\n";
foreach ($images as $img) {
    echo "ID: " . $img['id'] . "\n";
    echo "Settings:\n";
    print_r($img['settings'] ?? []);
}
