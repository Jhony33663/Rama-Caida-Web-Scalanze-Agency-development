<?php
// fix_header_and_hero_contrast.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

// 1. FIX HEADER POST 22
$hRaw = get_post_meta(22, '_elementor_data', true);
$hData = json_decode($hRaw, true);

function clean_header_nodes(&$elements) {
    foreach ($elements as &$el) {
        $id = $el['id'] ?? '';
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        if (!isset($el['settings'])) $el['settings'] = [];
        $st = &$el['settings'];

        // Remove the blue background from container 5ff7ee21 or any logo container
        if ($id === '5ff7ee21' || !empty($st['__globals__']['background_color'])) {
            unset($st['__globals__']['background_color']);
            unset($st['background_background']);
            unset($st['background_color']);
            $st['background_background'] = 'classic';
            $st['background_color'] = 'rgba(255, 255, 255, 0)'; // fully transparent!
            echo "Removed blue accent background from node $id!\n";
        }

        // Fix Navigation Menu widget (jkit_nav_menu or nav-menu)
        if ($type === 'jkit_nav_menu' || strpos($type, 'nav') !== false) {
            // Text color MUST be dark (#0f172a), NOT white (#FFFFFF)!
            $st['st_menu_item_text_normal_color_responsive'] = '#0f172a';
            $st['st_menu_item_text_hover_color_responsive'] = '#ED6C36'; // Rama Orange
            $st['st_menu_item_text_active_color_responsive'] = '#0A5F2D'; // Rama Green
            $st['st_submenu_item_text_normal_color_responsive'] = '#0f172a';
            $st['st_submenu_item_text_hover_color_responsive'] = '#ED6C36';
            $st['st_submenu_item_text_active_color_responsive'] = '#0A5F2D';

            // Mobile hamburger icon
            $st['st_hamburger_menu_icon_color_responsive'] = '#0f172a';
            $st['st_hamburger_menu_icon_color_hover_responsive'] = '#ED6C36';
            $st['st_hamburger_menu_close_color_responsive_mobile'] = '#0f172a';
            
            // Submenu panel
            $st['st_submenu_panel_background_background_color'] = '#ffffff';
            echo "Updated nav menu colors to dark (#0f172a) and orange hover!\n";
        }

        // Header CTA button
        if ($id === '68f7a3f1' || $type === 'button') {
            $st['background_color'] = '#ED6C36';
            $st['button_text_color'] = '#ffffff';
        }

        if (!empty($el['elements'])) {
            clean_header_nodes($el['elements']);
        }
    }
}

clean_header_nodes($hData);
update_post_meta(22, '_elementor_data', wp_slash(json_encode($hData)));
echo "Post 22 (Header) updated.\n";

// 2. Also check Post 20 (Header template draft if exists)
$h20Raw = get_post_meta(20, '_elementor_data', true);
if ($h20Raw) {
    $h20Data = json_decode($h20Raw, true);
    clean_header_nodes($h20Data);
    update_post_meta(20, '_elementor_data', wp_slash(json_encode($h20Data)));
    echo "Post 20 updated.\n";
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
echo "Elementor cache cleared.\n";
