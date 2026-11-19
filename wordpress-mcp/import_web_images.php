<?php
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$webDir = 'C:/Type_b/Clientes/RAMA CAIDA/assets/web_images';
$files = scandir($webDir);
$imported = 0;

foreach ($files as $f) {
    if ($f === '.' || $f === '..') continue;
    $full = "$webDir/$f";
    if (is_file($full)) {
        $filename = basename($full);
        $cleanTitle = ucwords(str_replace(['-', '_', '.'], ' ', pathinfo($filename, PATHINFO_FILENAME)));

        // Check if already in WP
        global $wpdb;
        $exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'attachment'", "Web - $cleanTitle"));
        if ($exists) {
            continue;
        }

        $upload_dir = wp_upload_dir();
        $unique_name = wp_unique_filename($upload_dir['path'], $filename);
        $target_path = $upload_dir['path'] . '/' . $unique_name;
        copy($full, $target_path);

        $filetype = wp_check_filetype($unique_name, null);
        $attachment = [
            'guid' => $upload_dir['url'] . '/' . $unique_name,
            'post_mime_type' => $filetype['type'],
            'post_title' => "Web - $cleanTitle",
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $target_path);
        $attach_data = wp_generate_attachment_metadata($attach_id, $target_path);
        wp_update_attachment_metadata($attach_id, $attach_data);
        $imported++;
    }
}

echo "Successfully imported $imported live web images into WordPress Media Library.\n";
