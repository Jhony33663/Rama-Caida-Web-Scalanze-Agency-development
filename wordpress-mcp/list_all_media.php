<?php
$posts = get_posts(['post_type' => 'attachment', 'posts_per_page' => 150]);
echo "Total attachments: " . count($posts) . "\n";
foreach ($posts as $p) {
    echo $p->ID . ": " . $p->post_title . "\n";
}
