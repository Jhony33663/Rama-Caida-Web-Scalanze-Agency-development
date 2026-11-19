<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

$webp_map = json_decode(file_get_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/webp_map.json'), true);

$pids = [6, 7, 8, 9, 10, 11, 12, 22, 23];

foreach ($pids as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (empty($raw)) continue;

    // Direct regex replacement for URLs ending in .jpg, .jpeg, .png
    $updated = preg_replace_callback('/(http:\/\/[^"\']+\/uploads\/[^\'"]+?)\.(jpg|jpeg|png)/i', function($m) use ($webp_map) {
        $full = $m[1];
        $fn = pathinfo($full, PATHINFO_FILENAME);
        $clean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
        if (isset($webp_map[$clean])) {
            return $webp_map[$clean]['url'];
        }
        return $full . '.webp';
    }, $raw);

    // Also replace image IDs where applicable
    $data = json_decode($updated, true);
    if (is_array($data)) {
        array_walk_recursive($data, function(&$val, $key) use ($webp_map) {
            if ($key === 'url' && is_string($val) && preg_match('/\.webp$/i', $val)) {
                $fn = pathinfo($val, PATHINFO_FILENAME);
                $clean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
                // ID will be updated if adjacent, but Elementor primarily uses the url in element settings
            }
        });
        update_post_meta($pid, '_elementor_data', wp_slash(json_encode($data)));
        echo "Post $pid updated with full WebP coverage.\n";
    }
}

\Elementor\Plugin::$instance->files_manager->clear_cache();
echo "Done replacing legacy image references!\n";
