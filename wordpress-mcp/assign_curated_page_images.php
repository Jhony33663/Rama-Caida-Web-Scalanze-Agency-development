<?php
// Load all media indexed by filename
$query = new WP_Query([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1
]);

$mediaByFile = [];
$allMedia = [];
foreach ($query->posts as $p) {
    $attached = basename(get_attached_file($p->ID));
    $url = wp_get_attachment_url($p->ID);
    $mediaByFile[$attached] = ['id' => $p->ID, 'url' => $url];
    $allMedia[] = ['id' => $p->ID, 'url' => $url];
}

// Map files for each post
$pageAssignments = [
    // Post 6: Home
    6 => [
        '20221015_125537.jpg',
        'Merche_Stock_pictures.png',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.49.37_34ec0f00.jpg',
        'WhatsApp_Image_2025-07-04_at_08.30.59_765517c3.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.03.02_92e1f4f4.jpg',
        'IMG_6503.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.16.39_bbf77916.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.31.44_9b3b8a09__1_.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.37.38_a9abee95.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.25.03_766a57c0.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.32.51_d66df082.jpg'
    ],
    // Post 7: Merchandising & Sales
    7 => [
        'Merche_Stock_pictures.png',
        'unsplash-image-Zfua-B1WssA.jpg',
        'unsplash-image-oFMI6CdD7yU.jpg',
        'unsplash-image-9_jvKRbNdTM.jpg',
        'bon-o-bon-01.jpg',
        'bon-o-bon-02.jpg'
    ],
    // Post 8: Street Marketing
    8 => [
        'Aro_Ha_0010_1.jpg',
        'image-asset__7_.jpeg',
        'image-asset__2_.jpeg',
        'AroHa_02.jpg',
        'bon-o-bon-05.jpg',
        'bon-o-bon-06.jpg'
    ],
    // Post 9: Events
    9 => [
        'Aro_Ha_0010_1.jpg',
        'image-asset__7_.jpeg',
        'image-asset__2_.jpeg',
        'AroHa_02.jpg',
        'bon-o-bon-08.jpg',
        'bon-o-bon-09.jpg'
    ],
    // Post 10: About
    10 => [
        'WhatsApp_Image_2025-07-07_at_17.05.39_0436a3a4.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.25.47_3c46d30f__1_.jpg',
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.33.35_b81af96b.jpg',
        'WhatsApp_Image_2022-12-10_at_15.27.19.jpeg',
        'RC-06.png',
        'RC-20.png'
    ],
    // Post 12: Contact
    12 => [
        'Imagen_de_WhatsApp_2025-07-04_a_las_15.53.29_21c6ea8c.jpg',
        'RC-06.png'
    ]
];

function assignPageMedia(&$data, $mediaList, &$idx) {
    if (is_array($data)) {
        if (isset($data['url']) && is_string($data['url'])) {
            if (stripos($data['url'], 'wp-content/uploads') !== false || stripos($data['url'], 'bagigambar') !== false || empty($data['url'])) {
                // If it's a main logo, leave it as the official logo
                if (stripos($data['url'], 'rama-caida-logo.png') === false) {
                    $item = $mediaList[$idx % count($mediaList)];
                    $idx++;
                    $data['id'] = $item['id'];
                    $data['url'] = $item['url'];
                }
            }
        }
        foreach ($data as $k => &$v) {
            assignPageMedia($v, $mediaList, $idx);
        }
    }
}

foreach ($pageAssignments as $pid => $fileNames) {
    $curated = [];
    foreach ($fileNames as $fn) {
        if (isset($mediaByFile[$fn])) {
            $curated[] = $mediaByFile[$fn];
        }
    }
    if (empty($curated)) {
        $curated = $allMedia;
    }

    $raw = get_post_meta($pid, '_elementor_data', true);
    if (!empty($raw)) {
        $data = json_decode($raw, true);
        if (is_array($data)) {
            $idx = 0;
            assignPageMedia($data, $curated, $idx);
            update_post_meta($pid, '_elementor_data', wp_slash(json_encode($data)));
            echo "Successfully updated Page Post ID $pid with " . count($curated) . " curated live web images.\n";
        }
    }
}

// Flush Elementor CSS cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor CSS cache flushed.\n";
}

echo "CURATION AND ASSIGNMENT COMPLETE.\n";
