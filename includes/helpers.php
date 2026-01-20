<?php
if (!defined('ABSPATH')) exit;

/* Get identity */
function qr_get_identity($user_id = null) {
    $user_id = $user_id ?: get_current_user_id();
    return get_user_meta($user_id, 'qr_identity', true);
}

/* Check identity */
function qr_user_is($type) {
    return qr_get_identity() === $type;
}
