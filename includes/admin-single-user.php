<?php
if (!defined('ABSPATH')) exit;

function qr_cf_render_single_user_page() {

    if (empty($_GET['user_id'])) return;

    $user_id = intval($_GET['user_id']);
    $user = get_user_by('id', $user_id);
    if (!$user) return;

    $config = get_option('qr_cf_fields', []);
    $meta   = get_user_meta($user_id);

    echo '<div class="wrap">';
    echo '<h1>User Data: ' . esc_html($user->user_login) . '</h1>';

    echo '<table class="widefat striped">';
    echo '<thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>';

    /* =========================
       Identity
    ========================= */
    if (!empty($meta['qr_identity'][0])) {
        echo '<tr>
            <th>Identity</th>
            <td>' . esc_html(ucwords(str_replace('_', ' ', $meta['qr_identity'][0]))) . '</td>
        </tr>';
    }

    /* =========================
       Loop Config Fields
    ========================= */
    foreach ($config as $group => $fields) {

        foreach ($fields as $index => $field) {

            $meta_key = "qr_{$group}_{$index}";
            if (empty($meta[$meta_key][0])) continue;

            $value = $meta[$meta_key][0];
            $label = $field['label'] ?? $meta_key;

            echo '<tr>';
            echo '<th>' . esc_html($label) . '</th>';
            echo '<td>';

            // Image field
            if ($field['type'] === 'image' && is_numeric($value)) {

                $img = wp_get_attachment_image($value, 'medium');
                echo $img ?: esc_html($value);

            } else {
                echo esc_html($value);
            }

            echo '</td></tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';
}
