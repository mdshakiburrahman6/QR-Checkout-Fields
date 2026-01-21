<?php
if (!defined('ABSPATH')) exit;

add_action('pmpro_after_checkout', function ($user_id) {

    // Save identity
    if (!empty($_POST['qr_identity'])) {
        update_user_meta(
            $user_id,
            'qr_identity',
            sanitize_text_field($_POST['qr_identity'])
        );
    }

    // Save text fields
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'qr_') === 0 && !is_array($value)) {
            update_user_meta($user_id, $key, sanitize_text_field($value));
        }
    }

    // Save image fields (GLOBAL + CONDITIONAL)
    foreach ($_FILES as $key => $file) {

        if (strpos($key, 'qr_') !== 0 || empty($file['name'])) {
            continue;
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_handle_upload($key, 0);

        if (!is_wp_error($attachment_id)) {
            update_user_meta($user_id, $key, $attachment_id);
        }
    }
    

});

// EARLY identity save (before checkout completes)
add_action('pmpro_checkout_before_processing', function () {

    if (empty($_POST['qr_identity'])) {
        return;
    }

    // Logged-in user (rare but possible)
    if (is_user_logged_in()) {
        update_user_meta(
            get_current_user_id(),
            'qr_identity',
            sanitize_text_field($_POST['qr_identity'])
        );
    }
});

// FINAL fallback: user_register
add_action('user_register', function ($user_id) {

    // If identity already exists, do nothing
    if (get_user_meta($user_id, 'qr_identity', true)) {
        return;
    }

    if (!empty($_POST['qr_identity'])) {
        update_user_meta(
            $user_id,
            'qr_identity',
            sanitize_text_field($_POST['qr_identity'])
        );
    }
});

