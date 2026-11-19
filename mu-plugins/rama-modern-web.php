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

        /* 5. Brand Action Buttons (Orange #ED6C36) - Refined Elegant Sizing */
        .elementor-button,
        .elementor-button.elementor-size-md,
        .elementor-button.elementor-size-lg,
        a.elementskit-btn,
        .btn-primary {
            background-color: var(--rama-orange) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 0.88rem !important;
            border-radius: 50px !important;
            padding: 10px 24px !important;
            box-shadow: 0 3px 10px rgba(237, 108, 54, 0.25) !important;
            transition: all 0.25s ease !important;
            border: none !important;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: inline-block !important;
            line-height: 1.3 !important;
        }
        .elementor-button:hover,
        a.elementskit-btn:hover {
            background-color: var(--rama-mango) !important;
            box-shadow: 0 5px 16px rgba(234, 86, 13, 0.35) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        /* Header CTA button */
        .elementor-location-header .elementor-button {
            padding: 8px 18px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
        }

        /* Hero & Banner CTA buttons */
        .rama-hero-card .elementor-button,
        .rama-cta-glass-card .elementor-button {
            padding: 11px 26px !important;
            font-size: 0.92rem !important;
            font-weight: 600 !important;
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

        /* 8. SERVICES SECTION HARMONY, SCROLL PANEL & EXACT BUTTON ALIGNMENT */
        .rama-services-section .elementor-container {
            display: flex !important;
            align-items: stretch !important;
            gap: 24px !important;
        }

        .rama-services-section .elementor-column,
        .rama-service-card,
        .elementor-column.rama-service-card {
            display: flex !important;
            flex-direction: column !important;
            height: auto !important;
        }

        .rama-services-section .elementor-widget-wrap,
        .rama-service-card > .elementor-widget-wrap,
        .elementor-column.rama-service-card > .elementor-widget-wrap,
        .rama-service-card .elementor-element-populated {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            flex: 1 1 auto !important;
        }

        .rama-services-section .elementor-widget-image,
        .rama-service-card .elementor-widget-image {
            margin-bottom: 16px !important;
            width: 100% !important;
        }

        .rama-services-section .elementor-widget-image img,
        .rama-service-card .elementor-widget-image img,
        .rama-service-thumb img {
            width: 100% !important;
            height: 240px !important;
            aspect-ratio: 4 / 3 !important;
            object-fit: cover !important;
            object-position: center !important;
            border-radius: 14px !important;
            display: block !important;
            margin: 0 !important;
        }

        /* Equalize title height strictly across ALL 3 cards so scroll panels & buttons align 100% */
        .rama-services-section .rama-service-title,
        .rama-services-section .rama-service-card .elementor-widget-heading {
            flex: 0 0 72px !important;
            height: 72px !important;
            min-height: 72px !important;
            max-height: 72px !important;
            margin-top: 0 !important;
            margin-bottom: 12px !important;
            display: block !important;
            overflow: hidden !important;
        }

        .rama-services-section .rama-service-title .elementor-widget-container,
        .rama-services-section .rama-service-card .elementor-widget-heading .elementor-widget-container {
            height: 100% !important;
            display: flex !important;
            align-items: flex-start !important;
        }

        .rama-services-section .rama-service-title h3,
        .rama-services-section .rama-service-title h3.elementor-heading-title,
        .rama-services-section .rama-service-card h3.elementor-heading-title {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 1.45rem !important;
            line-height: 1.25 !important;
            color: var(--rama-orange) !important;
        }

        /* Fixed height for text editor widget container across all 3 cards */
        .rama-services-section .elementor-widget-text-editor {
            flex: 0 0 175px !important;
            height: 175px !important;
            min-height: 175px !important;
            max-height: 175px !important;
            margin-bottom: 20px !important;
        }

        /* Scroll panel for service card text - identical fixed height */
        .rama-scroll-panel {
            max-height: 175px !important;
            height: 175px !important;
            min-height: 175px !important;
            overflow-y: auto !important;
            padding-right: 12px !important;
            margin: 0 !important;
            --scrollbar-thumb: var(--rama-orange);
            --scrollbar-track: rgba(0, 0, 0, 0.06);
            scrollbar-color: var(--scrollbar-thumb) var(--scrollbar-track);
            scrollbar-width: thin;
        }

        @supports not (scrollbar-color: auto) {
            .rama-scroll-panel {
                scrollbar-width: auto;
            }
            .rama-scroll-panel::-webkit-scrollbar {
                width: 6px;
            }
            .rama-scroll-panel::-webkit-scrollbar-thumb {
                background: var(--rama-orange);
                border-radius: 4px;
            }
            .rama-scroll-panel::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.06);
            }
        }

        .rama-scroll-panel p {
            margin-bottom: 12px !important;
            font-size: 0.93rem !important;
            line-height: 1.65 !important;
            color: #334155 !important;
        }

        /* Service Cards CTA Button - Sleek & Horizontally Aligned */
        .rama-services-section .rama-service-btn,
        .rama-services-section .rama-service-card .elementor-widget-button {
            margin-top: auto !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
        }

        .rama-services-section .rama-service-btn .elementor-button,
        .rama-services-section .rama-service-card .elementor-button {
            padding: 9px 22px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.03em !important;
            border-radius: 50px !important;
            box-shadow: 0 3px 10px rgba(237, 108, 54, 0.22) !important;
        }

        /* 8.5. GET TO KNOW US: Vertically Centered & Balanced Proportions */
        .rama-about-section {
            padding-top: 70px !important;
            padding-bottom: 70px !important;
            background-color: #f1f5f9 !important;
        }

        .rama-about-section .elementor-container {
            display: flex !important;
            align-items: center !important; /* Center columns vertically in the middle */
            justify-content: center !important;
            gap: 36px !important;
            max-width: 1140px !important;
            margin: 0 auto !important;
        }

        .rama-about-section .rama-about-img-col,
        .rama-about-section .elementor-column:first-child {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .rama-about-section .elementor-widget-image {
            width: 100% !important;
            margin: 0 !important;
        }

        .rama-about-section .elementor-widget-image img {
            width: 100% !important;
            height: 440px !important;
            aspect-ratio: 4 / 3 !important;
            object-fit: cover !important;
            object-position: center !important;
            border-radius: 20px !important;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08) !important;
            display: block !important;
        }

        .rama-about-section .rama-about-card-col,
        .rama-about-section .elementor-column:last-child {
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        .rama-about-section .rama-about-card-col > .elementor-widget-wrap,
        .rama-about-section .elementor-column:last-child > .elementor-widget-wrap {
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            padding: 44px 40px !important;
            border-radius: 20px !important;
        }

        .rama-about-section h2,
        .rama-about-section h2.elementor-heading-title {
            margin-top: 0 !important;
            margin-bottom: 16px !important;
            font-size: 2.1rem !important;
        }

        .rama-about-section p {
            line-height: 1.75 !important;
            color: #334155 !important;
            font-size: 1.05rem !important;
            margin-bottom: 16px !important;
        }

        .rama-about-section .elementor-widget-button {
            margin-top: 10px !important;
        }

        @media (max-width: 1024px) {
            .rama-about-section .elementor-container {
                flex-direction: column !important;
                gap: 28px !important;
            }
            .rama-about-section .elementor-widget-image img {
                height: 340px !important;
            }
        }

        /* 9. GRAB YOUR SPOT (SUBTLE BLACK FROSTED GLASS 00000) */
        .elementor-section:has(.rama-cta-glass-card) .elementor-container {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
            max-width: 900px !important;
        }

        .rama-cta-glass-card,
        .elementor-column.rama-cta-glass-card,
        .elementor-column.rama-cta-glass-card > .elementor-widget-wrap {
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            background: rgba(0, 0, 0, 0.65) !important; /* sutil negro #000000 */
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45) !important;
            border-radius: 24px !important;
            padding: 48px 40px !important;
            max-width: 840px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }

        .rama-cta-glass-card h2,
        .rama-cta-glass-card h2.elementor-heading-title {
            color: #ffffff !important;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.7) !important;
            font-weight: 800 !important;
        }

        .rama-cta-glass-card p {
            color: #f8fafc !important;
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6) !important;
            font-size: 1.2rem !important;
            line-height: 1.7 !important;
            max-width: 720px !important;
            margin: 15px auto 25px !important;
        }

        /* 10. PORTFOLIO CAROUSEL & VISUAL HARMONY */
        .rama-portfolio-section {
            position: relative !important;
            overflow: hidden !important;
            padding-top: 80px !important;
            padding-bottom: 90px !important;
        }

        .rama-portfolio-section .elementor-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            position: relative !important;
        }

        .rama-portfolio-carousel {
            position: relative !important;
            padding: 10px 0 50px 0 !important;
        }

        .rama-portfolio-carousel .elementor-image-carousel-wrapper,
        .rama-portfolio-carousel .swiper {
            overflow: visible !important;
            padding-bottom: 20px !important;
        }

        .rama-portfolio-carousel .swiper-slide {
            padding: 10px 12px !important;
            box-sizing: border-box !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .rama-portfolio-carousel .swiper-slide-inner {
            width: 100% !important;
            border-radius: 18px !important;
            overflow: hidden !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            transition: transform 0.35s ease, box-shadow 0.35s ease !important;
            background: #ffffff !important;
        }

        .rama-portfolio-carousel .swiper-slide-inner:hover {
            transform: translateY(-8px) scale(1.02) !important;
            box-shadow: 0 20px 45px rgba(237, 108, 54, 0.22) !important;
        }

        .rama-portfolio-carousel img,
        .rama-portfolio-carousel .swiper-slide-image {
            width: 100% !important;
            height: 380px !important;
            aspect-ratio: 3 / 4 !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            border-radius: 18px !important;
        }

        /* Swiper Navigation Arrows */
        .rama-portfolio-carousel .elementor-swiper-button {
            position: absolute !important;
            top: 45% !important;
            transform: translateY(-50%) !important;
            z-index: 20 !important;
            width: 48px !important;
            height: 48px !important;
            background: var(--rama-orange) !important;
            border-radius: 50% !important;
            box-shadow: 0 6px 20px rgba(237, 108, 54, 0.45) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .rama-portfolio-carousel .elementor-swiper-button:hover {
            background: var(--rama-green) !important;
            transform: translateY(-50%) scale(1.12) !important;
            box-shadow: 0 8px 25px rgba(10, 95, 45, 0.4) !important;
        }

        .rama-portfolio-carousel .elementor-swiper-button svg,
        .rama-portfolio-carousel .elementor-swiper-button i {
            width: 18px !important;
            height: 18px !important;
            font-size: 18px !important;
            fill: #ffffff !important;
            color: #ffffff !important;
            transition: fill 0.2s ease !important;
        }

        .rama-portfolio-carousel .elementor-swiper-button-prev {
            left: -22px !important;
        }

        .rama-portfolio-carousel .elementor-swiper-button-next {
            right: -22px !important;
        }

        /* Swiper Pagination Bullets */
        .rama-portfolio-carousel .swiper-pagination {
            bottom: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
        }

        .rama-portfolio-carousel .swiper-pagination-bullet {
            background: #cbd5e1 !important;
            opacity: 0.8 !important;
            width: 10px !important;
            height: 10px !important;
            border-radius: 50% !important;
            margin: 0 !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .rama-portfolio-carousel .swiper-pagination-bullet:hover {
            background: var(--rama-orange) !important;
            opacity: 1 !important;
        }

        .rama-portfolio-carousel .swiper-pagination-bullet-active {
            background: var(--rama-orange) !important;
            opacity: 1 !important;
            width: 32px !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(237, 108, 54, 0.4) !important;
        }

        @media (max-width: 1024px) {
            .rama-portfolio-carousel .elementor-swiper-button-prev {
                left: 0px !important;
            }
            .rama-portfolio-carousel .elementor-swiper-button-next {
                right: 0px !important;
            }
            .rama-portfolio-carousel img,
            .rama-portfolio-carousel .swiper-slide-image {
                height: 340px !important;
                aspect-ratio: 3 / 4 !important;
            }
        }

        @media (max-width: 767px) {
            .rama-portfolio-carousel img,
            .rama-portfolio-carousel .swiper-slide-image {
                height: 310px !important;
                aspect-ratio: 3 / 4 !important;
            }
            .rama-portfolio-carousel .elementor-swiper-button {
                width: 40px !important;
                height: 40px !important;
            }
            .rama-portfolio-carousel .elementor-swiper-button svg {
                width: 14px !important;
                height: 14px !important;
            }
        }

        /* 11. FULLSCREEN MOBILE OVERLAY MENU & ALL OPTIONS VISIBLE */
        @media (max-width: 1024px) {
            .elementor-location-header {
                position: sticky !important;
                top: 0 !important;
                z-index: 99999 !important;
                padding: 10px 18px !important;
                width: 100% !important;
            }

            .elementor-location-header .elementor-element-239e92cf,
            .elementor-location-header .elementor-container,
            .elementor-location-header .e-con {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Logo */
            .elementor-location-header .elementor-element-5ff7ee21 {
                flex: 0 0 auto !important;
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .elementor-location-header .elementor-element-19349cb8 img {
                max-height: 44px !important;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
            }

            /* Right nav & controls */
            .elementor-location-header .elementor-element-7bd7624a {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: flex-end !important;
                gap: 12px !important;
                flex: 0 0 auto !important;
                margin: 0 !important;
            }

            .elementor-location-header .elementor-element-279bfdbc {
                display: none !important;
            }

            /* Clean Hamburger Button */
            .elementor-location-header .jkit-hamburger-menu {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 44px !important;
                height: 44px !important;
                background: rgba(237, 108, 54, 0.08) !important;
                border: 1.5px solid rgba(237, 108, 54, 0.25) !important;
                border-radius: 12px !important;
                cursor: pointer !important;
                padding: 0 !important;
                color: var(--rama-orange) !important;
                transition: all 0.25s ease !important;
            }

            .elementor-location-header .jkit-hamburger-menu:hover,
            .elementor-location-header .jkit-hamburger-menu:active {
                background: var(--rama-orange) !important;
                color: #ffffff !important;
                border-color: var(--rama-orange) !important;
            }

            .elementor-location-header .jkit-hamburger-menu i,
            .elementor-location-header .jkit-hamburger-menu svg {
                font-size: 22px !important;
                width: 22px !important;
                height: 22px !important;
                fill: currentColor !important;
            }

            /* TRUE FULLSCREEN MOBILE MENU MODAL (100vw x 100dvh) */
            .elementor-location-header .jkit-menu-wrapper {
                display: none !important;
            }

            /* Active State: 100% Fullscreen Viewport */
            .elementor-location-header .jkit-menu-wrapper.active {
                display: flex !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                max-width: 100vw !important;
                min-width: 100vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                min-height: 100dvh !important;
                background: #ffffff !important;
                box-shadow: none !important;
                z-index: 9999999 !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                padding: 20px 24px 36px 24px !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
                border-radius: 0 !important;
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                transform: none !important;
            }

            /* Fullscreen Menu Top Header Bar (Logo + Close Button) */
            .elementor-location-header .jkit-nav-identity-panel {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                padding-bottom: 16px !important;
                margin-bottom: 20px !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
                order: 1 !important;
                flex-shrink: 0 !important;
            }

            .elementor-location-header .jkit-nav-identity-panel .jkit-nav-site-title {
                display: flex !important;
                align-items: center !important;
            }

            .elementor-location-header .jkit-nav-identity-panel .jkit-nav-logo {
                display: block !important;
                width: 150px !important;
                height: 44px !important;
                background-image: url('http://rama-caida.local/wp-content/uploads/2026/11/logo_orange_clean.webp') !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: left center !important;
            }

            /* Close Button */
            .elementor-location-header .jkit-close-menu {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 44px !important;
                height: 44px !important;
                border-radius: 50% !important;
                background: rgba(237, 108, 54, 0.1) !important;
                border: 1px solid rgba(237, 108, 54, 0.25) !important;
                color: var(--rama-orange) !important;
                font-size: 22px !important;
                font-weight: 700 !important;
                cursor: pointer !important;
                margin: 0 !important;
                padding: 0 !important;
                float: none !important;
                transition: all 0.2s ease !important;
            }

            .elementor-location-header .jkit-close-menu:hover,
            .elementor-location-header .jkit-close-menu:active {
                background: var(--rama-orange) !important;
                color: #ffffff !important;
            }

            /* Menu Links Container */
            .elementor-location-header .jkit-menu-container {
                order: 2 !important;
                width: 100% !important;
                overflow-y: visible !important;
                flex: 1 1 auto !important;
                display: flex !important;
                flex-direction: column !important;
            }

            .elementor-location-header ul.jkit-menu {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                list-style: none !important;
                padding: 0 !important;
                margin: 0 !important;
                gap: 8px !important;
            }

            .elementor-location-header ul.jkit-menu > li.menu-item {
                width: 100% !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .elementor-location-header ul.jkit-menu > li.menu-item > a {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                font-size: 1.22rem !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                padding: 14px 12px !important;
                border-radius: 12px !important;
                text-decoration: none !important;
                transition: all 0.2s ease !important;
            }

            .elementor-location-header ul.jkit-menu > li.menu-item > a:hover,
            .elementor-location-header ul.jkit-menu > li.menu-item > a:active {
                background: rgba(237, 108, 54, 0.08) !important;
                color: var(--rama-orange) !important;
            }

            /* Sub-menu (Services) - ALWAYS VISIBLE & CLEARLY INDENTED */
            .elementor-location-header ul.jkit-menu .sub-menu {
                display: flex !important;
                flex-direction: column !important;
                visibility: visible !important;
                opacity: 1 !important;
                max-height: none !important;
                height: auto !important;
                position: static !important;
                background: #f8fafc !important;
                border-left: 3px solid var(--rama-orange) !important;
                border-radius: 0 12px 12px 0 !important;
                padding: 8px 12px !important;
                margin: 4px 0 14px 16px !important;
                gap: 6px !important;
                box-shadow: none !important;
                list-style: none !important;
            }

            .elementor-location-header ul.jkit-menu .sub-menu li {
                list-style: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .elementor-location-header ul.jkit-menu .sub-menu li a {
                display: flex !important;
                align-items: center !important;
                padding: 10px 12px !important;
                font-size: 1.02rem !important;
                font-weight: 600 !important;
                color: #334155 !important;
                border-radius: 8px !important;
                text-decoration: none !important;
                transition: all 0.2s ease !important;
            }

            .elementor-location-header ul.jkit-menu .sub-menu li a::before {
                content: "•" !important;
                color: var(--rama-orange) !important;
                font-size: 1.2rem !important;
                margin-right: 10px !important;
            }

            .elementor-location-header ul.jkit-menu .sub-menu li a:hover,
            .elementor-location-header ul.jkit-menu .sub-menu li a:active {
                color: var(--rama-orange) !important;
                background: rgba(237, 108, 54, 0.08) !important;
                transform: translateX(4px) !important;
            }

            /* Fullscreen Mobile Drawer Bottom CTA & Quick Contacts */
            .rama-mobile-drawer-footer {
                margin-top: 24px !important;
                padding-top: 20px !important;
                border-top: 1px solid rgba(0, 0, 0, 0.08) !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 14px !important;
                width: 100% !important;
            }

            .rama-mobile-drawer-cta {
                display: block !important;
                width: 100% !important;
                padding: 15px 24px !important;
                background-color: var(--rama-orange) !important;
                color: #ffffff !important;
                font-size: 1rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.05em !important;
                text-align: center !important;
                text-transform: uppercase !important;
                text-decoration: none !important;
                border-radius: 50px !important;
                box-shadow: 0 4px 14px rgba(237, 108, 54, 0.35) !important;
                transition: all 0.25s ease !important;
            }

            .rama-mobile-drawer-cta:hover,
            .rama-mobile-drawer-cta:active {
                background-color: var(--rama-mango) !important;
                transform: translateY(-2px) !important;
            }

            .rama-mobile-drawer-info {
                display: flex !important;
                flex-direction: column !important;
                gap: 6px !important;
                font-size: 0.88rem !important;
                color: #64748b !important;
                text-align: center !important;
            }
        }

        /* 12. Mobile / Tablet Responsive Resets */
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
    <script id="rama-caida-mobile-nav-js">
        (function() {
            function initMobileNav() {
                // Ensure #services ID exists on services section
                var servicesSec = document.querySelector('.rama-services-section');
                if (servicesSec && !servicesSec.id) {
                    servicesSec.id = 'services';
                }

                // Add footer CTA inside menu container if not present
                var menuContainer = document.querySelector('.elementor-location-header .jkit-menu-container');
                if (menuContainer && !menuContainer.querySelector('.rama-mobile-drawer-footer')) {
                    var footer = document.createElement('div');
                    footer.className = 'rama-mobile-drawer-footer';
                    footer.innerHTML = '<a href="/contact-us/" class="rama-mobile-drawer-cta">GET IN TOUCH</a><div class="rama-mobile-drawer-info"><span>📍 Doral, Florida</span><span>✉️ info@ramacaida.com</span></div>';
                    menuContainer.appendChild(footer);
                }

                // Global click capture delegation: 100% reliable across all devices
                document.addEventListener('click', function(e) {
                    var hamburger = e.target.closest('.jkit-hamburger-menu');
                    if (hamburger) {
                        e.preventDefault();
                        e.stopPropagation();
                        var wrapper = document.querySelector('.elementor-location-header .jkit-menu-wrapper');
                        if (wrapper) {
                            var willOpen = !wrapper.classList.contains('active');
                            wrapper.classList.toggle('active', willOpen);
                            document.body.style.overflow = willOpen ? 'hidden' : '';
                        }
                        return;
                    }

                    var closeBtn = e.target.closest('.jkit-close-menu');
                    if (closeBtn) {
                        e.preventDefault();
                        e.stopPropagation();
                        var wrapper = document.querySelector('.elementor-location-header .jkit-menu-wrapper');
                        if (wrapper) {
                            wrapper.classList.remove('active');
                            document.body.style.overflow = '';
                        }
                        return;
                    }

                    // Click on any link inside the mobile menu
                    var navLink = e.target.closest('.elementor-location-header .jkit-menu-wrapper a');
                    if (navLink) {
                        var href = navLink.getAttribute('href') || '';
                        
                        // Internal anchor link e.g. #services
                        if (href.startsWith('#')) {
                            e.preventDefault();
                            e.stopPropagation();
                            var wrapper = document.querySelector('.elementor-location-header .jkit-menu-wrapper');
                            if (wrapper) wrapper.classList.remove('active');
                            document.body.style.overflow = '';

                            var target = document.querySelector(href) || document.querySelector('.rama-services-section');
                            if (target) {
                                setTimeout(function() {
                                    var header = document.querySelector('.elementor-location-header');
                                    var offset = header ? header.offsetHeight : 70;
                                    var targetPos = target.getBoundingClientRect().top + window.pageYOffset - offset;
                                    window.scrollTo({ top: targetPos, behavior: 'smooth' });
                                }, 150);
                            } else {
                                window.location.href = '/' + href;
                            }
                            return;
                        }

                        // Real page link (e.g. /merchandising-sales/, /get-to-know-us/, /contact-us/)
                        // Force explicit navigation so no third-party script can cancel or block it
                        if (navLink.href) {
                            e.preventDefault();
                            e.stopPropagation();
                            window.location.href = navLink.href;
                        }
                    }
                }, true);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMobileNav);
            } else {
                initMobileNav();
            }
        })();
    </script>
    <?php
}, 100 );
