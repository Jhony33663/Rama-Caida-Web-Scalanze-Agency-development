<?php
/**
 * Plugin Name: Rama Caida - Modern Web Guidance & Contrast Optimizations
 * Description: Enforces Google Chrome Modern Web Guidance (LCP priority, fluid typography, responsive layout, glassmorphic backdrop-filter blur, accessible text contrast)
 * Author: Antigravity
 * Version: 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Core Web Vitals: Prioritize LCP image and deprioritize/lazy-load non-critical images
add_filter( 'wp_content_img_tag', function ( $filtered_image, $context, $attachment_id ) {
    static $first_image = true;

    if ( $first_image && ! is_admin() ) {
        $first_image = false;
        $filtered_image = preg_replace( '/\s+loading=["\']lazy["\']/i', '', $filtered_image );
        if ( stripos( $filtered_image, 'fetchpriority' ) === false ) {
            $filtered_image = preg_replace( '/<img\s+/i', '<img fetchpriority="high" decoding="async" ', $filtered_image );
        }
    } else {
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

// 3. Accessibility, Backdrop Blur, Legibility & Fluid Responsive Design
add_action( 'wp_head', function() {
    ?>
    <meta name="color-scheme" content="dark light">
    <style id="rama-caida-modern-guidance">
        /* 1. Global Viewport & Anti-Clipping */
        html, body {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100vw !important;
            box-sizing: border-box;
            background-color: #0b1120;
            color: #f1f5f9;
        }

        *, *::before, *::after {
            box-sizing: inherit;
        }

        img, svg, video {
            max-width: 100%;
            height: auto;
        }

        /* 2. Fluid Typography & Accessible Contrast */
        .elementor-heading-title, 
        .elementor-widget-heading h1, 
        .elementor-widget-heading h2,
        .elementor-widget-heading h3 {
            text-wrap: balance;
            word-break: break-word;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.75);
            letter-spacing: -0.015em;
        }

        h1.elementor-heading-title,
        .elementor-widget-heading h1 {
            font-size: clamp(2.2rem, 5vw + 1rem, 4.2rem) !important;
            line-height: 1.15 !important;
        }

        h2.elementor-heading-title,
        .elementor-widget-heading h2 {
            font-size: clamp(1.8rem, 3.5vw + 0.5rem, 2.8rem) !important;
            line-height: 1.25 !important;
        }

        h3.elementor-heading-title,
        .elementor-widget-heading h3 {
            font-size: clamp(1.3rem, 2vw + 0.5rem, 1.8rem) !important;
            line-height: 1.35 !important;
        }

        /* 3. Text Legibility over Image Scrims */
        .elementor-text-editor,
        .ekit-wid-con .elementskit-section-title-wraper .elementskit-section-title,
        .ekit-wid-con .elementskit-section-title-wraper p {
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6);
        }

        /* 4. Glassmorphism & Blur for Content Containers & Testimonials */
        .ekit-testimonial-item,
        .elementskit-testimonial-slider,
        .elementor-widget-elementskit-testimonial,
        .elementor-widget-image-box .elementor-image-box-content {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Testimonial text contrast enhancement */
        .elementskit-author-name {
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 1.1rem !important;
        }
        .elementskit-author-des {
            color: #f59e0b !important; /* Gold highlight for title/designation */
            font-weight: 600 !important;
        }
        .elementskit-commentor-bio {
            color: #f1f5f9 !important;
            font-size: 1.05rem !important;
            line-height: 1.6 !important;
        }

        /* 5. Header & Navigation Fixes */
        .elementor-location-header {
            position: relative !important;
            z-index: 9999 !important;
            background: rgba(11, 17, 32, 0.95) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 0 !important;
        }

        /* Reset all destructive negative margins on mobile / tablet */
        @media (max-width: 1024px) {
            .elementor-section, 
            .e-con,
            .elementor-column,
            .elementor-top-section {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .elementor-location-header {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding: 10px 15px !important;
            }

            /* Prevent mobile horizontal card overflow */
            .elementor-container {
                max-width: 100% !important;
                overflow-x: hidden !important;
            }
        }

        @media (max-width: 767px) {
            .elementor-section {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }

            /* Responsive button sizing */
            .elementor-button {
                width: 100% !important;
                text-align: center !important;
                margin-bottom: 10px;
            }
        }

        /* 6. High Contrast Links & Buttons Focus States */
        a:focus-visible, button:focus-visible {
            outline: 2px solid #3b82f6 !important;
            outline-offset: 3px !important;
        }
    </style>
    <?php
}, 100 );
