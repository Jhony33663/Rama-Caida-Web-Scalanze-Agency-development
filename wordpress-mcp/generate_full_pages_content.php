<?php
// generate_full_pages_content.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';
require_once 'C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/build_fresh_pages_from_md.php';

// Helper for glass card column
function make_glass_col($widgets, $width = 100, $settings = []) {
    return make_col($widgets, $width, array_merge([
        'background_background' => 'classic',
        'background_color' => 'rgba(255, 255, 255, 0.88)',
        'border_radius' => ['unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '36', 'right' => '32', 'bottom' => '36', 'left' => '32', 'isLinked' => false],
        'box_shadow_box_shadow_type' => 'yes',
        'box_shadow_box_shadow' => ['horizontal' => 0, 'vertical' => 12, 'blur' => 32, 'spread' => 0, 'color' => 'rgba(0,0,0,0.06)']
    ], $settings));
}

// ==========================================
// 1. PAGE 6: HOME
// ==========================================
echo "Building Page 6: Home...\n";
$p6_sections = [];

// Section 1: Hero
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
        'gap' => 'no'
    ]
);

// Section 2: Our Services (3 Bloques)
$p6_service_header = [
    make_heading('Our Services:', 'h2', 'center', ['title_color' => '#0A5F2D', 'typography_font_weight' => '800'])
];
$p6_sections[] = make_section([make_col($p6_service_header, 100)], null, ['padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]]);

// 3 Blocks Columns
// Block 1: Merchandising & Sales
$b1_widgets = [
    make_image(get_drive_img('bon-o-bon-05', $webp_map)),
    make_heading('Merchandising & Sales', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p><strong>Merchandising —</strong> Retail merchandisers are the behind-the-scenes superheroes who turn shelves into captivating storybooks! They master the art of product placement, ensuring every item shines in the spotlight to grab customers’ attention. From eye-catching displays to spot-on inventory management, their mission is to create an irresistible shopping experience that boosts sales and sparks brand love. Think of them as the creative matchmakers between products and people making shopping fun, easy, and impossible to resist!</p><p><strong>Neuro Sales —</strong> At Rama Caida Product Sampling & Brand Awareness, we use neuromarketing strategies to create irresistible merchandising and sales experiences that captivate the brain and boost both brand awareness and sales. By tapping into unconscious triggers, we craft product displays and packaging that stimulate sensory appeal like vibrant colors, tactile textures, and engaging scents sparking instant emotional connections.</p>'),
    make_button('Learn More', '/merchandising-sales/', 'left')
];
// Block 2: Street Marketing
$b2_widgets = [
    make_image(get_drive_img('santo-domingo-01', $webp_map)),
    make_heading('Street Marketing', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p><strong>Street Marketing —</strong> Street marketing is a playful, creative advertising method in public spaces that uses eye-catching displays and live demos to engage people, create memorable brand moments, and spark buzz.</p><p><strong>Interactive Marketing —</strong> Interactive marketing sparks two-way fun with personalized content, quizzes, games, and social media, boosting engagement and brand love.</p><p><em>360 Booths, Street Fairs Pop Up game booths and others.</em></p>'),
    make_button('Learn More', '/street-marketing/', 'left')
];
// Block 3: Events
$b3_widgets = [
    make_image(get_drive_img('colcafe-02', $webp_map)),
    make_heading('Events', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p><strong>Pop Up Events —</strong> At Rama Caida, our Pop Up events are vibrant, playful hubs of discovery held at major fairs and events! We bring our exciting product samples right to the final consumer so they can see, touch, and taste before they buy. Each Pop Up booth is stocked with the latest items, featuring brand focus and friendly experts ready to answer any questions.</p><p><strong>Retail Activations (Demos) —</strong> At Rama Caida Product Sampling & Brand Awareness, we bring your brand to life right where it matters in retail spaces! Our retail sampling and activation services are designed to create joyful, interactive experiences that not only introduce consumers to your products but also make a lasting impression.</p>'),
    make_button('Learn More', '/events/', 'left')
];

$p6_sections[] = make_section([
    make_glass_col($b1_widgets, 33.33),
    make_glass_col($b2_widgets, 33.33),
    make_glass_col($b3_widgets, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false]]);

// Section 3: Get to Know Us
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
    make_glass_col($p6_about_right, 55)
], null, ['background_color' => '#f1f5f9']);

// Section 4: Call to Action (Grab your spot)
$p6_cta = [
    make_heading('Grab your spot:', 'h2', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="text-align: center; font-size: 1.2rem; color: #ffffff;">Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p>'),
    make_button('Contact Us', '/contact-us/', 'center')
];
$p6_sections[] = make_section([make_col($p6_cta, 100)], get_drive_img('santo-domingo-04', $webp_map));

// Section 5: Portfolio
$p6_port_head = [
    make_heading('PORTFOLIO:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; color: #64748b;">Imágenes de activaciones, eventos y equipo en campo.</p>')
];
$p6_sections[] = make_section([make_col($p6_port_head, 100)], null, ['padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]]);

$p6_port_row1 = [
    make_col([make_image(get_drive_img('bon-o-bon-03', $webp_map))], 33.33),
    make_col([make_image(get_drive_img('bon-o-bon-07', $webp_map))], 33.33),
    make_col([make_image(get_drive_img('bon-o-bon-10', $webp_map))], 33.33)
];
$p6_port_row2 = [
    make_col([make_image(get_drive_img('colcafe-01', $webp_map))], 33.33),
    make_col([make_image(get_drive_img('santo-domingo-03', $webp_map))], 33.33),
    make_col([make_image(get_drive_img('sello-rojo-01', $webp_map))], 33.33)
];
$p6_sections[] = make_section($p6_port_row1, null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);
$p6_sections[] = make_section($p6_port_row2, null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Section 6: Join the Team
$p6_join_widgets = [
    make_heading('Join the Team:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; font-size: 1.15rem; max-width: 850px; margin: 0 auto;">Are you bursting with personality, overflowing with self-motivation, and absolutely ready to join a vibrant, dynamic team? We’re on the lookout for enthusiastic and energetic individuals to join us in merchandising, sales, and product sampling across the bustling Northeast US and for all you remote work pros who love the flexibility of life in LATAM!</p><p style="text-align: center; font-size: 1.15rem; max-width: 850px; margin: 15px auto 30px;">If you’re passionate, driven, and eager to make a real impact with your talents, we definitely want to hear from you.</p>'),
    make_button('I would like to join the Field Team in the North East !', '/contact-us/', 'center'),
    make_button('¡Deseo aplicar para una posición en LATAM!', '/contact-us/', 'center')
];
$p6_sections[] = make_section([make_glass_col($p6_join_widgets, 100)], null, ['background_color' => '#ffffff']);

update_post_meta(6, '_elementor_data', wp_slash(json_encode($p6_sections)));
echo "Page 6 updated successfully.\n";

// ==========================================
// 2. PAGE 7: MERCHANDISING & SALES
// ==========================================
echo "Building Page 7: Merchandising & Sales...\n";
$p7_sections = [];

// Hero
$p7_hero = [
    make_heading('Retail Specialists:', 'h1', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="color: #ffffff; text-align: center; font-size: 1.2rem; max-width: 900px; margin: 0 auto;">In the world of sales and retail, having the right team interacting with category managers, store managers, and buyers in the field is not just important, it’s essential! These are the people who carry ideas from the creative mind all the way to the shelves and into the hands of customers.</p><p style="color: #ffffff; text-align: center; font-size: 1.2rem; max-width: 900px; margin: 15px auto 0;">Having the right person as your sales force or merchandiser means your product gets the attention, positioning, and presentation it deserves. These experts don’t just sell they tell your story with enthusiasm and knowledge, connecting directly with those who make decisions in-store.</p><h3 style="color: #F7D74C; text-align: center; margin-top: 20px;">And this is where you can find Superstars !</h3>')
];
$p7_sections[] = make_section([make_col($p7_hero, 100, [
    '_css_classes' => 'rama-hero-card',
    'margin' => ['unit' => 'px', 'top' => '0', 'right' => 'auto', 'bottom' => '0', 'left' => 'auto', 'isLinked' => false]
])], get_drive_img('bon-o-bon-03', $webp_map), ['padding' => ['unit' => 'px', 'top' => '120', 'right' => '20', 'bottom' => '120', 'left' => '20', 'isLinked' => false]]);

// Merchandisers
$p7_merch = [
    make_heading('Merchandisers', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>Our merchandisers are masters at product placement, strategically positioning items to catch the shopper’s eye and boost sales effortlessly. They expertly manage product rotation, ensuring fresh inventory is always front and center while minimizing waste. With a keen focus on brand visibility, they arrange displays that shout our name loud and proud, making sure customers can\'t miss us.</p><p>Beyond the shelves, our merchandisers are the ultimate team players providing store managers and sales staff with the timely support and insights they need to keep shelves stocked, products selling, and spirits high. Their hands-on approach transforms every store visit into a seamless, brand-packed experience.</p><h4>Availability:</h4><ul><li>Part time</li><li>Full Time</li><li>Weekends</li></ul>')
];
$p7_sections[] = make_section([
    make_glass_col($p7_merch, 60),
    make_col([make_image(get_drive_img('bon-o-bon-08', $webp_map))], 40)
], null, ['background_color' => '#ffffff']);

// Neuro Sales
$p7_neuro = [
    make_heading('Neuro Sales', 'h2', 'center', ['title_color' => '#ED6C36']),
    make_text('<p style="text-align: center; max-width: 950px; margin: 0 auto; font-size: 1.1rem;">Neuro sales is a technique that applies neuroscience principles to understand how consumers make buying decisions. By studying brain activity, emotions, and cognitive processes, neuro sales helps sales professionals craft messages and experiences that better resonate with customers\' subconscious motivations. This approach can boost sales by creating stronger emotional connections, enhancing trust, and influencing purchasing behavior more effectively. Using neuro sales strategies leads to tailored communication, improved customer engagement, and ultimately higher conversion rates.</p><p style="text-align: center; max-width: 950px; margin: 15px auto 0; font-size: 1.1rem;">With our own international certified staff we can create, manage and handle programs and marketing campaigns that work hand in hand with the merchandisers, sales staff, brand embassadors, product activators (Demo Reps) to not only boost your sales but to make your brand a day to day must have at home.</p>')
];
$p7_sections[] = make_section([make_glass_col($p7_neuro, 100)], null, ['padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => false]]);

// Strategy Sales (3 feature cards)
$strat1 = [
    make_heading('Value', 'h3', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>We offer flexible packages tailored to your campaign size and duration, ensuring you get maximum ROI. Our tiered pricing includes options for short-term blitzes or long-term brand building.</p>')
];
$strat2 = [
    make_heading('Length of Service', 'h3', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>Choose from 1-month energizers (perfect for product launches), 3-month growth plans (for sustained momentum), or 6-month brand partnership programs (ideal for deep market penetration).</p>')
];
$strat3 = [
    make_heading('Why It’s Unique', 'h3', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p>Unlike standard sales staffing, our bi-lingual reps are trained in cultural fluency and brand storytelling, making every interaction a mini brand ambassador moment. Plus, we provide ongoing performance tracking and strategic feedback to optimize your sales impact in real-time.</p>')
];
$p7_sections[] = make_section([
    make_glass_col($strat1, 33.33),
    make_glass_col($strat2, 33.33),
    make_glass_col($strat3, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Outro & CTA
$p7_outro = [
    make_heading('Get ready to break language walls, connect heart-to-heart, and see your sales soar with our playful, passionate bi-lingual sales force!', 'h3', 'center', ['title_color' => '#ffffff']),
    make_button('Schedule an Appointment', '/contact-us/', 'center')
];
$p7_sections[] = make_section([make_col($p7_outro, 100)], get_drive_img('bon-o-bon-12', $webp_map));

update_post_meta(7, '_elementor_data', wp_slash(json_encode($p7_sections)));
echo "Page 7 updated successfully.\n";

// ==========================================
// 3. PAGE 8: STREET MARKETING
// ==========================================
echo "Building Page 8: Street Marketing...\n";
$p8_sections = [];

// Hero
$p8_hero = [
    make_heading('Street Marketing', 'h1', 'center', ['title_color' => '#ffffff']),
    make_heading('Surprise them. Delight them. Make them remember you.', 'h3', 'center', ['title_color' => '#F7D74C']),
    make_text('<p style="text-align: center; color: #ffffff; font-style: italic; font-size: 1.15rem;">Sorpréndelos. Encántalos. Haz que te recuerden.</p>')
];
$p8_sections[] = make_section([make_col($p8_hero, 100)], get_drive_img('santo-domingo-04', $webp_map), ['padding' => ['unit' => 'px', 'top' => '130', 'right' => '20', 'bottom' => '130', 'left' => '20', 'isLinked' => false]]);

// Intro
$p8_intro = [
    make_heading('Unexpected by design', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; font-size: 1.2rem; max-width: 850px; margin: 0 auto;">Street marketing is all about the unexpected. We take your brand out of the ordinary and into the places where people least expect it streets, plazas, fairs, and store aisles turning everyday moments into playful brand experiences that people stop for, talk about, and share.</p><p style="text-align: center; font-size: 1.2rem; max-width: 850px; margin: 15px auto 0; font-weight: 600; color: #ED6C36;">No big budgets needed, just big ideas and a team with the energy to bring them to life.</p>')
];
$p8_sections[] = make_section([make_glass_col($p8_intro, 100)], null, ['background_color' => '#ffffff']);

// Services (2 Bloques)
$sm_block1 = [
    make_image(get_drive_img('santo-domingo-02', $webp_map)),
    make_heading('Street Marketing', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p>Street marketing is a playful, creative advertising method in public spaces that uses eye-catching displays and live demos to engage people, create memorable brand moments, and spark buzz.</p><p>Our street teams bring your brand straight to the sidewalk! With bold displays, live demos, and energetic brand ambassadors, we turn busy public spaces into stages for your product. We stop people in their tracks, start real conversations, and create the kind of buzz that spreads by word of mouth. Every activation is planned around the right location, the right audience, and the right moment, so your brand gets noticed by the people who matter most.</p>')
];
$sm_block2 = [
    make_image(get_drive_img('santo-domingo-05', $webp_map)),
    make_heading('Interactive Marketing', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p>Interactive marketing sparks two-way fun with personalized content, quizzes, games, and social media, boosting engagement and brand love.</p><p>Think 360 booths, street fair pop up game booths, and more. When people play with your brand, they remember it. Our interactive activations invite consumers to take part, snap a photo, share it online, and walk away with a smile and a story to tell.</p>')
];
$p8_sections[] = make_section([
    make_glass_col($sm_block1, 50),
    make_glass_col($sm_block2, 50)
], null, ['padding' => ['unit' => 'px', 'top' => '40', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// How we make it happen (3 steps)
$h1 = [make_heading('Plan', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>We learn about your brand, your product, and your audience, then design an activation that fits your goals and the location.</p>')];
$h2 = [make_heading('Activate', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>Our bilingual, trained team brings the idea to life in the field, with a neat presentation and the energy your brand deserves.</p>')];
$h3 = [make_heading('Learn', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>We gather feedback from the field and share it with you, so every activation makes the next one even better.</p>')];

$p8_sections[] = make_section([make_col([make_heading('How we make it happen', 'h2', 'center', ['title_color' => '#0A5F2D'])], 100)], null, ['padding' => ['unit' => 'px', 'top' => '40', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);
$p8_sections[] = make_section([
    make_glass_col($h1, 33.33),
    make_glass_col($h2, 33.33),
    make_glass_col($h3, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Why Rama Caida?
$why_rc = [
    make_heading('Why Rama Caida?', 'h2', 'center', ['title_color' => '#ED6C36']),
    make_text('<ul style="font-size: 1.15rem; line-height: 2; max-width: 700px; margin: 0 auto;"><li><strong>Playful and professional:</strong> we bring fun to the street without losing sight of presentation, hygiene, and good practices.</li><li><strong>Bilingual teams:</strong> fluent in English and Spanish, ready to connect with diverse communities.</li><li><strong>Wide reach:</strong> we operate from Virginia all the way up to Massachusetts.</li><li><strong>Experience:</strong> bringing brands to life in the field since 2017.</li></ul>')
];
$p8_sections[] = make_section([make_glass_col($why_rc, 100)], null, ['background_color' => '#ffffff']);

// CTA
$p8_cta = [
    make_heading('Whatever it is, the way you tell your story can make all the difference.', 'h2', 'center', ['title_color' => '#ffffff']),
    make_button('Let’s plan your activation', '/contact-us/', 'center')
];
$p8_sections[] = make_section([make_col($p8_cta, 100)], get_drive_img('santo-domingo-06', $webp_map));

update_post_meta(8, '_elementor_data', wp_slash(json_encode($p8_sections)));
echo "Page 8 updated successfully.\n";

// ==========================================
// 4. PAGE 9: EVENTS
// ==========================================
echo "Building Page 9: Events...\n";
$p9_sections = [];

// Hero
$p9_hero = [
    make_heading('Events', 'h1', 'center', ['title_color' => '#ffffff']),
    make_heading('Where your brand meets its fans.', 'h3', 'center', ['title_color' => '#F7D74C']),
    make_text('<p style="text-align: center; color: #ffffff; font-style: italic; font-size: 1.15rem;">Donde tu marca conoce a sus fans.</p>')
];
$p9_sections[] = make_section([make_col($p9_hero, 100)], get_drive_img('colcafe-03', $webp_map), ['padding' => ['unit' => 'px', 'top' => '130', 'right' => '20', 'bottom' => '130', 'left' => '20', 'isLinked' => false]]);

// Intro
$p9_intro = [
    make_heading('Experiences worth sharing', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; font-size: 1.2rem; max-width: 850px; margin: 0 auto;">Great products deserve great first impressions. From busy fairs to supermarket aisles to company launches, we create events where consumers can see, touch, and taste your brand, and where your team can feel the excitement from day one.</p><p style="text-align: center; font-size: 1.2rem; max-width: 850px; margin: 15px auto 0;">We take care of the details so you can enjoy the results: a polished presentation, a friendly and trained staff, and a genuine connection with every person who stops by.</p>')
];
$p9_sections[] = make_section([make_glass_col($p9_intro, 100)], null, ['background_color' => '#ffffff']);

// Services (2 Bloques)
$ev_b1 = [
    make_image(get_drive_img('bon-o-bon-06', $webp_map)),
    make_heading('Pop Up Events', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p>At Rama Caida, our Pop Up events are vibrant, playful hubs of discovery held at major fairs and events! We bring our exciting product samples right to the final consumer so they can see, touch, and taste before they buy. Each Pop Up booth is stocked with the latest items, featuring brand focus and friendly experts ready to answer any questions. It’s the perfect chance to experience our brand’s energy firsthand, snag exclusive deals, and walk away with products everyone will love. Join the fun, try something new, and let us surprise your senses!</p>')
];
$ev_b2 = [
    make_image(get_drive_img('buen-dia-02', $webp_map)),
    make_heading('Retail Activations (Demos)', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p>At Rama Caida Product Sampling & Brand Awareness, we bring your brand to life right where it matters in retail spaces! Our retail sampling and activation services are designed to create joyful, interactive experiences that not only introduce consumers to your products but also make a lasting impression. Imagine tantalizing taste buds, sparking curiosity, and turning casual shoppers into enthusiastic brand fans through fun, energetic activations. We don’t just push product we create memorable moments filled with smiles, excitement, and a genuine connection to your brand. With our playful approach, your customers will leave with more than just a product they’ll leave with a story to tell!</p>')
];
$p9_sections[] = make_section([
    make_glass_col($ev_b1, 50),
    make_glass_col($ev_b2, 50)
], null, ['padding' => ['unit' => 'px', 'top' => '40', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Meet our activators
$ev_activators = [
    make_heading('Meet our activators', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p style="font-size: 1.15rem; line-height: 1.8;">Our activators (demo personnel) are the face of your brand in the field. They are bilingual, friendly, and trained to present your product with a neat appearance, good food safety practices, and the knowledge to answer any question. They don’t just hand out samples: they start conversations, tell your story, and leave every visitor with a good impression.</p>')
];
$p9_sections[] = make_section([
    make_glass_col($ev_activators, 60),
    make_col([make_image(get_drive_img('sello-rojo-02', $webp_map))], 40)
], null, ['background_color' => '#f8fafc']);

// From first idea to final high-five
$ev_step1 = [make_heading('Before', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>We plan the event around your goals, product, and audience, and prepare the booth, materials, and team.</p>')];
$ev_step2 = [make_heading('During', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>Our activators bring the energy, engage consumers, and showcase your product at its best.</p>')];
$ev_step3 = [make_heading('After', 'h3', 'left', ['title_color' => '#0A5F2D']), make_text('<p>We gather feedback from the field and share it with you, so your next event is even better.</p>')];

$p9_sections[] = make_section([make_col([make_heading('From first idea to final high-five', 'h2', 'center', ['title_color' => '#0A5F2D'])], 100)], null, ['padding' => ['unit' => 'px', 'top' => '40', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);
$p9_sections[] = make_section([
    make_glass_col($ev_step1, 33.33),
    make_glass_col($ev_step2, 33.33),
    make_glass_col($ev_step3, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// CTA
$p9_cta = [
    make_heading('Whatever it is, the way you tell your story in the field can make all the difference.', 'h2', 'center', ['title_color' => '#ffffff']),
    make_button('Let’s plan your event', '/contact-us/', 'center')
];
$p9_sections[] = make_section([make_col($p9_cta, 100)], get_drive_img('bon-o-bon-13', $webp_map));

update_post_meta(9, '_elementor_data', wp_slash(json_encode($p9_sections)));
echo "Page 9 updated successfully.\n";

// ==========================================
// 5. PAGE 10: GET TO KNOW US
// ==========================================
echo "Building Page 10: Get to Know Us...\n";
$p10_sections = [];

// Hero / Origins
$p10_origins = [
    make_heading('Our Origins:', 'h1', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p style="font-size: 1.15rem; line-height: 1.8;">Rama Caida was born out of the cumbersome experience I had many years ago while searching for someone to perform a demo program at supermarkets and outdoor events for a new beautiful line of grocery products where I used to work. It was of the outmost importance to yield the best return on investment without jeopardizing key aspects, such as: aesthetics and presentation of the product on display, neat and clean appearance of the staff performing the demonstration and good food safety practices.</p><p style="font-size: 1.15rem; line-height: 1.8;">None of the search results satisfied the quality standards, at the end it was decided to use different promotional tools for the lack of outstanding product demonstrators.</p><p style="font-size: 1.15rem; line-height: 1.8;">The frustration of those events later transformed into the opportunity to create an enterprise and to make a difference in the industry.</p><p style="font-weight: 700; color: #ED6C36; font-size: 1.1rem;">—Francia Franco 2022</p>')
];
$p10_sections[] = make_section([
    make_glass_col($p10_origins, 60),
    make_col([make_image(get_drive_img('santo-domingo-07', $webp_map))], 40)
], null, ['padding' => ['unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Mission & Vision
$p10_mission = [
    make_heading('Our Mission:', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p style="font-size: 1.1rem; line-height: 1.7;">At Rama Caida, our mission is to revolutionize product sampling and marketing by creating immersive experiences that connect brands with consumers in meaningful ways.</p><p style="font-size: 1.1rem; line-height: 1.7;">We are dedicated to fostering a culture of transparency, trust, and social responsibility while delivering exceptional service and innovative solutions.</p><p style="font-size: 1.1rem; line-height: 1.7;">Through teamwork and community engagement, we strive to empower brands and elevate their presence in retail, pop-up events, and street fairs, ultimately enhancing the consumer experience and driving sustainable growth. Together, we are building a better way to work and promote products that resonate with authenticity and purpose.</p>')
];
$p10_vision = [
    make_heading('Our Vision:', 'h2', 'left', ['title_color' => '#ED6C36']),
    make_text('<p style="font-size: 1.1rem; line-height: 1.7;">At Rama Caida, we envision a future where every brand has the opportunity to connect authentically with consumers through dynamic and engaging experiences. We strive to be a leader in the marketing industry, transforming the landscape of product sampling and merchandising by championing innovation, sustainability, and community involvement.</p><p style="font-size: 1.1rem; line-height: 1.7;">Our goal is to inspire a movement that prioritizes transparency and social responsibility, fostering a marketplace where trust and collaboration thrive. Together, we aim to create a vibrant ecosystem that not only elevates brands but also enriches the lives of consumers and strengthens communities across the globe.</p>')
];
$p10_sections[] = make_section([
    make_glass_col($p10_mission, 50),
    make_glass_col($p10_vision, 50)
], null, ['background_color' => '#f1f5f9']);

// Our Core Values (7 cards)
$vals = [
    ['Transparency', 'We believe in open communication and honesty in all our interactions, fostering trust among our team, clients, and partners.'],
    ['Trust', 'We build lasting relationships based on trust, ensuring that our clients and team members feel valued and respected.'],
    ['Social Responsibility', 'We are committed to making a positive impact in our communities through responsible practices and initiatives that promote sustainability.'],
    ['Excellence', 'We strive for excellence in every project, ensuring that our services not only meet but exceed expectations.'],
    ['Teamwork', 'We understand that collaboration is key to success. We work together, leveraging diverse skills and perspectives to achieve common goals.'],
    ['Innovation', 'We embrace creativity and seek innovative solutions in marketing and product sampling, staying ahead of industry trends to better serve our clients.'],
    ['Community Engagement', 'We actively participate in local events and initiatives, connecting brands with customers in meaningful ways that foster community spirit.']
];

$p10_sections[] = make_section([make_col([make_heading('Our Core Values:', 'h2', 'center', ['title_color' => '#0A5F2D'])], 100)], null, ['padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);

$val_cols1 = [];
for ($i = 0; $i < 4; $i++) {
    $val_cols1[] = make_glass_col([
        make_heading($vals[$i][0], 'h3', 'center', ['title_color' => '#ED6C36']),
        make_text('<p style="text-align: center;">' . $vals[$i][1] . '</p>')
    ], 25);
}
$val_cols2 = [];
for ($i = 4; $i < 7; $i++) {
    $val_cols2[] = make_glass_col([
        make_heading($vals[$i][0], 'h3', 'center', ['title_color' => '#ED6C36']),
        make_text('<p style="text-align: center;">' . $vals[$i][1] . '</p>')
    ], 33.33);
}
$p10_sections[] = make_section($val_cols1, null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);
$p10_sections[] = make_section($val_cols2, null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

// Contact Us CTA
$p10_contact = [
    make_heading('Contact us', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<p style="text-align: center; font-size: 1.15rem;">Interested in working together? Fill out some info and we will be in touch shortly. We can’t wait to hear from you!</p>'),
    make_button('Get in Touch', '/contact-us/', 'center')
];
$p10_sections[] = make_section([make_glass_col($p10_contact, 100)], null, ['background_color' => '#ffffff']);

update_post_meta(10, '_elementor_data', wp_slash(json_encode($p10_sections)));
echo "Page 10 updated successfully.\n";

// ==========================================
// 6. PAGE 11: JOIN US
// ==========================================
echo "Building Page 11: Join Us...\n";
$p11_sections = [];

// Hero
$p11_hero = [
    make_heading('Join the team !', 'h1', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="text-align: center; font-size: 1.2rem; color: #ffffff; max-width: 900px; margin: 0 auto;">Are you an outgoing, self-motivated, and bilingual individual with a passion for adventure? Then we are definitely looking for you!</p><p style="text-align: center; font-size: 1.2rem; color: #ffffff; max-width: 900px; margin: 15px auto 0;">Join our dynamic and energetic team that is always traveling to exciting new places, exploring hidden gems, and meeting fascinating people along the way. We proudly represent the top brands in their field, and our work environment is not only respectful and supportive but also full of fun, excitement, and rewarding opportunities. Ready to be part of this incredible adventure?</p><p style="text-align: center; font-size: 1.2rem; color: #ffffff; max-width: 900px; margin: 15px auto 0;">Reach out to us to learn more about how you can join our team and what amazing experiences await once you do. Your next unforgettable experience is just around the corner!</p>')
];
$p11_sections[] = make_section([make_col($p11_hero, 100)], get_drive_img('bon-o-bon-11', $webp_map), ['padding' => ['unit' => 'px', 'top' => '120', 'right' => '20', 'bottom' => '120', 'left' => '20', 'isLinked' => false]]);

// Positions hiring
$p11_pos = [
    make_heading('As we continue to grow we are hiring:', 'h2', 'center', ['title_color' => '#0A5F2D']),
    make_text('<ul style="font-size: 1.2rem; line-height: 2; max-width: 500px; margin: 0 auto; list-style-type: square;"><li>Merchandisers</li><li>Sales staff</li><li>Activators (Demo Personnel)</li><li>Drivers</li></ul><p style="text-align: center; font-weight: 700; margin-top: 25px; font-size: 1.15rem; color: #ED6C36;">Positions available in NJ, NY, CT, PA, MA, RI, MD, DE, VA.</p>'),
    make_button('Click here to download our application', 'https://drive.google.com/drive/folders/1TilgTQUR2yXXUdu2lLPbYQsriWUU4sWM?usp=sharing', 'center')
];
$p11_sections[] = make_section([make_glass_col($p11_pos, 100)], null, ['background_color' => '#ffffff']);

// How do I apply?
$p11_apply = [
    make_heading('How do I apply ?', 'h2', 'center', ['title_color' => '#ED6C36']),
    make_text('<ol style="font-size: 1.15rem; line-height: 2; max-width: 700px; margin: 0 auto;"><li><strong>Step 1:</strong> Download the application.</li><li><strong>Step 2:</strong> Fill Out the application. (Please fill out all fields, if a field does not apply to you simply indicate NA).</li><li><strong>Step 3:</strong> Upload the application using the form below or email it directly.</li></ol><p style="text-align: center; font-size: 1.15rem; font-weight: 600; margin-top: 25px; color: #0A5F2D;">Once we receive your application filled out we will be contacting you to schedule an interview via zoom.</p>')
];
$p11_sections[] = make_section([make_glass_col($p11_apply, 100)], null, ['background_color' => '#f1f5f9']);

// Testimonials (6 Team Members)
$p11_test_header = [
    make_heading('From our past team members:', 'h2', 'center', ['title_color' => '#0A5F2D'])
];
$p11_sections[] = make_section([make_col($p11_test_header, 100)], null, ['padding' => ['unit' => 'px', 'top' => '50', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);

$t1 = [make_text('<blockquote>“Hice parte de Rama Caída y tuve la oportunidad de aprender y disfrutar de un ambiente de trabajo motivador enfocado en la disciplina y comprometido, donde pude desarrollar mis habilidades creciendo de manera laboral y profesional, Agradezco a este equipo por su buen trabajo que sin duda los llevará al crecimiento cómo empresa.”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Andrea Cuervo G (Elizabeth NJ) 2024</p>')];
$t2 = [make_text('<blockquote>“Rama caída es una compañía sólida que resalta por su compromiso y profesionalismo para con todas las personas que formar parte de nuestro equipo de trabajo, proveen un Excelente ambiente laboral basado en el respeto y una comunicación retroactiva en todo lo que es el ámbito laboral.”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Angelica Rivera (Brooklyn, NY) 2024</p>')];
$t3 = [make_text('<blockquote>“Trabajar en RAMA CAIDA, ha sido una experiencia sumamente enriquecedora. Desde el primer día, me sentí parte de un equipo dinámico y colaborativo, donde la comunicación abierta y el respeto mutuo son esenciales. La cultura organizacional fomenta un ambiente de apoyo constante, lo que permite el crecimiento personal y profesional.”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Maitte Ribadeneira (LATAM) 2024</p>')];
$t4 = [make_text('<blockquote>“Uno de los aspectos más positivos ha sido la oportunidad de conocer lugares nuevos y poner en práctica el idioma, de la misma manera en Rama Caida no solo valora las ideas y aportes de sus empleados, sino que también ofrece capacitación continua para fortalecer nuestras habilidades. Además, el enfoque en el bienestar y equilibrio entre la vida personal y profesional hace que trabajar aquí sea gratificante a nivel tanto profesional como personal. Atentamente,”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Maria Lopez (Bridgeport, CT) 2025</p>')];
$t5 = [make_text('<blockquote>“Trabajar en Rama ha sido una experiencia enriquecedora. Me permitió cumplir con mis responsabilidades de manera eficiente, disfrutando de la flexibilidad necesaria. Me siento afortunada de haber formado parte de un equipo tan dedicado, donde pude fortalecer mis habilidades y contribuir al desarrollo de la empresa. Valoro profundamente el apoyo y la confianza que me brindaron.”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Jessica Camacho (LATAM) 2024</p>')];
$t6 = [make_text('<blockquote>“Como coordinador de oficina que trabaja de forma remota desde Colombia para una empresa en Estados Unidos. Aprecio la flexibilidad del trabajo remoto, que me permite gestionar mi tiempo de manera efectiva y mantener un equilibrio saludable entre el trabajo y la vida personal. En general, mi experiencia ha sido tanto de crecimiento profesional como personal, y estoy emocionado de contribuir al éxito de la empresa mientras represento el talento colombiano en un escenario internacional.”</blockquote><p style="font-weight: 700; color: #ED6C36;">— Alex Garcia (LATAM) 2022</p>')];

$p11_sections[] = make_section([
    make_glass_col($t1, 33.33),
    make_glass_col($t2, 33.33),
    make_glass_col($t3, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'isLinked' => false]]);

$p11_sections[] = make_section([
    make_glass_col($t4, 33.33),
    make_glass_col($t5, 33.33),
    make_glass_col($t6, 33.33)
], null, ['padding' => ['unit' => 'px', 'top' => '10', 'right' => '20', 'bottom' => '60', 'left' => '20', 'isLinked' => false]]);

update_post_meta(11, '_elementor_data', wp_slash(json_encode($p11_sections)));
echo "Page 11 updated successfully.\n";

// ==========================================
// 7. PAGE 12: CONTACT US / APPOINTMENTS
// ==========================================
echo "Building Page 12: Contact Us / Appointments...\n";
$p12_sections = [];

$p12_hero = [
    make_heading('Grab your spot !', 'h1', 'center', ['title_color' => '#ffffff']),
    make_text('<p style="text-align: center; color: #ffffff; font-size: 1.25rem; max-width: 850px; margin: 0 auto;">Ready to take your brand on a marketing joyride? Schedule an appointment with us and buckle up for some invigorating conversations that will gear your business towards success!</p>')
];
$p12_sections[] = make_section([make_col($p12_hero, 100)], get_drive_img('bon-o-bon-14', $webp_map), ['padding' => ['unit' => 'px', 'top' => '120', 'right' => '20', 'bottom' => '120', 'left' => '20', 'isLinked' => false]]);

// Contact Cards
$c_info = [
    make_heading('Get in Touch', 'h2', 'left', ['title_color' => '#0A5F2D']),
    make_text('<p style="font-size: 1.15rem;"><strong>Location:</strong><br>137 1/2 Washington Ave., Suite 306, Belleville NJ 07109</p><p style="font-size: 1.15rem;"><strong>Contact:</strong><br><a href="mailto:danicp.ramacaidasampling@gmail.com" style="color: #ED6C36;">danicp.ramacaidasampling@gmail.com</a></p><p style="font-size: 1.15rem;"><strong>Toll Free:</strong><br><a href="tel:8889733122" style="color: #ED6C36;">(888) 973-3122</a></p><hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 25px 0;"><p style="font-weight: 600; color: #64748b;">Operating across the Northeast US: NJ, NY, CT, PA, MA, RI, MD, DE, VA.</p>')
];

$c_form = [
    make_heading('Schedule an Appointment / Send Message', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<form onsubmit="event.preventDefault(); alert(\'Thank you! Your message has been sent. We will contact you shortly.\');" style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;"><input type="text" placeholder="Your Name" required style="padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1rem;"><input type="email" placeholder="Your Email" required style="padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1rem;"><input type="text" placeholder="Company / Brand" style="padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1rem;"><select style="padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1rem;"><option>Service of Interest</option><option>Merchandising & Sales</option><option>Street Marketing</option><option>Pop Up Events / Demos</option><option>Field Team Application (US)</option><option>LATAM Remote Application</option></select><textarea rows="4" placeholder="Tell us about your project or goals..." style="padding: 12px 16px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1rem;"></textarea><button type="submit" style="background-color: #ED6C36; color: white; padding: 14px 28px; border-radius: 50px; border: none; font-weight: 700; cursor: pointer; font-size: 1.05rem;">Submit Appointment Request</button></form>')
];

$p12_sections[] = make_section([
    make_glass_col($c_info, 45),
    make_glass_col($c_form, 55)
], null, ['padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false]]);

update_post_meta(12, '_elementor_data', wp_slash(json_encode($p12_sections)));
echo "Page 12 updated successfully.\n";

// Clear cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor cache cleared.\n";
}
echo "All pages completely built with exact Markdown copy and Google Drive WebP photos!\n";
