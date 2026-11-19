<?php
// build_fresh_pages_from_md.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

// Load drive webp map
$webp_map = json_decode(file_get_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/webp_map.json'), true);

function get_drive_img($name, $webp_map) {
    $clean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
    if (isset($webp_map[$clean])) {
        return $webp_map[$clean];
    }
    // Fallback search
    foreach ($webp_map as $k => $v) {
        if (strpos($k, $clean) !== false) {
            return $v;
        }
    }
    return ['url' => '', 'id' => 0];
}

$orange_logo = get_drive_img('logo_orange_clean', $webp_map);
$mango_iso = get_drive_img('logo_isotipo_mango_clean', $webp_map);

echo "Orange logo: {$orange_logo['url']}\n";
echo "Mango Isotipo: {$mango_iso['url']}\n";

// Helper to create Elementor widgets
function make_heading($title, $tag = 'h2', $align = 'left', $extra = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'heading',
        'settings' => array_merge([
            'title' => $title,
            'header_size' => $tag,
            'align' => $align,
        ], $extra)
    ];
}

function make_text($content, $extra = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'text-editor',
        'settings' => array_merge([
            'editor' => $content
        ], $extra)
    ];
}

function make_button($text, $url = '#', $align = 'left', $extra = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'button',
        'settings' => array_merge([
            'text' => $text,
            'link' => ['url' => $url, 'is_external' => false, 'nofollow' => false],
            'align' => $align,
            'button_type' => 'default'
        ], $extra)
    ];
}

function make_image($img_info, $size = 'large', $extra = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'image',
        'settings' => array_merge([
            'image' => [
                'url' => $img_info['url'],
                'id' => $img_info['id']
            ],
            'image_size' => $size,
        ], $extra)
    ];
}

function make_icon_box($title, $description, $icon = 'fas fa-star', $extra = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'icon-box',
        'settings' => array_merge([
            'selected_icon' => ['value' => $icon, 'library' => 'fa-solid'],
            'title_text' => $title,
            'description_text' => $description,
            'position' => 'left'
        ], $extra)
    ];
}

function make_col($widgets, $width = 100, $settings = []) {
    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'column',
        'settings' => array_merge([
            '_column_size' => $width,
            '_inline_size' => $width
        ], $settings),
        'elements' => $widgets
    ];
}

function make_section($cols, $bg_img = null, $extra_st = []) {
    $st = array_merge([
        'layout' => 'boxed',
        'content_width' => ['unit' => 'px', 'size' => 1200],
        'padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false],
    ], $extra_st);

    if ($bg_img && !empty($bg_img['url'])) {
        $st['background_background'] = 'classic';
        $st['background_image'] = [
            'url' => $bg_img['url'],
            'id' => $bg_img['id']
        ];
        $st['background_position'] = 'center center';
        $st['background_size'] = 'cover';
        $st['background_overlay_background'] = 'classic';
        $st['background_overlay_color'] = 'rgba(15, 23, 42, 0.20)';
        $st['background_overlay_opacity'] = ['unit' => 'px', 'size' => 0.20];
    }

    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'section',
        'isInner' => false,
        'settings' => $st,
        'elements' => $cols
    ];
}

echo "Helper functions initialized.\n";
