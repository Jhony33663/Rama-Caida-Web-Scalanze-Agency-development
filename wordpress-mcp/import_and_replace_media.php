<?php
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$assetsDir = 'C:/Type_b/Clientes/RAMA CAIDA/assets';
$photosDir = "$assetsDir/photos";

function importFileToWP($filePath, $title) {
    $filename = basename($filePath);
    $upload_dir = wp_upload_dir();
    $unique_name = wp_unique_filename($upload_dir['path'], $filename);
    $target_path = $upload_dir['path'] . '/' . $unique_name;
    copy($filePath, $target_path);

    $filetype = wp_check_filetype($unique_name, null);
    $attachment = [
        'guid' => $upload_dir['url'] . '/' . $unique_name,
        'post_mime_type' => $filetype['type'],
        'post_title' => $title,
        'post_content' => '',
        'post_status' => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $target_path);
    $attach_data = wp_generate_attachment_metadata($attach_id, $target_path);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return [
        'id' => $attach_id,
        'url' => wp_get_attachment_url($attach_id),
        'path' => $target_path
    ];
}

echo "1. Importing Logo...\n";
$logoPath = "$assetsDir/rama-caida-logo.png";
$logoData = importFileToWP($logoPath, 'Rama Caida Logo');
echo "Logo imported ID: {$logoData['id']}, URL: {$logoData['url']}\n";

// Set as site icon and custom logo in WP theme
set_theme_mod('custom_logo', $logoData['id']);
update_option('site_icon', $logoData['id']);

echo "2. Importing 29 Campaign Photos...\n";
$files = scandir($photosDir);
$importedPhotos = [];
foreach ($files as $f) {
    if ($f === '.' || $f === '..') continue;
    $full = "$photosDir/$f";
    if (is_file($full) && filesize($full) > 1000) {
        $cleanTitle = ucwords(str_replace(['-', '_', '.'], ' ', pathinfo($f, PATHINFO_FILENAME)));
        $res = importFileToWP($full, "Rama Caida - $cleanTitle");
        $importedPhotos[] = $res;
    }
}
echo "Imported " . count($importedPhotos) . " photos into Media Library.\n";

// 3. Replace in all Elementor pages and header/footer
$photoIndex = 0;
function getNextPhoto($importedPhotos, &$idx) {
    $p = $importedPhotos[$idx % count($importedPhotos)];
    $idx++;
    return $p;
}

function replaceMediaInNodes(&$items, $logoData, $importedPhotos, &$photoIdx) {
    foreach ($items as &$item) {
        if (isset($item['settings']) && is_array($item['settings'])) {
            foreach ($item['settings'] as $k => &$v) {
                // Check if it's an image array with url or id
                if (is_array($v) && (isset($v['url']) || isset($v['id']))) {
                    $url = $v['url'] ?? '';
                    // Check if it's the logo
                    if (stripos($url, 'logo') !== false || stripos($k, 'logo') !== false) {
                        $v['id'] = $logoData['id'];
                        $v['url'] = $logoData['url'];
                    } elseif (stripos($url, 'bagigambar.net') !== false || stripos($url, 'unsplash') !== false || empty($url)) {
                        $p = getNextPhoto($importedPhotos, $photoIdx);
                        $v['id'] = $p['id'];
                        $v['url'] = $p['url'];
                    }
                } elseif (is_string($v) && stripos($v, 'bagigambar.net') !== false) {
                    $p = getNextPhoto($importedPhotos, $photoIdx);
                    $v = $p['url'];
                }
            }
        }
        if (!empty($item['elements'])) {
            replaceMediaInNodes($item['elements'], $logoData, $importedPhotos, $photoIdx);
        }
    }
}

// Update all pages + header/footer
$targetPostIds = [6, 7, 8, 9, 10, 11, 12, 22, 23];
foreach ($targetPostIds as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (!empty($raw)) {
        $nodes = json_decode($raw, true);
        if (is_array($nodes)) {
            replaceMediaInNodes($nodes, $logoData, $importedPhotos, $photoIndex);
            update_post_meta($pid, '_elementor_data', wp_slash(json_encode($nodes)));
            echo "Updated images for Post ID: $pid\n";
        }
    }
}

// 4. Clear Elementor CSS cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor CSS cache cleared.\n";
}

echo "ALL IMAGES SUCCESSFULLY REPLACED WITH AUTHENTIC RAMA CAIDA MEDIA!\n";
