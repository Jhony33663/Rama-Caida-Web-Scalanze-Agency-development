<?php
$attachments = get_posts([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
    's' => 'bon'
]);

foreach ($attachments as $a) {
    $meta = wp_get_attachment_metadata($a->ID);
    $w = $meta['width'] ?? 'unknown';
    $h = $meta['height'] ?? 'unknown';
    $url = wp_get_attachment_url($a->ID);
    echo "ID: {$a->ID} | Title: {$a->post_title} | Dim: {$w}x{$h} | URL: {$url}\n";
}
