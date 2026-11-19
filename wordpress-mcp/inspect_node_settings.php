<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

$raw = get_post_meta(22, '_elementor_data', true);
$data = json_decode($raw, true);

function find_node($els, $target_id) {
    foreach ($els as $el) {
        if (($el['id'] ?? '') === $target_id) return $el;
        if (!empty($el['elements'])) {
            $f = find_node($el['elements'], $target_id);
            if ($f) return $f;
        }
    }
    return null;
}

$c1 = find_node($data, '5ff7ee21');
echo "=== Container 5ff7ee21 (Logo Container) Settings ===\n";
print_r($c1['settings'] ?? []);

$nav = find_node($data, '6e149a2');
echo "\n=== Nav Widget 6e149a2 Settings ===\n";
print_r($nav['settings'] ?? []);
