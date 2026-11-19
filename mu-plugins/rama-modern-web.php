<?php
/**
 * Plugin Name: Rama Caida - Modern Web Guidance, Frosted Glass & Brand Styling
 * Description: Enforces Chrome Modern Web Guidance (LCP, WebP, fluid typography, responsive layout, frosted glass blur, and brand colors)
 * Author: Antigravity
 * Version: 3.0.0
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

// 3. Frosted Glass Blur, Clean Modern Styling & Brand Colors
add_action( 'wp_head', function() {
    ?>
    <style id="rama-caida-brand-styles">
        :root {
            --rama-orange: #ED6C36;
            --rama-mango: #EA560D;
            --rama-green: #0A5F2D;
            --rama-yellow: #F7D74C;
            --rama-coral: #D92616;
            --rama-dark: #1e293b;
            --rama-light: #f8fafc;
        }

        /* 1. Global Viewport & Light/Clean Modern Canvas */
        html, body {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100vw !important;
            box-sizing: border-box;
            background-color: #f8fafc !important;
            color: #1e293b;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        *, *::before, *::after {
            box-sizing: inherit;
        }

        img, svg, video {
            max-width: 100%;
            height: auto;
        }

        /* 2. Frosted Glass (Blur) on Cards & Content Boxes */
        .ekit-testimonial-item,
        .elementskit-testimonial-slider,
        .elementor-widget-elementskit-testimonial,
        .elementor-widget-image-box .elementor-image-box-content,
        .ekit-wid-con .elementskit-infobox,
        .elementor-widget-icon-box {
            backdrop-filter: blur(16px) saturate(160%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(160%) !important;
            background: rgba(255, 255, 255, 0.85) !important;
            border: 1px solid rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
            border-radius: 16px !important;
            padding: 24px !important;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease !important;
        }

        .ekit-testimonial-item:hover,
        .elementor-widget-image-box:hover .elementor-image-box-content {
            transform: translateY(-4px) !important;
            box-shadow: 0 16px 40px rgba(237, 108, 54, 0.12) !important;
        }

        /* Testimonial text contrast enhancement */
        .elementskit-author-name {
            color: #0f172a !important;
            font-weight: 700 !important;
            font-size: 1.15rem !important;
        }
        .elementskit-author-des {
            color: var(--rama-orange) !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
        }
        .elementskit-commentor-bio {
            color: #334155 !important;
            font-size: 1.05rem !important;
            line-height: 1.65 !important;
        }

        /* 3. Header: Light Frosted Glass with Orange Logo */
        .elementor-location-header {
            position: relative !important;
            z-index: 9999 !important;
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(237, 108, 54, 0.15) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            margin-bottom: 0 !important;
        }

        /* Header Navigation links: Dark crisp text with orange active/hover */
        .elementor-location-header .elementor-item,
        .elementor-location-header .ekit-menu-nav-link {
            color: #1e293b !important;
            font-weight: 600 !important;
            transition: color 0.2s ease !important;
        }
        .elementor-location-header .elementor-item:hover,
        .elementor-location-header .elementor-item.elementor-item-active,
        .elementor-location-header .ekit-menu-nav-link:hover {
            color: var(--rama-orange) !important;
        }

        /* Ensure header logo displays crisply without excess whitespace */
        .elementor-location-header img {
            max-height: 52px !important;
            width: auto !important;
            object-fit: contain !important;
        }

        /* 4. Brand Action Buttons (Orange #ED6C36) */
        .elementor-button,
        .elementor-button.elementor-size-md,
        .elementor-button.elementor-size-lg,
        a.elementskit-btn,
        .btn-primary {
            background-color: var(--rama-orange) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-radius: 50px !important;
            padding: 14px 32px !important;
            box-shadow: 0 4px 14px rgba(237, 108, 54, 0.35) !important;
            transition: all 0.25s ease !important;
            border: none !important;
        }
        .elementor-button:hover,
        a.elementskit-btn:hover {
            background-color: var(--rama-mango) !important;
            box-shadow: 0 6px 20px rgba(234, 86, 13, 0.45) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        /* 5. Fluid Typography */
        .elementor-heading-title, 
        .elementor-widget-heading h1, 
        .elementor-widget-heading h2,
        .elementor-widget-heading h3 {
            text-wrap: balance;
            word-break: break-word;
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

        /* 6. Mobile / Tablet Responsive Resets */
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
                padding: 12px 16px !important;
            }

            .elementor-container {
                max-width: 100% !important;
                overflow-x: hidden !important;
            }
        }

        @media (max-width: 767px) {
            .elementor-section {
                padding-top: 36px !important;
                padding-bottom: 36px !important;
            }

            .elementor-button {
                width: 100% !important;
                text-align: center !important;
                margin-bottom: 10px;
            }
        }

        /* 7. Focus outline accessibility */
        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--rama-orange) !important;
            outline-offset: 3px !important;
        }
    </style>
    <?php
}, 100 );
