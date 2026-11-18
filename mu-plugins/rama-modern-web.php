<?php
/**
 * Plugin Name: Rama Caida - Modern Web Guidance Optimizations
 * Description: Enforces Google Chrome Modern Web Guidance (LCP priority, lazy loading, forms accessibility)
 * Author: Antigravity
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Core Web Vitals: Prioritize LCP image and deprioritize/lazy-load non-critical images
add_filter( 'wp_content_img_tag', function ( $filtered_image, $context, $attachment_id ) {
    static $first_image = true;

    // First image in main content is the LCP candidate
    if ( $first_image && ! is_admin() ) {
        $first_image = false;

        // Remove loading="lazy" if present
        $filtered_image = preg_replace( '/\s+loading=["\']lazy["\']/i', '', $filtered_image );

        // Add fetchpriority="high" and decoding="async"
        if ( stripos( $filtered_image, 'fetchpriority' ) === false ) {
            $filtered_image = preg_replace( '/<img\s+/i', '<img fetchpriority="high" decoding="async" ', $filtered_image );
        }
    } else {
        // Below-the-fold images: ensure loading="lazy" and decoding="async", avoid fetchpriority
        if ( stripos( $filtered_image, 'loading=' ) === false ) {
            $filtered_image = preg_replace( '/<img\s+/i', '<img loading="lazy" decoding="async" ', $filtered_image );
        }
    }

    return $filtered_image;
}, 10, 3 );

// 2. Elementor Render Image Hook for LCP Optimization
add_filter( 'elementor/image_size/get_attachment_image_html', function( $html, $settings, $image_size_key, $image_key ) {
    static $first_elementor_img = true;
    if ( $first_elementor_img && ! is_admin() ) {
        $first_elementor_img = false;
        $html = preg_replace( '/\s+loading=["\']lazy["\']/i', '', $html );
        if ( stripos( $html, 'fetchpriority' ) === false ) {
            $html = preg_replace( '/<img\s+/i', '<img fetchpriority="high" decoding="async" ', $html );
        }
    }
    return $html;
}, 10, 4 );

// 3. Security & Modern Web: Enable modern viewport and color-scheme
add_action( 'wp_head', function() {
    echo '<meta name="color-scheme" content="light dark">' . "\n";
}, 1 );
