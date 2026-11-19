<?php
$raw = get_post_meta(6, '_elementor_data', true);
$data = json_decode($raw, true);

function findTestimonialWidget($node) {
    if (is_array($node)) {
        if (isset($node['widgetType']) && $node['widgetType'] === 'elementskit-testimonial') {
            echo "Found widget!\n";
            echo "Keys: " . implode(', ', array_keys($node['settings'])) . "\n";
            foreach ($node['settings'] as $k => $v) {
                if (is_array($v) && count($v) > 0 && isset($v[0]['review'])) {
                    echo "-> Matching items key is: $k with " . count($v) . " items!\n";
                    echo "Sample item keys: " . implode(', ', array_keys($v[0])) . "\n";
                }
            }
        }
        foreach ($node as $k => $v) {
            findTestimonialWidget($v);
        }
    }
}
findTestimonialWidget($data);
