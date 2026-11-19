<?php
$postIds = [6, 7, 8, 9, 10, 11, 12, 20, 21, 22, 23];

function findLoremInNodes($node, $path, &$results) {
    if (is_array($node)) {
        if (isset($node['widgetType']) || isset($node['elType'])) {
            $currentPath = $path . ' > ' . ($node['widgetType'] ?? $node['elType']);
        } else {
            $currentPath = $path;
        }

        foreach ($node as $k => $v) {
            if (is_string($v)) {
                if (stripos($v, 'lorem') !== false || stripos($v, 'ipsum') !== false) {
                    $results[] = [
                        'path' => $currentPath,
                        'key' => $k,
                        'snippet' => substr(strip_tags($v), 0, 100)
                    ];
                }
            } else {
                findLoremInNodes($v, $currentPath, $results);
            }
        }
    }
}

foreach ($postIds as $pid) {
    $title = get_the_title($pid);
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (!empty($raw)) {
        $data = json_decode($raw, true);
        $results = [];
        findLoremInNodes($data, "Post $pid ($title)", $results);
        if (!empty($results)) {
            echo "=== Post $pid: $title (" . count($results) . " lorem matches) ===\n";
            foreach ($results as $r) {
                echo "  [{$r['path']}] key: {$r['key']}\n    Text: {$r['snippet']}\n";
            }
        } else {
            echo "Post $pid ($title): CLEAN (0 lorem)\n";
        }
    }
}
