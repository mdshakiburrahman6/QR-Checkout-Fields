<?php
/**
 * Plugin Name: QR Checkout Fields
 * Description: Identity-based conditional checkout fields for Paid Memberships Pro.
 * Version: 4.0
 * Author: Md Shakibur Rahman
 */

if (!defined('ABSPATH')) exit;

define('QR_CF_PATH', plugin_dir_path(__FILE__));
define('QR_CF_URL', plugin_dir_url(__FILE__));

/*---------------------------------------------------
  Load Files
---------------------------------------------------*/
require_once QR_CF_PATH . 'includes/helpers.php';
require_once QR_CF_PATH . 'includes/admin-page.php';
require_once QR_CF_PATH . 'includes/frontend-fields.php';
require_once QR_CF_PATH . 'includes/save-handler.php';

/*---------------------------------------------------
  Assets
---------------------------------------------------*/
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'settings_page_qr-checkout-fields') return;

    wp_enqueue_style('qr-admin-css', QR_CF_URL . 'assets/css/admin.css');
    wp_enqueue_script('qr-admin-js', QR_CF_URL . 'assets/js/admin.js', ['jquery'], null, true);
});

add_action('wp_enqueue_scripts', function () {
    if (!function_exists('pmpro_is_checkout')) return;
    if (!pmpro_is_checkout()) return;

    wp_enqueue_style('qr-front-css', QR_CF_URL . 'assets/css/frontend.css');
    wp_enqueue_script('qr-front-js', QR_CF_URL . 'assets/js/frontend.js', [], null, true);
});
