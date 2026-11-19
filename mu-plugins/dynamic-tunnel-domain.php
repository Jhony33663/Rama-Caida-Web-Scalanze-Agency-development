<?php
/**
 * Plugin Name: Dynamic Tunnel & Cloudflare Domain Preview
 * Description: Allows WordPress to be served seamlessly over Cloudflare Tunnel (trycloudflare or custom domain) without canonical redirect loops or broken asset URLs.
 * Author: Antigravity
 * Version: 2.0.0
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
    }, 9999 );

    add_filter( 'option_home', function() use ( $current_url ) {
        return $current_url;
    }, 9999 );

    add_filter( 'site_url', function( $url ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $url );
    }, 9999 );

    add_filter( 'home_url', function( $url ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $url );
    }, 9999 );

    // 3. Filter Enqueued Scripts and Styles
    add_filter( 'style_loader_src', function( $src ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $src );
    }, 9999 );

    add_filter( 'script_loader_src', function( $src ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $src );
    }, 9999 );

    // 4. Filter Attachment & Upload URLs
    add_filter( 'wp_get_attachment_url', function( $url ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $url );
    }, 9999 );

    add_filter( 'content_url', function( $url ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $url );
    }, 9999 );

    add_filter( 'plugins_url', function( $url ) use ( $current_url ) {
        return str_replace( [ 'https://rama-caida.local', 'http://rama-caida.local' ], $current_url, $url );
    }, 9999 );

    // 5. Global Output Buffer: Replace ALL occurrences of local domain in HTML, CSS, JSON, and JS
    ob_start( function( $buffer ) use ( $current_url ) {
        if ( empty( $buffer ) ) {
            return $buffer;
        }
        return str_replace(
            [
                'https://rama-caida.local',
                'http://rama-caida.local',
                'https:\/\/rama-caida.local',
                'http:\/\/rama-caida.local',
                '\/\/rama-caida.local',
                '//rama-caida.local'
            ],
            [
                $current_url,
                $current_url,
                str_replace( '/', '\/', $current_url ),
                str_replace( '/', '\/', $current_url ),
                str_replace( '/', '\/', '//' . parse_url( $current_url, PHP_URL_HOST ) ),
                '//' . parse_url( $current_url, PHP_URL_HOST )
            ],
            $buffer
        );
    } );
}
