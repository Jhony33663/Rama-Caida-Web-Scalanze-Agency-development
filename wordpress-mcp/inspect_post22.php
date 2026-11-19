<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

$raw = get_post_meta(22, '_elementor_data', true);
$data = json_decode($raw, true);

function dump_styles($els, $depth = 0) {
    foreach ($els as $el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        $id = $el['id'] ?? '';
        $st = $el['settings'] ?? [];
        $bg = $st['background_color'] ?? $st['background_background'] ?? '';
        $custom_css = $st['custom_css'] ?? '';
        $classes = $st['_css_classes'] ?? '';
        
        echo str_repeat("  ", $depth) . "[$type] ID: $id";
        if ($bg) echo " | BG: " . json_encode($bg);
        if ($classes) echo " | Classes: $classes";
        if (!empty($st['background_color'])) echo " | Color: " . $st['background_color'];
        echo "\n";
        
        if (!empty($el['elements'])) {
            dump_styles($el['elements'], $depth + 1);
        }
    }
}

dump_styles($data);
