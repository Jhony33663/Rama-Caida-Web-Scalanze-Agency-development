<?php
$front = get_option('page_on_front');
$show = get_option('show_on_front');
echo "page_on_front: $front, show_on_front: $show\n";
$post = get_post(6);
echo "Post 6 title: " . $post->post_title . ", status: " . $post->post_status . "\n";
echo "Post 6 edit_mode: " . get_post_meta(6, '_elementor_edit_mode', true) . "\n";
$data = get_post_meta(6, '_elementor_data', true);
echo "Post 6 data len: " . strlen($data) . "\n";
