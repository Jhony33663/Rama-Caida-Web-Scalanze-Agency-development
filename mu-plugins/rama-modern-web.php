<?php
/**
 * Plugin Name: Rama Caida - Modern Web Guidance, Frosted Glass & Brand Styling
 * Description: Enforces Chrome Modern Web Guidance (LCP, WebP, fluid typography, responsive layout, frosted glass blur, and brand colors)
 * Author: Antigravity
 * Version: 4.0.0
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

// 3. Frosted Glass Blur, Clean Modern Styling, Contrast & Brand Colors
add_action( 'wp_head', function() {
    ?>
    <style id="rama-caida-brand-styles">
        :root {
            --rama-orange: #ED6C36;
            --rama-mango: #EA560D;
            --rama-green: #0A5F2D;
            --rama-yellow: #F7D74C;
            --rama-coral: #D92616;
            --rama-dark: #0f172a;
            --rama-light: #f8fafc;
        }

        /* 1. Global Viewport & Light Clean Canvas */
        html, body {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100vw !important;
            box-sizing: border-box;
            background-color: #f8fafc !important;
            color: #0f172a !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        *, *::before, *::after {
            box-sizing: inherit;
        }

        img, svg, video {
            max-width: 100%;
            height: auto;
        }

        /* 2. HEADER: Clean White Frosted Bar - ABSOLUTELY NO BLUE BOX */
        .elementor-location-header {
            position: relative !important;
            z-index: 9999 !important;
            background: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(237, 108, 54, 0.18) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            margin-bottom: 0 !important;
        }

        /* Remove any blue or colored background on header columns/containers */
        .elementor-location-header .elementor-container,
        .elementor-location-header .e-con,
        .elementor-location-header .elementor-column,
        .elementor-location-header .elementor-widget-wrap,
        .elementor-location-header div[class*="elementor-element-5ff7ee21"],
        .elementor-location-header [data-id="5ff7ee21"] {
            background: transparent !important;
            background-color: transparent !important;
            box-shadow: none !important;
        }

        /* Header Logo */
        .elementor-location-header img {
            max-height: 52px !important;
            width: auto !important;
            object-fit: contain !important;
            display: block;
        }

        /* Header Navigation Links: Dark high-contrast, NOT white! */
        .elementor-location-header a,
        .elementor-location-header .elementor-item,
        .elementor-location-header .ekit-menu-nav-link,
        .elementor-location-header .jkit-menu-wrapper li a {
            color: #0f172a !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            text-transform: capitalize !important;
            transition: color 0.2s ease !important;
        }

        .elementor-location-header a:hover,
        .elementor-location-header .elementor-item:hover,
        .elementor-location-header .elementor-item.elementor-item-active,
        .elementor-location-header .ekit-menu-nav-link:hover,
        .elementor-location-header .jkit-menu-wrapper li a:hover {
            color: var(--rama-orange) !important;
        }

        /* Hamburger icon for mobile */
        .elementor-location-header .jkit-hamburger-menu,
        .elementor-location-header .elementskit-menu-hamburger {
            color: #0f172a !important;
        }

        /* 3. HERO FROSTED GLASS BLUR CONTAINER & PERFECT CENTERING */
        .elementor-section.rama-hero-section .elementor-container,
        .elementor-section:has(.rama-hero-card) .elementor-container,
        .elementor-section:has(.elementor-element-fd3bd608) .elementor-container {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
            float: none !important;
            width: 100% !important;
            max-width: 960px !important;
        }

        .elementor-section.rama-hero-section .elementor-column,
        .elementor-column.rama-hero-card,
        .elementor-column.elementor-element-fd3bd608,
        .rama-hero-card {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
            max-width: 880px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            float: none !important;
        }

        .elementor-section.rama-hero-section .elementor-widget-wrap,
        .elementor-column.elementor-element-fd3bd608 > .elementor-widget-wrap,
        .rama-hero-card > .elementor-widget-wrap {
            backdrop-filter: blur(24px) saturate(190%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(190%) !important;
            background: rgba(15, 23, 42, 0.78) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35) !important;
            border-radius: 24px !important;
            padding: 48px 40px !important;
            max-width: 880px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .rama-hero-card h1,
        .rama-hero-card h1.elementor-heading-title {
            color: #ffffff !important;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.7) !important;
            font-weight: 800 !important;
        }

        .rama-hero-card h3,
        .rama-hero-card h3.elementor-heading-title,
        .rama-hero-card p {
            color: #f1f5f9 !important;
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6) !important;
            font-size: 1.25rem !important;
            line-height: 1.6 !important;
        }

        /* 4. CONTENT CARDS & TESTIMONIALS (FROSTED LIGHT GLASS) */
        .ekit-testimonial-item,
        .elementskit-testimonial-slider,
        .elementor-widget-elementskit-testimonial,
        .elementor-widget-image-box .elementor-image-box-content,
        .ekit-wid-con .elementskit-infobox,
        .elementor-widget-icon-box {
            backdrop-filter: blur(16px) saturate(160%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(160%) !important;
            background: rgba(255, 255, 255, 0.90) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
            border-radius: 16px !important;
            padding: 28px !important;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease !important;
        }

        /* Ensure all text inside light cards is dark and readable */
        .elementor-widget-text-editor,
        .elementor-widget-text-editor p,
        .elementor-widget-text-editor li {
            color: #1e293b;
            line-height: 1.7;
        }

        /* 5. Brand Action Buttons (Orange #ED6C36) */
        .elementor-button,
        .elementor-button.elementor-size-md,
        .elementor-button.elementor-size-lg,
        a.elementskit-btn,
        .btn-primary {
            background-color: var(--rama-orange) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-radius: 50px !important;
            padding: 14px 34px !important;
            box-shadow: 0 4px 14px rgba(237, 108, 54, 0.35) !important;
            transition: all 0.25s ease !important;
            border: none !important;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .elementor-button:hover,
        a.elementskit-btn:hover {
            background-color: var(--rama-mango) !important;
            box-shadow: 0 6px 20px rgba(234, 86, 13, 0.45) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        /* 6. Fluid Typography */
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

        /* 7. Mobile / Tablet Responsive Resets */
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

            .rama-hero-card {
                padding: 32px 20px !important;
                width: 95% !important;
            }
        }

        @media (max-width: 767px) {
            .elementor-section {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }

            .elementor-button {
                width: 100% !important;
                text-align: center !important;
                margin-bottom: 10px;
            }
        }
    </style>
    <?php
}, 100 );
