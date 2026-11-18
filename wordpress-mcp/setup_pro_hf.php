<?php
use ElementorPro\Modules\ThemeBuilder\Module as ThemeBuilderModule;

$kitDir = "C:/Type_b/Clientes/RAMA CAIDA/runda-kit/templates";

// 1. HEADER
$headerRaw = json_decode(file_get_contents("$kitDir/header.json"), true);
$headerContent = $headerRaw['content'];

function updateNodes(&$items) {
    foreach ($items as &$item) {
        if (isset($item['widgetType'])) {
            if ($item['widgetType'] === 'button') {
                $item['settings']['text'] = 'CONTACT US';
                $item['settings']['link'] = [
                    'url' => 'http://rama-caida.local/contact/',
                    'is_external' => '',
                    'nofollow' => ''
                ];
            }
            if ($item['widgetType'] === 'jkit_nav_menu') {
                $item['settings']['menu'] = '2'; // Main menu ID
            }
        }
        if (!empty($item['elements'])) {
            updateNodes($item['elements']);
        }
    }
}
updateNodes($headerContent);

$hId = wp_insert_post([
    'post_title' => 'Rama Caida Main Header',
    'post_type' => 'elementor_library',
    'post_status' => 'publish'
]);
wp_set_object_terms($hId, 'header', 'elementor_library_type');
update_post_meta($hId, '_elementor_template_type', 'header');
update_post_meta($hId, '_elementor_data', wp_slash(json_encode($headerContent)));
update_post_meta($hId, '_elementor_edit_mode', 'builder');

// 2. FOOTER
$footerRaw = json_decode(file_get_contents("$kitDir/footer.json"), true);
$footerContent = $footerRaw['content'];

function updateFooterNodes(&$items) {
    foreach ($items as &$item) {
        if (isset($item['widgetType']) && $item['widgetType'] === 'text-editor') {
            $editor = $item['settings']['editor'] ?? '';
            if (stripos($editor, 'Goodwin') !== false) {
                $item['settings']['editor'] = '<p>137 1/2 Washington Ave., Suite 306<br>Belleville NJ 07109</p>';
            } elseif (stripos($editor, 'runda@') !== false) {
                $item['settings']['editor'] = '<p><a href="mailto:danicp.ramacaidasampling@gmail.com">danicp.ramacaidasampling@gmail.com</a></p>';
            } elseif (stripos($editor, '509-364') !== false) {
                $item['settings']['editor'] = '<p><strong>Toll Free:</strong> (888) 973-3122</p>';
            } elseif (stripos($editor, 'Copyright') !== false) {
                $item['settings']['editor'] = '<p>© 2026 Rama Caida Product Sampling & Brand Awareness. All rights reserved.</p>';
            }
        }
        if (!empty($item['elements'])) {
            updateFooterNodes($item['elements']);
        }
    }
}
updateFooterNodes($footerContent);

$fId = wp_insert_post([
    'post_title' => 'Rama Caida Main Footer',
    'post_type' => 'elementor_library',
    'post_status' => 'publish'
]);
wp_set_object_terms($fId, 'footer', 'elementor_library_type');
update_post_meta($fId, '_elementor_template_type', 'footer');
update_post_meta($fId, '_elementor_data', wp_slash(json_encode($footerContent)));
update_post_meta($fId, '_elementor_edit_mode', 'builder');

// Save Conditions
if (class_exists('ElementorPro\Modules\ThemeBuilder\Module')) {
    $themeBuilder = ThemeBuilderModule::instance();
    $condMgr = $themeBuilder->get_conditions_manager();
    $condMgr->save_conditions($hId, [
        ['type' => 'include', 'name' => 'general']
    ]);
    $condMgr->save_conditions($fId, [
        ['type' => 'include', 'name' => 'general']
    ]);
    echo "Elementor Pro Theme Builder conditions saved successfully!\n";
} else {
    echo "Warning: ElementorPro ThemeBuilderModule not found.\n";
}

echo "Created Elementor Pro Header ID: $hId, Footer ID: $fId\n";
