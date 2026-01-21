<?php
if (!defined('ABSPATH')) exit;

function qr_cf_render_single_user_page() {

    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    if (empty($_GET['user_id'])) return;

    $user_id = intval($_GET['user_id']);
    $user = get_user_by('id', $user_id);
    if (!$user) return;

    $config = get_option('qr_cf_fields', []);
    $meta   = get_user_meta($user_id);

    echo '<div class="wrap">';
    echo '<h1>Edit User Data: ' . esc_html($user->user_login) . '</h1>';

    echo '<form method="post">';
    wp_nonce_field('qr_cf_update_user');

    echo '<table class="widefat striped">';
    echo '<tbody>';

    /* Identity */
    $identity = $meta['qr_identity'][0] ?? '';
    echo '<tr><th>Identity</th><td>' . esc_html($identity) . '</td></tr>';

    foreach ($config as $group => $fields) {

        foreach ($fields as $index => $field) {

            $meta_key = "qr_{$group}_{$index}";
            $value = $meta[$meta_key][0] ?? '';
            $label = $field['label'] ?? $meta_key;

            echo '<tr><th>' . esc_html($label) . '</th><td>';

            if ($field['type'] === 'image') {

                if ($value) {
                    echo wp_get_attachment_image($value, 'medium');
                    echo '<br><label><input type="checkbox" name="remove_'.$meta_key.'"> Remove image</label>';
                }

            } else {

                echo '<input type="text"
                        name="update_'.$meta_key.'"
                        value="'.esc_attr($value).'"
                        style="width:100%">';
            }

            echo '</td></tr>';
        }
    }

    echo '</tbody></table>';

    submit_button('Save Changes');

    echo '</form>';
    echo '</div>';
}
