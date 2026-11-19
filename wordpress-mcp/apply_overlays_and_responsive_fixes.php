<?php
// apply_overlays_and_responsive_fixes.php
$pids = [6, 7, 8, 9, 10, 11, 12, 22, 23];

function fix_element_styles(&$elements, $pid, $depth = 0) {
    $countOverlays = 0;
    $countMargins = 0;

    foreach ($elements as &$el) {
        if (!isset($el['settings'])) {
            $el['settings'] = [];
        }

        $st = &$el['settings'];

        // 1. Check background image or slideshow
        $hasBgImg = !empty($st['background_image']['url']) || !empty($st['background_image']['id']);
        $hasBgSlide = !empty($st['background_slideshow_gallery']);

        if ($hasBgImg || $hasBgSlide) {
            // Apply high-contrast dark overlay
            $st['background_overlay_background'] = 'classic';
            $st['background_overlay_color'] = 'rgba(10, 16, 30, 0.78)';
            $st['background_overlay_opacity'] = [
                'unit' => 'px',
                'size' => 0.78,
                'sizes' => []
            ];
            $countOverlays++;
        }

        // 2. Fix extreme negative margins that cut off content
        if (isset($st['margin']['bottom']) && intval($st['margin']['bottom']) < -40) {
            echo "  [PID $pid] Resetting extreme desktop bottom margin: {$st['margin']['bottom']} -> 0\n";
            $st['margin']['bottom'] = '0';
            $countMargins++;
        }
        if (isset($st['margin_mobile']['bottom']) && intval($st['margin_mobile']['bottom']) < 0) {
            echo "  [PID $pid] Resetting mobile bottom margin: {$st['margin_mobile']['bottom']} -> 0\n";
            $st['margin_mobile']['bottom'] = '0';
            $countMargins++;
        }
        if (isset($st['margin_tablet']['bottom']) && intval($st['margin_tablet']['bottom']) < 0) {
            echo "  [PID $pid] Resetting tablet bottom margin: {$st['margin_tablet']['bottom']} -> 0\n";
            $st['margin_tablet']['bottom'] = '0';
            $countMargins++;
        }

        // Header specific mobile fixes
        if ($pid == 22) {
            if (isset($st['margin']['bottom']) && intval($st['margin']['bottom']) < 0) {
                // Ensure mobile/tablet don't overlap awkwardly
                $st['margin_mobile'] = ['top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true];
                $st['margin_tablet'] = ['top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true];
            }
        }

        // Recurse children
        if (!empty($el['elements'])) {
            list($subO, $subM) = fix_element_styles($el['elements'], $pid, $depth + 1);
            $countOverlays += $subO;
            $countMargins += $subM;
        }
    }

    return [$countOverlays, $countMargins];
}

foreach ($pids as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (empty($raw)) continue;

    $data = json_decode($raw, true);
    if (!is_array($data)) continue;

    $title = get_the_title($pid);
    list($overlays, $margins) = fix_element_styles($data, $pid);

    update_post_meta($pid, '_elementor_data', wp_slash(json_encode($data)));
    echo "Updated Post $pid ($title): Added/Updated $overlays overlays, Fixed $margins margins.\n";
}

// Clear Elementor CSS cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor CSS cache cleared.\n";
}
