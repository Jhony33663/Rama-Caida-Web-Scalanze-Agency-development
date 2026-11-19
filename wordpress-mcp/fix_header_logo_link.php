<?php
// fix_header_logo_link.php

function set_logo_home_link(&$elements) {
    $updated = false;
    foreach ($elements as &$el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        if ($type === 'image' || $type === 'theme-site-logo' || $type === 'site-logo') {
            if (!isset($el['settings'])) $el['settings'] = [];
            $el['settings']['link_to'] = 'custom';
            $el['settings']['link'] = [
                'url' => home_url('/'),
                'is_external' => '',
                'nofollow' => '',
                'custom_attributes' => ''
            ];
            // Keep hover animation float
            if (empty($el['settings']['hover_animation'])) {
                $el['settings']['hover_animation'] = 'float';
            }
            $updated = true;
            echo "Updated image widget {$el['id']} with link to " . home_url('/') . " and hover_animation: {$el['settings']['hover_animation']}\n";
        }
        if (!empty($el['elements'])) {
            if (set_logo_home_link($el['elements'])) {
                $updated = true;
            }
        }
    }
    return $updated;
}

// 1. Post 22 (Header)
$h22Raw = get_post_meta(22, '_elementor_data', true);
if ($h22Raw) {
    $h22Data = json_decode($h22Raw, true);
    set_logo_home_link($h22Data);
    update_post_meta(22, '_elementor_data', wp_slash(json_encode($h22Data)));
    delete_post_meta(22, '_elementor_element_cache');
    delete_post_meta(22, '_elementor_css');
    delete_post_meta(22, '_elementor_page_assets');
    echo "Post 22 (Header) saved.\n";
}

// 2. Post 20 (Draft Header)
$h20Raw = get_post_meta(20, '_elementor_data', true);
if ($h20Raw) {
    $h20Data = json_decode($h20Raw, true);
    set_logo_home_link($h20Data);
    update_post_meta(20, '_elementor_data', wp_slash(json_encode($h20Data)));
    delete_post_meta(20, '_elementor_element_cache');
    delete_post_meta(20, '_elementor_css');
    delete_post_meta(20, '_elementor_page_assets');
    echo "Post 20 saved.\n";
}

// Clear global element cache
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_element_cache'");

echo "Header logo links updated successfully!\n";
