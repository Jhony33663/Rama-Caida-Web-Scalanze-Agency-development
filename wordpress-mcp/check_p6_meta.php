<?php
$data = get_post_meta(6, '_elementor_data', true);
echo "Has santo-domingo-02: " . (strpos($data, 'santo-domingo-02') !== false ? 'YES' : 'NO') . "\n";
echo "Has santo-domingo-01: " . (strpos($data, 'santo-domingo-01') !== false ? 'YES' : 'NO') . "\n";
echo "Has rama-scroll-panel: " . (strpos($data, 'rama-scroll-panel') !== false ? 'YES' : 'NO') . "\n";
