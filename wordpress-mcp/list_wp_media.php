<?php
$query = new WP_Query([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1
]);

echo "Total attachments in WP: " . count($query->posts) . "\n";
foreach (array_slice($query->posts, 0, 20) as $p) {
    echo "ID: {$p->ID} | Title: {$p->post_title} | File: " . basename(get_attached_file($p->ID)) . "\n";
}
