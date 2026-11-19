<?php
$pages = [6, 7, 8, 9, 10, 11, 12];

foreach ($pages as $pid) {
    $title = get_the_title($pid);
    $raw = get_post_meta($pid, '_elementor_data', true);
    $data = json_decode($raw, true);

    echo "=== Page $pid: $title ===\n";
    $secIdx = 0;
    foreach ($data as $sec) {
        $secIdx++;
        $st = $sec['settings'] ?? [];
        $hasBg = !empty($st['background_image']['url']) || !empty($st['background_slideshow_gallery']);
        $hasOverlay = !empty($st['background_overlay_color']) || !empty($st['background_overlay_background']);
        $margin = $st['margin'] ?? [];
        $marginMob = $st['margin_mobile'] ?? [];
        $padding = $st['padding'] ?? [];
        $paddingMob = $st['padding_mobile'] ?? [];

        $issues = [];
        if ($hasBg && !$hasOverlay) {
            $issues[] = "Has BG image BUT NO overlay (text may be unreadable)";
        }
        if (!empty($margin['bottom']) && intval($margin['bottom']) < -50) {
            $issues[] = "Large negative bottom margin: {$margin['bottom']}";
        }
        if (!empty($margin['top']) && intval($margin['top']) < -50) {
            $issues[] = "Large negative top margin: {$margin['top']}";
        }

        if (!empty($issues)) {
            echo "  Section $secIdx:\n";
            foreach ($issues as $iss) {
                echo "    - $iss\n";
            }
        }
    }
}
