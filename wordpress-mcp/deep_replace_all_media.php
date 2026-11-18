<?php
// Get all uploaded images from WordPress
$args = [
    'post_type' => 'attachment',
    'post_mime_type' =>'image',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
];
$query = new WP_Query($args);
$attachments = [];
$logo = null;

foreach ($query->posts as $post) {
    $url = wp_get_attachment_url($post->ID);
    if (stripos($post->post_name, 'logo') !== false || stripos($url, 'logo') !== false) {
        $logo = ['id' => $post->ID, 'url' => $url];
    } else {
        $attachments[] = ['id' => $post->ID, 'url' => $url];
    }
}

if (!$logo && !empty($attachments)) {
    $logo = $attachments[0];
}

echo "Found " . count($attachments) . " campaign photo attachments and 1 logo (ID: {$logo['id']}).\n";

$photoIdx = 0;
function getNextPhoto($attachments, &$idx) {
    if (empty($attachments)) return ['id' => 0, 'url' => ''];
    $item = $attachments[$idx % count($attachments)];
    $idx++;
    return $item;
}

function deepCleanNode(&$data, $logo, $attachments, &$idx) {
    if (is_array($data)) {
        // If this array itself represents an Elementor image object
        if (isset($data['url']) && is_string($data['url'])) {
            if (stripos($data['url'], 'bagigambar.net') !== false || stripos($data['url'], 'placeholder.png') !== false) {
                if (stripos($data['url'], 'logo') !== false) {
                    $data['id'] = $logo['id'];
                    $data['url'] = $logo['url'];
                } else {
                    $next = getNextPhoto($attachments, $idx);
                    $data['id'] = $next['id'];
                    $data['url'] = $next['url'];
                }
            }
        }
        foreach ($data as $k => &$v) {
            if (is_string($v) && stripos($v, 'bagigambar.net') !== false) {
                if (stripos($v, 'logo') !== false) {
                    $v = $logo['url'];
                } else {
                    $next = getNextPhoto($attachments, $idx);
                    $v = $next['url'];
                }
            } else {
                deepCleanNode($v, $logo, $attachments, $idx);
            }
        }
    }
}

$postIds = [6, 7, 8, 9, 10, 11, 12, 20, 21, 22, 23];
foreach ($postIds as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (!empty($raw)) {
        $data = json_decode($raw, true);
        if (is_array($data)) {
            deepCleanNode($data, $logo, $attachments, $photoIdx);
            $encoded = json_encode($data);
            update_post_meta($pid, '_elementor_data', wp_slash($encoded));
            $rem = substr_count($encoded, 'bagigambar');
            echo "Post $pid cleaned. Remaining bagigambar occurrences: $rem\n";
        }
    }
}

// Clear Elementor CSS cache & files
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor files cache cleared.\n";
}

echo "COMPLETE: Exhaustive media replacement finished.\n";
