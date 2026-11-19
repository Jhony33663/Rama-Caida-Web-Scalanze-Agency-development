<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

// Check Header (Post 22)
$hRaw = get_post_meta(22, '_elementor_data', true);
$hData = json_decode($hRaw, true);

echo "=== Header (Post 22) Logo Check ===\n";
function find_img($els) {
    foreach ($els as $el) {
        if (!empty($el['settings']['image']['url'])) {
            echo "Header logo URL: " . $el['settings']['image']['url'] . "\n";
            echo "Header logo ID: " . $el['settings']['image']['id'] . "\n";
        }
        if (!empty($el['elements'])) find_img($el['elements']);
    }
}
find_img($hData);

echo "\n=== Site Options ===\n";
echo "custom_logo: " . get_option('custom_logo') . " -> " . wp_get_attachment_url(get_option('custom_logo')) . "\n";
echo "site_icon: " . get_option('site_icon') . " -> " . wp_get_attachment_url(get_option('site_icon')) . "\n";

echo "\n=== Checking WebP usage in Pages ===\n";
foreach ([6, 7, 8, 9, 10, 11, 12] as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    $title = get_the_title($pid);
    $webpCount = substr_count($raw, '.webp');
    $jpgCount = substr_count($raw, '.jpg') + substr_count($raw, '.jpeg') + substr_count($raw, '.png');
    echo "Page $pid ($title): WebP references = $webpCount, Legacy image references = $jpgCount\n";
}
