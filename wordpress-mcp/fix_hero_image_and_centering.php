<?php
// fix_hero_image_and_centering.php

// 1. UPDATE PAGE 6 (HOME)
$p6Raw = get_post_meta(6, '_elementor_data', true);
$p6Data = json_decode($p6Raw, true);

if (!empty($p6Data)) {
    // Section 0 is Hero
    $sec = &$p6Data[0];
    
    // Set Section 0 settings
    $sec['settings']['layout'] = 'boxed';
    $sec['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
    $sec['settings']['gap'] = 'no';
    $sec['settings']['_css_classes'] = 'rama-hero-section';
    
    // Background image: swap from blurry bon-o-bon-01 (768x1024) to high-res landscape bon-o-bon-02 (1600x902)
    $sec['settings']['background_background'] = 'classic';
    $sec['settings']['background_image'] = [
        'url' => 'http://rama-caida.local/wp-content/uploads/2026/11/bon-o-bon-02.webp',
        'id' => 112
    ];
    $sec['settings']['background_position'] = 'center center';
    $sec['settings']['background_size'] = 'cover';
    $sec['settings']['background_repeat'] = 'no-repeat';
    
    // Subtle dark overlay
    $sec['settings']['background_overlay_background'] = 'classic';
    $sec['settings']['background_overlay_color'] = 'rgba(15, 23, 42, 0.25)';
    $sec['settings']['background_overlay_opacity'] = ['unit' => 'px', 'size' => 0.25];
    
    // Section padding
    $sec['settings']['padding'] = [
        'unit' => 'px',
        'top' => '140',
        'right' => '20',
        'bottom' => '140',
        'left' => '20',
        'isLinked' => false
    ];

    // Column 0 inside Hero
    if (!empty($sec['elements'])) {
        $col = &$sec['elements'][0];
        $col['settings']['_column_size'] = 100;
        $col['settings']['_inline_size'] = 100;
        $col['settings']['margin'] = [
            'unit' => 'px',
            'top' => '0',
            'right' => 'auto',
            'bottom' => '0',
            'left' => 'auto',
            'isLinked' => false
        ];
        $col['settings']['_css_classes'] = 'rama-hero-card';
    }

    update_post_meta(6, '_elementor_data', wp_slash(json_encode($p6Data)));
    echo "Page 6 Hero successfully updated with bon-o-bon-02 (1600x902)!\n";
}

// 2. ALSO UPDATE PAGE 7 HERO (avoid duplicate image, use bon-o-bon-03 1600x1200)
$p7Raw = get_post_meta(7, '_elementor_data', true);
if ($p7Raw) {
    $p7Data = json_decode($p7Raw, true);
    if (!empty($p7Data[0])) {
        $p7Sec = &$p7Data[0];
        $p7Sec['settings']['background_image'] = [
            'url' => 'http://rama-caida.local/wp-content/uploads/2026/11/bon-o-bon-03.webp',
            'id' => 113
        ];
        $p7Sec['settings']['background_position'] = 'center center';
        $p7Sec['settings']['background_size'] = 'cover';
        $p7Sec['settings']['content_width'] = ['unit' => 'px', 'size' => 1000];
        $p7Sec['settings']['_css_classes'] = 'rama-hero-section';
        if (!empty($p7Sec['elements'][0])) {
            $p7Sec['elements'][0]['settings']['_column_size'] = 100;
            $p7Sec['elements'][0]['settings']['_inline_size'] = 100;
            $p7Sec['elements'][0]['settings']['margin'] = [
                'unit' => 'px',
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto',
                'isLinked' => false
            ];
            $p7Sec['elements'][0]['settings']['_css_classes'] = 'rama-hero-card';
        }
        update_post_meta(7, '_elementor_data', wp_slash(json_encode($p7Data)));
        echo "Page 7 Hero updated with bon-o-bon-03 (1600x1200)!\n";
    }
}
