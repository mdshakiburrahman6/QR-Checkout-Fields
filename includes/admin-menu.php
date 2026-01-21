<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {

    // Parent Menu
    add_menu_page(
        'QR Checkout Fields',
        'QR Checkout Fields',
        'manage_options',
        'qr-checkout-fields',
        'qr_cf_render_admin_page',
        'dashicons-feedback',
        58
    );

    // Edit Fields (default)
    add_submenu_page(
        'qr-checkout-fields',
        'Edit Fields',
        'Edit Fields',
        'manage_options',
        'qr-checkout-fields',
        'qr_cf_render_admin_page'
    );

    // All Data
    add_submenu_page(
        'qr-checkout-fields',
        'All Data',
        'All Data',
        'manage_options',
        'qr-checkout-all-data',
        'qr_cf_render_all_data_page'
    );

    // Hidden: View Single User
    add_submenu_page(
        null,
        'View User Data',
        'View User Data',
        'manage_options',
        'qr-checkout-view-user',
        'qr_cf_render_single_user_page'
    );
});
