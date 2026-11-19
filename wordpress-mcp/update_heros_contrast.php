<?php
// update_heros_contrast.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';
require_once 'C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/build_fresh_pages_from_md.php';

// Helper for hero frosted glass column
function make_hero_glass_col($widgets, $width = 80, $settings = []) {
    return make_col($widgets, $width, array_merge([
        'background_background' => 'classic',
        'background_color' => 'rgba(15, 23, 42, 0.72)',
        'border_radius' => ['unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '48', 'right' => '40', 'bottom' => '48', 'left' => '40', 'isLinked' => false],
        'box_shadow_box_shadow_type' => 'yes',
        'box_shadow_box_shadow' => ['horizontal' => 0, 'vertical' => 16, 'blur' => 40, 'spread' => 0, 'color' => 'rgba(0,0,0,0.25)'],
        '_css_classes' => 'rama-hero-card'
    ], $settings));
}

// 1. UPDATE PAGE 6 HERO
$p6_raw = get_post_meta(6, '_elementor_data', true);
$p6_data = json_decode($p6_raw, true);

if (!empty($p6_data[0]['elements'][0])) {
    // Replace column with frosted glass column
    $hero_widgets = $p6_data[0]['elements'][0]['elements'] ?? [];
    $p6_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 80)];
    $p6_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
    update_post_meta(6, '_elementor_data', wp_slash(json_encode($p6_data)));
    echo "Page 6 Hero wrapped in high-contrast frosted glass container.\n";
}

// 2. UPDATE PAGE 7 HERO
$p7_raw = get_post_meta(7, '_elementor_data', true);
$p7_data = json_decode($p7_raw, true);
if (!empty($p7_data[0]['elements'][0])) {
    $hero_widgets = $p7_data[0]['elements'][0]['elements'] ?? [];
    $p7_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 85)];
    $p7_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1050];
    update_post_meta(7, '_elementor_data', wp_slash(json_encode($p7_data)));
    echo "Page 7 Hero wrapped in high-contrast frosted glass container.\n";
}

// 3. UPDATE PAGE 8 HERO
$p8_raw = get_post_meta(8, '_elementor_data', true);
$p8_data = json_decode($p8_raw, true);
if (!empty($p8_data[0]['elements'][0])) {
    $hero_widgets = $p8_data[0]['elements'][0]['elements'] ?? [];
    $p8_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 80)];
    $p8_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
    update_post_meta(8, '_elementor_data', wp_slash(json_encode($p8_data)));
    echo "Page 8 Hero wrapped in high-contrast frosted glass container.\n";
}

// 4. UPDATE PAGE 9 HERO
$p9_raw = get_post_meta(9, '_elementor_data', true);
$p9_data = json_decode($p9_raw, true);
if (!empty($p9_data[0]['elements'][0])) {
    $hero_widgets = $p9_data[0]['elements'][0]['elements'] ?? [];
    $p9_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 80)];
    $p9_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
    update_post_meta(9, '_elementor_data', wp_slash(json_encode($p9_data)));
    echo "Page 9 Hero wrapped in high-contrast frosted glass container.\n";
}

// 5. UPDATE PAGE 11 HERO
$p11_raw = get_post_meta(11, '_elementor_data', true);
$p11_data = json_decode($p11_raw, true);
if (!empty($p11_data[0]['elements'][0])) {
    $hero_widgets = $p11_data[0]['elements'][0]['elements'] ?? [];
    $p11_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 85)];
    $p11_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1050];
    update_post_meta(11, '_elementor_data', wp_slash(json_encode($p11_data)));
    echo "Page 11 Hero wrapped in high-contrast frosted glass container.\n";
}

// 6. UPDATE PAGE 12 HERO
$p12_raw = get_post_meta(12, '_elementor_data', true);
$p12_data = json_decode($p12_raw, true);
if (!empty($p12_data[0]['elements'][0])) {
    $hero_widgets = $p12_data[0]['elements'][0]['elements'] ?? [];
    $p12_data[0]['elements'] = [make_hero_glass_col($hero_widgets, 80)];
    $p12_data[0]['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
    update_post_meta(12, '_elementor_data', wp_slash(json_encode($p12_data)));
    echo "Page 12 Hero wrapped in high-contrast frosted glass container.\n";
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
echo "All Heros updated with frosted glass contrast.\n";
