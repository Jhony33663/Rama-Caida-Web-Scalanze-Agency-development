<?php
// wordpress-mcp/update_home_carousel.php

// Self-contained helpers for wp eval-file
$webp_map_raw = file_get_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/webp_map.json');
$webp_map = json_decode($webp_map_raw, true);

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

function make_glass_col_local($widgets, $width = 100, $settings = []) {
    $col_classes = isset($settings['css_classes']) ? $settings['css_classes'] : (isset($settings['_css_classes']) ? $settings['_css_classes'] : '');
    $base_settings = [
        'background_background' => 'classic',
        'background_color' => 'rgba(255, 255, 255, 0.90)',
        'border_radius' => ['unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '32', 'right' => '28', 'bottom' => '32', 'left' => '28', 'isLinked' => false],
        'box_shadow_box_shadow_type' => 'yes',
        'box_shadow_box_shadow' => ['horizontal' => 0, 'vertical' => 12, 'blur' => 32, 'spread' => 0, 'color' => 'rgba(0,0,0,0.06)']
    ];
    if (!empty($col_classes)) {
        $base_settings['css_classes'] = $col_classes;
        $base_settings['_css_classes'] = $col_classes;
    }
    return make_col($widgets, $width, array_merge($base_settings, $settings));
}

function make_section($cols, $bg_img = null, $extra_st = []) {
    $sec_classes = isset($extra_st['css_classes']) ? $extra_st['css_classes'] : (isset($extra_st['_css_classes']) ? $extra_st['_css_classes'] : '');
    $st = array_merge([
        'layout' => 'boxed',
        'content_width' => ['unit' => 'px', 'size' => 1200],
        'padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false],
    ], $extra_st);

    if (!empty($sec_classes)) {
        $st['css_classes'] = $sec_classes;
        $st['_css_classes'] = $sec_classes;
    }

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

function make_image_carousel_widget($images, $settings = []) {
    $gallery = [];
    foreach ($images as $img) {
        if ($img && !empty($img['id'])) {
            $gallery[] = [
                'id' => (int)$img['id'],
                'url' => $img['url']
            ];
        }
    }

    $default_settings = [
        'carousel' => $gallery,
        'thumbnail_size' => 'full',
        'slides_to_show' => '3',
        'slides_to_show_tablet' => '2',
        'slides_to_show_mobile' => '1',
        'slides_to_scroll' => '1',
        'image_stretch' => 'yes',
        'navigation' => 'both',
        'autoplay' => 'yes',
        'autoplay_speed' => 3500,
        'infinite' => 'yes',
        'pause_on_hover' => 'yes',
        'pause_on_interaction' => 'yes',
        'effect' => 'slide',
        'speed' => 600,
        '_css_classes' => 'rama-portfolio-carousel',
    ];

    return [
        'id' => substr(md5(uniqid(rand(), true)), 0, 8),
        'elType' => 'widget',
        'widgetType' => 'image-carousel',
        'settings' => array_merge($default_settings, $settings)
    ];
}

$p6_sections = [];

// 1. HERO (bon-o-bon-02)
$p6_hero_widgets = [
    make_heading('Unleash Your Field Marketing Superpowers!', 'h1', 'center', [
        'title_color' => '#ffffff',
        'typography_typography' => 'custom',
        'typography_font_weight' => '800',
    ]),
    make_heading('Libera tus superpoderes de marketing en el campo!', 'h3', 'center', [
        'title_color' => '#f8fafc',
        'typography_typography' => 'custom',
        'typography_font_weight' => '500',
    ]),
    make_button('Explore Our Services', '#services', 'center', [
        'align' => 'center'
    ])
];
$p6_sections[] = make_section(
    [make_col($p6_hero_widgets, 100, [
        '_css_classes' => 'rama-hero-card',
        'margin' => ['unit' => 'px', 'top' => '0', 'right' => 'auto', 'bottom' => '0', 'left' => 'auto', 'isLinked' => false]
    ])],
    get_drive_img('bon-o-bon-02', $webp_map),
    [
        'padding' => ['unit' => 'px', 'top' => '140', 'right' => '20', 'bottom' => '140', 'left' => '20', 'isLinked' => false],
        'content_width' => ['unit' => 'px', 'size' => 1000],
        'gap' => 'no',
        '_css_classes' => 'rama-hero-section'
    ]
);

// 2. OUR SERVICES (3 Harmonized Pillars with Scroll Panel & Aligned CTAs)
$b1_widgets = [
    make_image(get_drive_img('bon-o-bon-05', $webp_map)),
    make_heading('Merchandising & Sales', 'h3', 'left', [
        'title_color' => '#ED6C36',
        '_css_classes' => 'rama-service-title'
    ]),
    make_text('<div class="rama-scroll-panel"><p><strong>Merchandising —</strong> Retail merchandisers are the behind-the-scenes superheroes who turn shelves into captivating storybooks! They master the art of product placement, ensuring every item shines in the spotlight to grab customers’ attention. From eye-catching displays to spot-on inventory management, their mission is simple: make products irresistible, spark buying urges, and supercharge sales!</p><p><strong>Sales Force —</strong> Our dedicated in-store sales team does more than represent your brand—they champion it. By building personal connections and offering deep product insights, they transform everyday shoppers into passionate brand advocates, consistently boosting conversions and building long-term loyalty.</p></div>'),
    make_button('LEARN MORE', '/merchandising-sales/', 'left', ['_css_classes' => 'rama-service-btn'])
];

$b2_widgets = [
    make_image(get_drive_img('santo-domingo-02', $webp_map)),
    make_heading('Street Marketing', 'h3', 'left', [
        'title_color' => '#ED6C36',
        '_css_classes' => 'rama-service-title'
    ]),
    make_text('<div class="rama-scroll-panel"><p><strong>Street Marketing —</strong> Street marketing is a playful, creative advertising method in public spaces that uses eye-catching displays and live demos to engage people, create memorable brand moments, and spark buzz.</p><p><strong>Interactive Marketing —</strong> Interactive marketing sparks two-way fun with interactive kiosks, quizzes, and cool tech, forging deeper connections with consumers.</p><p><strong>Social Media Engagement —</strong> Our street campaigns seamlessly connect offline thrills to online buzz, inspiring real-time sharing, hashtags, and social chatter.</p></div>'),
    make_button('LEARN MORE', '/street-marketing/', 'left', ['_css_classes' => 'rama-service-btn'])
];

$b3_widgets = [
    make_image(get_drive_img('colcafe-02', $webp_map)),
    make_heading('Events', 'h3', 'left', [
        'title_color' => '#ED6C36',
        '_css_classes' => 'rama-service-title'
    ]),
    make_text('<div class="rama-scroll-panel"><p><strong>Pop Up Events —</strong> At Rama Caida, our Pop Up events are vibrant, playful hubs of discovery held at major fairs and events! We bring our exciting product samples right to the final consumer so they can see, touch, and taste before they buy. Each Pop Up booth is stocked with the latest items, featuring brand focus and a modern flair that’s sure to grab attention!</p><p><strong>Sampling Events —</strong> Our sampling events turn curiosity into brand loyalty through tasty, hands-on experiences that leave a lasting impression.</p></div>'),
    make_button('LEARN MORE', '/events/', 'left', ['_css_classes' => 'rama-service-btn'])
];

$p6_sections[] = make_section([
    make_heading('Our Services:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; color: #64748b; font-size: 1.15rem; max-width: 700px; margin: 0 auto;">High-impact in-store, outdoor and experiential solutions across the Northeast US.</p>')
], null, [
    '_css_classes' => 'rama-services-header-section',
    'padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]
]);

$p6_sections[] = make_section([
    make_glass_col_local($b1_widgets, 33.33, ['_css_classes' => 'rama-service-card']),
    make_glass_col_local($b2_widgets, 33.33, ['_css_classes' => 'rama-service-card']),
    make_glass_col_local($b3_widgets, 33.33, ['_css_classes' => 'rama-service-card'])
], null, [
    '_css_classes' => 'rama-services-section',
    'padding' => ['unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false]
]);

// 3. GET TO KNOW US - Vertically Centered & Balanced Proportions
$p6_about_left = [
    make_image(get_drive_img('buen-dia-01', $webp_map))
];
$p6_about_right = [
    make_heading('Get to know us', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>Since 2017, Rama Caida Product Sampling & Brand Awareness has proudly been your go-to partner for turning ordinary brands into truly unforgettable and memorable experiences. Operating across a wide area from Virginia all the way up to Massachusetts, we consistently bring customer excellence to the forefront of everything we do.</p><p>Our playful and energetic spirit drives us to constantly innovate, evolve, and improve, making sure your brand not only reaches people but genuinely delights and engages them every exciting step of the way.</p>'),
    make_button('Learn more', '/get-to-know-us/', 'left')
];
$p6_sections[] = make_section([
    make_col($p6_about_left, 45, [
        'css_classes' => 'rama-about-img-col',
        '_css_classes' => 'rama-about-img-col'
    ]),
    make_glass_col_local($p6_about_right, 55, [
        'css_classes' => 'rama-about-card-col',
        '_css_classes' => 'rama-about-card-col'
    ])
], null, [
    'background_color' => '#f1f5f9',
    'css_classes' => 'rama-about-section',
    '_css_classes' => 'rama-about-section',
    'content_position' => 'middle',
    'padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false]
]);

// 4. CALL TO ACTION (Grab your spot) - Subtle Black Frosted Glass
$p6_cta = [
    make_heading('Grab your spot:', 'h2', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="text-align: center; font-size: 1.2rem; color: #ffffff;">Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p>'),
    make_button('Contact Us', '/contact-us/', 'center')
];
$p6_sections[] = make_section([
    make_col($p6_cta, 100, [
        '_css_classes' => 'rama-cta-glass-card',
        'css_classes' => 'rama-cta-glass-card',
        'background_background' => 'classic',
        'background_color' => 'rgba(0, 0, 0, 0.65)',
        'border_radius' => ['unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '50', 'right' => '40', 'bottom' => '50', 'left' => '40', 'isLinked' => false],
        'margin' => ['unit' => 'px', 'top' => '0', 'right' => 'auto', 'bottom' => '0', 'left' => 'auto', 'isLinked' => false]
    ])
], get_drive_img('santo-domingo-04', $webp_map), [
    'content_width' => ['unit' => 'px', 'size' => 900],
    'padding' => ['unit' => 'px', 'top' => '100', 'right' => '20', 'bottom' => '100', 'left' => '20', 'isLinked' => false]
]);

// 5. PORTFOLIO - CAROUSEL BLOCK (100% Curated, Existing Drive WebP Images)
$portfolio_images = [
    get_drive_img('bon-o-bon-03', $webp_map),
    get_drive_img('colcafe-02', $webp_map),
    get_drive_img('santo-domingo-03', $webp_map),
    get_drive_img('bon-o-bon-07', $webp_map),
    get_drive_img('sello-rojo-01', $webp_map),
    get_drive_img('bon-o-bon-10', $webp_map),
    get_drive_img('santo-domingo-07', $webp_map),
    get_drive_img('buen-dia-02', $webp_map),
    get_drive_img('colcafe-01', $webp_map),
    get_drive_img('bon-o-bon-02', $webp_map),
];

$portfolio_widgets = [
    make_heading('PORTFOLIO:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; color: #64748b; font-size: 1.15rem; max-width: 650px; margin: 0 auto 30px;">Imágenes reales de activaciones, eventos de degustación y equipo en campo.</p>'),
    make_image_carousel_widget($portfolio_images, [
        'slides_to_show' => '3',
        'slides_to_show_tablet' => '2',
        'slides_to_show_mobile' => '1',
        'navigation' => 'both',
        'autoplay' => 'yes',
        'autoplay_speed' => 3500,
        'infinite' => 'yes',
        'pause_on_hover' => 'yes',
        'effect' => 'slide',
        'speed' => 600
    ])
];

$p6_sections[] = make_section([
    make_col($portfolio_widgets, 100, [
        '_css_classes' => 'rama-portfolio-carousel-col'
    ])
], null, [
    '_css_classes' => 'rama-portfolio-section',
    'padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false],
    'content_width' => ['unit' => 'px', 'size' => 1200]
]);

// 6. JOIN THE TEAM
$p6_join_widgets = [
    make_heading('Join the Team:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; font-size: 1.15rem; max-width: 850px; margin: 0 auto;">Are you bursting with personality, overflowing with self-motivation, and absolutely ready to join a vibrant, dynamic team? We’re on the lookout for enthusiastic and energetic individuals to join us in merchandising, sales, and product sampling across the bustling Northeast US and for all you remote work pros who love the flexibility of life in LATAM!</p><p style="text-align: center; font-size: 1.15rem; max-width: 850px; margin: 15px auto 30px;">If you’re passionate, driven, and eager to make a real impact with your talents, we definitely want to hear from you.</p>'),
    make_button('I would like to join the Field Team in the North East !', '/contact-us/', 'center'),
    make_button('¡Deseo aplicar para una posición en LATAM!', '/contact-us/', 'center')
];
$p6_sections[] = make_section([make_col($p6_join_widgets, 100)], null, ['background_color' => '#f1f5f9']);

// Save to Page 6
update_post_meta(6, '_elementor_data', wp_slash(json_encode($p6_sections)));

// Clear element cache
delete_post_meta(6, '_elementor_element_cache');
delete_post_meta(6, '_elementor_css');
delete_post_meta(6, '_elementor_page_assets');

echo "Page 6 successfully updated with interactive Portfolio Carousel!\n";
