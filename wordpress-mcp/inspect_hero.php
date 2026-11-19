<?php
$raw = get_post_meta(6, '_elementor_data', true);
$data = json_decode($raw, true);

if (!empty($data)) {
    $sec0 = $data[0];
    echo "Section 0 settings:\n";
    print_r($sec0['settings'] ?? []);
    if (!empty($sec0['elements'])) {
        foreach ($sec0['elements'] as $col) {
            echo "Col settings:\n";
            print_r($col['settings'] ?? []);
        }
    }
}
