<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';
require_once 'C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/build_fresh_pages_from_md.php';

// Build Footer Post 23
$footer_logo_col = make_col([
    make_image($orange_logo, 'medium', ['align' => 'left']),
    make_text('<p style="font-size: 1.15rem; font-weight: 600; color: #0A5F2D; margin-top: 15px;">Product Sampling and Brand Awareness</p>')
], 40);

$footer_info_col = make_col([
    make_heading('Contact Information', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<p><strong>Location:</strong><br>137 1/2 Washington Ave., Suite 306, Belleville NJ 07109</p><p><strong>Contact:</strong><br><a href="mailto:danicp.ramacaidasampling@gmail.com" style="color: #ED6C36; text-decoration: none;">danicp.ramacaidasampling@gmail.com</a></p><p><strong>Toll Free:</strong><br><a href="tel:8889733122" style="color: #ED6C36; text-decoration: none;">(888) 973-3122</a></p>')
], 35);

$footer_nav_col = make_col([
    make_heading('Quick Links', 'h3', 'left', ['title_color' => '#ED6C36']),
    make_text('<ul style="list-style: none; padding: 0; line-height: 2.2;"><li><a href="/merchandising-sales/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Merchandising & Sales</a></li><li><a href="/street-marketing/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Street Marketing</a></li><li><a href="/events/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Events</a></li><li><a href="/get-to-know-us/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Get to Know Us</a></li><li><a href="/join-us/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Join Us</a></li><li><a href="/contact-us/" style="color: #1e293b; text-decoration: none; font-weight: 600;">Contact Us</a></li></ul>')
], 25);

$footer_section = make_section([$footer_logo_col, $footer_info_col, $footer_nav_col], null, [
    'background_color' => '#ffffff',
    'padding' => ['unit' => 'px', 'top' => '60', 'right' => '20', 'bottom' => '40', 'left' => '20', 'isLinked' => false]
]);

$copyright_sec = make_section([
    make_col([
        make_text('<p style="text-align: center; color: #94a3b8; font-size: 0.95rem; margin: 0;">© ' . date('Y') . ' Rama Caida Product Sampling & Brand Awareness. All Rights Reserved.</p>')
    ], 100)
], null, [
    'background_color' => '#f1f5f9',
    'padding' => ['unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => true]
]);

update_post_meta(23, '_elementor_data', wp_slash(json_encode([$footer_section, $copyright_sec])));
echo "Footer Post 23 updated with exact markdown info and Orange Logo.\n";

// Update primary navigation menu in WP
$menu_name = 'Main Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if ($menu_exists) {
    // Delete existing menu items and rebuild cleanly
    $items = wp_get_nav_menu_items($menu_exists->term_id);
    if ($items) {
        foreach ($items as $it) {
            wp_delete_post($it->ID, true);
        }
    }
    
    // Services (Parent)
    $services_id = wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Services',
        'menu-item-url' => '#services',
        'menu-item-status' => 'publish'
    ]);
    
    // Services Sub-items
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Merchandising & Sales',
        'menu-item-url' => '/merchandising-sales/',
        'menu-item-parent-id' => $services_id,
        'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Street Marketing',
        'menu-item-url' => '/street-marketing/',
        'menu-item-parent-id' => $services_id,
        'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Events',
        'menu-item-url' => '/events/',
        'menu-item-parent-id' => $services_id,
        'menu-item-status' => 'publish'
    ]);
    
    // Other items
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Get to Know Us',
        'menu-item-url' => '/get-to-know-us/',
        'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Join Us',
        'menu-item-url' => '/join-us/',
        'menu-item-status' => 'publish'
    ]);
    wp_update_nav_menu_item($menu_exists->term_id, 0, [
        'menu-item-title' => 'Contact Us',
        'menu-item-url' => '/contact-us/',
        'menu-item-status' => 'publish'
    ]);
    
    echo "Navigation menu rebuilt matching exact markdown structure.\n";
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
echo "Elementor cache cleared.\n";
