<?php
$hRaw = get_post_meta(22, '_elementor_data', true);
$fRaw = get_post_meta(23, '_elementor_data', true);

echo "Header Post 22 length: " . strlen($hRaw) . "\n";
echo "Footer Post 23 length: " . strlen($fRaw) . "\n";

// Search for image widgets or site-logo widgets in Header
$hData = json_decode($hRaw, true);
function find_images($elements, &$found) {
    foreach ($elements as $el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        if ($type === 'image' || $type === 'theme-site-logo' || !empty($el['settings']['image'])) {
            $found[] = [
                'type' => $type,
                'id' => $el['id'],
                'settings' => $el['settings']
            ];
        }
        if (!empty($el['elements'])) {
            find_images($el['elements'], $found);
        }
    }
}

$foundH = [];
find_images($hData, $foundH);
echo "Header images found: " . count($foundH) . "\n";
print_r($foundH);
