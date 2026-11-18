<?php
$kitDir = "C:/Type_b/Clientes/RAMA CAIDA/runda-kit/templates";

// 1. Header
$headerRaw = json_decode(file_get_contents("$kitDir/header.json"), true);
$headerContent = $headerRaw['content'];

// Update contact button
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
    'post_type' => 'elementor-hf',
    'post_status' => 'publish'
]);
update_post_meta($hId, '_elementor_data', wp_slash(json_encode($headerContent)));
update_post_meta($hId, '_elementor_edit_mode', 'builder');
update_post_meta($hId, 'ehf_template_type', 'type_header');
update_post_meta($hId, 'ehf_target_include_locations', ['entire_website']);

// 2. Footer
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
    'post_type' => 'elementor-hf',
    'post_status' => 'publish'
]);
update_post_meta($fId, '_elementor_data', wp_slash(json_encode($footerContent)));
update_post_meta($fId, '_elementor_edit_mode', 'builder');
update_post_meta($fId, 'ehf_template_type', 'type_footer');
update_post_meta($fId, 'ehf_target_include_locations', ['entire_website']);

echo "SUCCESS: Header ID = $hId, Footer ID = $fId created.\n";
