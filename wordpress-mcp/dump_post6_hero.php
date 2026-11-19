<?php
$raw = get_post_meta(6, '_elementor_data', true);
$data = json_decode($raw, true);

function dump_post_elements($elements, $depth = 0) {
    foreach ($elements as $el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? 'unknown';
        $settings = $el['settings'] ?? [];
        $title = $settings['title'] ?? $settings['text'] ?? $settings['editor'] ?? '';
        $prefix = str_repeat("  ", $depth);
        if ($title) {
            echo "$prefix- [$type] " . substr(strip_tags($title), 0, 80) . "\n";
        }
        if (!empty($el['elements'])) {
            dump_post_elements($el['elements'], $depth + 1);
        }
    }
}

echo "=== Post 6 Hero Section Elements ===\n";
dump_post_elements($data[0]['elements']);
