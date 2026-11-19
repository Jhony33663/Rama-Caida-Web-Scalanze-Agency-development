<?php
// update_home_page6_harmony.php
require_once 'C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/build_fresh_pages_from_md.php';

$webp_map_raw = file_get_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/webp_map.json');
$webp_map = json_decode($webp_map_raw, true);

function make_glass_col_local($widgets, $width = 100, $settings = []) {
    return make_col($widgets, $width, array_merge([
        'background_background' => 'classic',
        'background_color' => 'rgba(255, 255, 255, 0.90)',
        'border_radius' => ['unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '32', 'right' => '28', 'bottom' => '32', 'left' => '28', 'isLinked' => false],
        'box_shadow_box_shadow_type' => 'yes',
        'box_shadow_box_shadow' => ['horizontal' => 0, 'vertical' => 12, 'blur' => 32, 'spread' => 0, 'color' => 'rgba(0,0,0,0.06)']
    ], $settings));
}

$p6_sections = [];

// 1. HERO (Centered & high-res bon-o-bon-02)
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

// 2. OUR SERVICES (3 Bloques)
$p6_service_header = [
    make_heading('Our Services:', 'h2', 'center', ['title_color' => '#0A5F2D', 'typography_font_weight' => '800'])
];
$p6_sections[] = make_section([make_col($p6_service_header, 100)], null, [
    'padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]
]);

// 3 Blocks Columns with uniform 240px image dimensions and scroll panels
$b1_widgets = [
    make_image(get_drive_img('bon-o-bon-05', $webp_map)),
    make_heading('Merchandising & Sales', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<div class="rama-scroll-panel"><p><strong>Merchandising —</strong> Retail merchandisers are the behind-the-scenes superheroes who turn shelves into captivating storybooks! They master the art of product placement, ensuring every item shines in the spotlight to grab customers’ attention. From eye-catching displays to spot-on inventory management, their mission is to create an irresistible shopping experience that boosts sales and sparks brand love. Think of them as the creative matchmakers between products and people making shopping fun, easy, and impossible to resist!</p><p><strong>Neuro Sales —</strong> At Rama Caida Product Sampling & Brand Awareness, we use neuromarketing strategies to create irresistible merchandising and sales experiences that captivate the brain and boost both brand awareness and sales. By tapping into unconscious triggers, we craft product displays and packaging that stimulate sensory appeal like vibrant colors, tactile textures, and engaging scents sparking instant emotional connections.</p></div>'),
    make_button('Learn More', '/merchandising-sales/', 'left')
];

$b2_widgets = [
    make_image(get_drive_img('santo-domingo-02', $webp_map)),
    make_heading('Street Marketing', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<div class="rama-scroll-panel"><p><strong>Street Marketing —</strong> Street marketing is a playful, creative advertising method in public spaces that uses eye-catching displays and live demos to engage people, create memorable brand moments, and spark buzz.</p><p><strong>Interactive Marketing —</strong> Interactive marketing sparks two-way fun with personalized content, quizzes, games, and social media, boosting engagement and brand love.</p><p><em>360 Booths, Street Fairs Pop Up game booths and others.</em></p></div>'),
    make_button('Learn More', '/street-marketing/', 'left')
];

$b3_widgets = [
    make_image(get_drive_img('colcafe-02', $webp_map)),
    make_heading('Events', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<div class="rama-scroll-panel"><p><strong>Pop Up Events —</strong> At Rama Caida, our Pop Up events are vibrant, playful hubs of discovery held at major fairs and events! We bring our exciting product samples right to the final consumer so they can see, touch, and taste before they buy. Each Pop Up booth is stocked with the latest items, featuring brand focus and friendly experts ready to answer any questions.</p><p><strong>Retail Activations (Demos) —</strong> At Rama Caida Product Sampling & Brand Awareness, we bring your brand to life right where it matters in retail spaces! Our retail sampling and activation services are designed to create joyful, interactive experiences that not only introduce consumers to your products but also make a lasting impression.</p></div>'),
    make_button('Learn More', '/events/', 'left')
];

$p6_sections[] = make_section([
    make_glass_col_local($b1_widgets, 33.33, ['_css_classes' => 'rama-service-card']),
    make_glass_col_local($b2_widgets, 33.33, ['_css_classes' => 'rama-service-card']),
    make_glass_col_local($b3_widgets, 33.33, ['_css_classes' => 'rama-service-card'])
], null, [
    '_css_classes' => 'rama-services-section',
    'padding' => ['unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false]
]);

// 3. GET TO KNOW US
$p6_about_left = [
    make_image(get_drive_img('buen-dia-01', $webp_map))
];
$p6_about_right = [
    make_heading('Get to know us', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>Since 2017, Rama Caida Product Sampling & Brand Awareness has proudly been your go-to partner for turning ordinary brands into truly unforgettable and memorable experiences. Operating across a wide area from Virginia all the way up to Massachusetts, we consistently bring customer excellence to the forefront of everything we do.</p><p>Our playful and energetic spirit drives us to constantly innovate, evolve, and improve, making sure your brand not only reaches people but genuinely delights and engages them every exciting step of the way.</p>'),
    make_button('Learn more', '/get-to-know-us/', 'left')
];
$p6_sections[] = make_section([
    make_col($p6_about_left, 45),
    make_glass_col_local($p6_about_right, 55)
], null, ['background_color' => '#f1f5f9']);

// 4. CALL TO ACTION (Grab your spot) - Subtle Black Frosted Glass
$p6_cta = [
    make_heading('Grab your spot:', 'h2', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="text-align: center; font-size: 1.2rem; color: #ffffff;">Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p>'),
    make_button('Contact Us', '/contact-us/', 'center')
];
$p6_sections[] = make_section([
    make_col($p6_cta, 100, [
        '_css_classes' => 'rama-cta-glass-card',
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

// 5. PORTFOLIO - Symmetrical 2x3 Collage
$p6_port_head = [
    make_heading('PORTFOLIO:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; color: #64748b;">Imágenes de activaciones, eventos y equipo en campo.</p>')
];
$p6_sections[] = make_section([make_col($p6_port_head, 100)], null, [
    'padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]
]);

$p6_port_row1 = [
    make_col([make_image(get_drive_img('bon-o-bon-03', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col']),
    make_col([make_image(get_drive_img('bon-o-bon-07', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col']),
    make_col([make_image(get_drive_img('bon-o-bon-10', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col'])
];
$p6_port_row2 = [
    make_col([make_image(get_drive_img('colcafe-02', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col']),
    make_col([make_image(get_drive_img('santo-domingo-03', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col']),
    make_col([make_image(get_drive_img('sello-rojo-01', $webp_map))], 33.33, ['_css_classes' => 'rama-portfolio-col'])
];
$p6_sections[] = make_section($p6_port_row1, null, [
    '_css_classes' => 'rama-portfolio-section',
    'padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]
]);
$p6_sections[] = make_section($p6_port_row2, null, [
    '_css_classes' => 'rama-portfolio-section',
    'padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]
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
echo "Page 6 successfully updated with services harmony, scroll panel, subtle black frosted glass CTA, and symmetrical portfolio collage!\n";
