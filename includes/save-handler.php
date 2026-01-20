<?php
if (!defined('ABSPATH')) exit;

add_action('pmpro_after_checkout', function ($user_id) {

    if (!empty($_POST['qr_identity'])) {
        update_user_meta(
            $user_id,
            'qr_identity',
            sanitize_text_field($_POST['qr_identity'])
        );
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'qr_') === 0) {
            update_user_meta($user_id, $key, sanitize_text_field($value));
        }
    }
});
