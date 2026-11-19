<?php
// import_clean_logos.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$logos = [
    'logo_orange_clean' => [
        'path' => 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_orange_clean.png',
        'title' => 'Rama Caida Logo - Orange Brand Variant'
    ],
    'logo_primary_clean' => [
        'path' => 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_primary_clean.png',
        'title' => 'Rama Caida Logo - Primary Official'
    ],
    'logo_isotipo_mango' => [
        'path' => 'C:/Type_b/Clientes/RAMA CAIDA/assets/logo_isotipo_mango_clean.png',
        'title' => 'Rama Caida Logo - Mango Isotipo'
    ],
];

$imported = [];
foreach ($logos as $key => $info) {
    if (!file_exists($info['path'])) {
        echo "File not found: {$info['path']}\n";
        continue;
    }

    $upload = wp_upload_bits(basename($info['path']), null, file_get_contents($info['path']));
    if (!empty($upload['error'])) {
        echo "Upload error: {$upload['error']}\n";
        continue;
    }

    $attachment = [
        'post_mime_type' => 'image/png',
        'post_title' => $info['title'],
        'post_content' => '',
        'post_status' => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $upload['file']);
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);

    $url = wp_get_attachment_url($attach_id);
    echo "Imported {$key}: ID $attach_id -> $url\n";
    $imported[$key] = [
        'id' => $attach_id,
        'url' => $url,
    ];
}

file_put_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/imported_logos.json', json_encode($imported, JSON_PRETTY_PRINT));
echo "Done importing clean logos.\n";
