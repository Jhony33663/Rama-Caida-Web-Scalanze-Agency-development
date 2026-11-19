<?php
delete_post_meta(6, '_elementor_element_cache');
delete_post_meta(6, '_elementor_css');
delete_post_meta(6, '_elementor_page_assets');

// Also clear transient elementor element cache
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_element_cache'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%elementor%' AND option_name LIKE '%cache%'");

echo "Cleared _elementor_element_cache across the entire site!\n";
