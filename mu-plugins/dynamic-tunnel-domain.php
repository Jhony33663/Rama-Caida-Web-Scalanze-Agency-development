<?php
/**
 * Plugin Name: Dynamic Tunnel & Cloudflare Domain Preview
 * Description: Allows WordPress to be served seamlessly over Cloudflare Tunnel (trycloudflare or custom domain) without canonical redirect loops or broken asset URLs.
 * Author: Antigravity
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check incoming Host
$http_host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? '';

if ( ! empty( $http_host ) && strpos( $http_host, 'rama-caida.local' ) === false ) {
    $scheme = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) || 
              ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ||
              ( ! empty( $_SERVER['HTTP_CF_VISITOR'] ) && strpos( $_SERVER['HTTP_CF_VISITOR'], 'https' ) !== false ) ? 'https' : 'http';

    $current_url = $scheme . '://' . $http_host;

    // 1. Disable canonical redirect to local host
    remove_action( 'template_redirect', 'redirect_canonical' );

    // 2. Filter siteurl and home
    add_filter( 'option_siteurl', function() use ( $current_url ) {
        return $current_url;
    }, 999 );

    add_filter( 'option_home', function() use ( $current_url ) {
        return $current_url;
    }, 999 );

    add_filter( 'site_url', function( $url ) use ( $current_url ) {
        return str_replace( 'http://rama-caida.local', $current_url, $url );
    }, 999 );

    add_filter( 'home_url', function( $url ) use ( $current_url ) {
        return str_replace( 'http://rama-caida.local', $current_url, $url );
    }, 999 );

    // 3. Filter Elementor upload and asset URLs
    add_filter( 'wp_get_attachment_url', function( $url ) use ( $current_url ) {
        return str_replace( 'http://rama-caida.local', $current_url, $url );
    }, 999 );

    // 4. Output buffer to replace any remaining hardcoded local links
    add_action( 'template_redirect', function() use ( $current_url ) {
        ob_start( function( $buffer ) use ( $current_url ) {
            return str_replace( 'http://rama-caida.local', $current_url, $buffer );
        } );
    }, 1 );
}
