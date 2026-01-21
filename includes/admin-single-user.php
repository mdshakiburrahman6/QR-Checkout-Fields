<?php
if (!defined('ABSPATH')) exit;

function qr_cf_render_single_user_page() {

    if (empty($_GET['user_id'])) return;

    $user_id = intval($_GET['user_id']);
    $user = get_user_by('id', $user_id);

    if (!$user) return;

    echo '<div class="wrap">';
    echo '<h1>User Data: ' . esc_html($user->user_login) . '</h1>';

    echo '<table class="widefat striped">';

    $meta = get_user_meta($user_id);

    foreach ($meta as $key => $values) {

        if (strpos($key, 'qr_') !== 0) continue;

        $value = $values[0];

        // Image handling
        if (is_numeric($value) && get_post_type($value) === 'attachment') {
            $img = wp_get_attachment_image($value, 'thumbnail');
            $value = $img ?: $value;
        } else {
            $value = esc_html($value);
        }

        echo '<tr>
            <th>' . esc_html($key) . '</th>
            <td>' . $value . '</td>
        </tr>';
    }

    echo '</table>';
    echo '</div>';
}
