<?php
/**
 * Plugin Name: QR Checkout Fields
 * Description: Identity-based conditional checkout fields for Paid Memberships Pro.
 * Version: 2.1.0
 * Author: Md Shakibur Rahman
 * Text Domain: qr-checkout-fields
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

/*---------------------------------------------------
  Plugin Constants
---------------------------------------------------*/
define('QR_CF_VERSION', '4.0');
define('QR_CF_PATH', plugin_dir_path(__FILE__));
define('QR_CF_URL', plugin_dir_url(__FILE__));

/*---------------------------------------------------
  Load Required Files
---------------------------------------------------*/
require_once QR_CF_PATH . 'includes/helpers.php';
require_once QR_CF_PATH . 'includes/admin-page.php';
require_once QR_CF_PATH . 'includes/frontend-fields.php';
require_once QR_CF_PATH . 'includes/save-handler.php';

/*---------------------------------------------------
  Admin Assets
---------------------------------------------------*/
add_action('admin_enqueue_scripts', function ($hook) {

    // Load only on our plugin admin page
    if ($hook !== 'toplevel_page_qr-checkout-fields') {
        return;
    }

    wp_enqueue_style(
        'qr-cf-admin-css',
        QR_CF_URL . 'assets/css/admin.css',
        [],
        QR_CF_VERSION
    );

    wp_enqueue_script(
        'qr-cf-admin-js',
        QR_CF_URL . 'assets/js/admin.js',
        ['jquery'],
        QR_CF_VERSION,
        true
    );
});

/*---------------------------------------------------
  Frontend Assets (PMPro Checkout Only)
---------------------------------------------------*/
add_action('wp_enqueue_scripts', function () {

    if (!function_exists('pmpro_is_checkout') || !pmpro_is_checkout()) {
        return;
    }

    wp_enqueue_style(
        'qr-cf-frontend-css',
        QR_CF_URL . 'assets/css/frontend.css',
        [],
        QR_CF_VERSION
    );

    wp_enqueue_script(
        'qr-cf-frontend-js',
        QR_CF_URL . 'assets/js/frontend.js',
        [],
        QR_CF_VERSION,
        true
    );
});
