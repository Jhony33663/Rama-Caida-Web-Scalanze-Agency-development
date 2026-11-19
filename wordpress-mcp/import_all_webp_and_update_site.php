<?php
// import_all_webp_and_update_site.php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$webp_dir = 'C:/Type_b/Clientes/RAMA CAIDA/assets/webp_all';
$files = glob($webp_dir . '/*.webp');
echo "Found " . count($files) . " WebP files to import/verify.\n";

// Existing attachments indexed by file basename
$existing_attachments = get_posts([
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => 'any'
]);

$media_map = []; // base_no_ext => ['id' => ..., 'url' => ...]
foreach ($existing_attachments as $att) {
    $file_path = get_attached_file($att->ID);
    $bname = basename($file_path);
    $base_no_ext = pathinfo($bname, PATHINFO_FILENAME);
    $url = wp_get_attachment_url($att->ID);
    
    // Normalize basename
    $clean_base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $base_no_ext));
    $media_map[$clean_base] = ['id' => $att->ID, 'url' => $url];
}

$webp_map = []; // clean_name => ['id' => ..., 'url' => ...]
foreach ($files as $fpath) {
    $bname = basename($fpath);
    $base_no_ext = pathinfo($bname, PATHINFO_FILENAME);
    $clean_base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $base_no_ext));

    // Check if already in WP
    $already = null;
    foreach ($existing_attachments as $att) {
        $attached = get_attached_file($att->ID);
        if (basename($attached) === $bname) {
            $already = $att->ID;
            break;
        }
    }

    if ($already) {
        $url = wp_get_attachment_url($already);
        $webp_map[$clean_base] = ['id' => $already, 'url' => $url];
        echo "Already imported: $bname (ID: $already)\n";
    } else {
        $upload = wp_upload_bits($bname, null, file_get_contents($fpath));
        if (!empty($upload['error'])) {
            echo "Error uploading $bname: {$upload['error']}\n";
            continue;
        }

        $attachment = [
            'post_mime_type' => 'image/webp',
            'post_title' => preg_replace('/[_\-]+/', ' ', $base_no_ext),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $upload['file']);
        $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);
        $url = wp_get_attachment_url($attach_id);

        $webp_map[$clean_base] = ['id' => $attach_id, 'url' => $url];
        echo "Imported WebP: $bname -> ID $attach_id\n";
    }
}

file_put_contents('C:/Type_b/Clientes/RAMA CAIDA/wordpress-mcp/webp_map.json', json_encode($webp_map, JSON_PRETTY_PRINT));

// Orange logo ID
$orange_logo_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', 'logo_orange_clean'));
$orange_logo = $webp_map[$orange_logo_key] ?? null;

$isotipo_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', 'logo_isotipo_mango_clean'));
$isotipo = $webp_map[$isotipo_key] ?? null;

if ($orange_logo) {
    echo "Orange logo available: ID {$orange_logo['id']} -> {$orange_logo['url']}\n";
    update_option('custom_logo', $orange_logo['id']);
}
if ($isotipo) {
    update_option('site_icon', $isotipo['id']);
}

// Update all pages:
// 1. Replace image URLs with WebP URLs and IDs
// 2. Remove dark blackout overlays and replace with subtle clean scrims / blur
// 3. Set Orange logo in Header & Footer
$pids = [6, 7, 8, 9, 10, 11, 12, 22, 23];

function update_elementor_tree(&$elements, $webp_map, $orange_logo, $is_header_or_footer = false) {
    foreach ($elements as &$el) {
        $type = $el['widgetType'] ?? $el['elType'] ?? '';
        if (!isset($el['settings'])) {
            $el['settings'] = [];
        }
        $st = &$el['settings'];

        // 1. Background overlays: REMOVE dark blackout overlays!
        // The user specifically requested: "dije usa blur no pon todo obscuro"
        if (!empty($st['background_image']['url']) || !empty($st['background_slideshow_gallery'])) {
            // Keep background visible and bright. Remove heavy dark tint.
            // Provide subtle scrim (0.15) or frosted glass
            $st['background_overlay_background'] = 'classic';
            $st['background_overlay_color'] = 'rgba(15, 23, 42, 0.15)'; // light ambient tint, not pitch black!
            $st['background_overlay_opacity'] = ['unit' => 'px', 'size' => 0.15];
        }

        // 2. Header / Footer logo replacement
        if ($is_header_or_footer && ($type === 'image' || $type === 'theme-site-logo' || !empty($st['image']['url']))) {
            if ($orange_logo) {
                $st['image'] = [
                    'url' => $orange_logo['url'],
                    'id' => $orange_logo['id']
                ];
                echo "  Replaced header/footer logo with Orange Logo!\n";
            }
        }

        // 3. Check any image in settings and replace with WebP
        if (!empty($st['image']['url'])) {
            $url = $st['image']['url'];
            $fn = pathinfo(basename($url), PATHINFO_FILENAME);
            $clean_fn = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
            if (isset($webp_map[$clean_fn])) {
                $st['image']['url'] = $webp_map[$clean_fn]['url'];
                $st['image']['id'] = $webp_map[$clean_fn]['id'];
            }
        }

        // 4. Check background image
        if (!empty($st['background_image']['url'])) {
            $url = $st['background_image']['url'];
            $fn = pathinfo(basename($url), PATHINFO_FILENAME);
            $clean_fn = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
            if (isset($webp_map[$clean_fn])) {
                $st['background_image']['url'] = $webp_map[$clean_fn]['url'];
                $st['background_image']['id'] = $webp_map[$clean_fn]['id'];
            }
        }

        // 5. Check background slideshow gallery
        if (!empty($st['background_slideshow_gallery']) && is_array($st['background_slideshow_gallery'])) {
            foreach ($st['background_slideshow_gallery'] as &$slide) {
                if (!empty($slide['url'])) {
                    $fn = pathinfo(basename($slide['url']), PATHINFO_FILENAME);
                    $clean_fn = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
                    if (isset($webp_map[$clean_fn])) {
                        $slide['url'] = $webp_map[$clean_fn]['url'];
                        $slide['id'] = $webp_map[$clean_fn]['id'];
                    }
                }
            }
        }

        // 6. Check gallery or image carousel widgets
        if (!empty($st['wp_gallery']) && is_array($st['wp_gallery'])) {
            foreach ($st['wp_gallery'] as &$gItem) {
                if (!empty($gItem['url'])) {
                    $fn = pathinfo(basename($gItem['url']), PATHINFO_FILENAME);
                    $clean_fn = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fn));
                    if (isset($webp_map[$clean_fn])) {
                        $gItem['url'] = $webp_map[$clean_fn]['url'];
                        $gItem['id'] = $webp_map[$clean_fn]['id'];
                    }
                }
            }
        }

        // Recurse
        if (!empty($el['elements'])) {
            update_elementor_tree($el['elements'], $webp_map, $orange_logo, $is_header_or_footer);
        }
    }
}

foreach ($pids as $pid) {
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (empty($raw)) continue;

    $data = json_decode($raw, true);
    if (!is_array($data)) continue;

    $title = get_the_title($pid);
    echo "Updating Post $pid ($title)...\n";
    $is_hf = ($pid == 22 || $pid == 23 || $pid == 20 || $pid == 21);
    update_elementor_tree($data, $webp_map, $orange_logo, $is_hf);

    update_post_meta($pid, '_elementor_data', wp_slash(json_encode($data)));
}

// Flush Elementor cache
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo "Elementor CSS cache cleared.\n";
}
echo "All done!\n";
