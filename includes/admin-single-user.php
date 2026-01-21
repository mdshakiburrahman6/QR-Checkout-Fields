<?php
if (!defined('ABSPATH')) exit;

function qr_cf_render_single_user_page() {

    if (empty($_GET['user_id'])) return;

    $user_id = intval($_GET['user_id']);
    $user = get_user_by('id', $user_id);
    if (!$user) return;

    $config   = get_option('qr_cf_fields', []);
    $meta     = get_user_meta($user_id);
    $identity = $meta['qr_identity'][0] ?? '';

    echo '<div class="wrap">';
    echo '<h1>User Data: ' . esc_html($user->user_login) . '</h1>';

    echo '<table class="widefat striped">';
    echo '<thead>
            <tr>
                <th style="width:30%">Field</th>
                <th>Value</th>
            </tr>
          </thead>
          <tbody>';

    /* =========================
       Identity (Always First)
    ========================= */
    if ($identity) {
        echo '<tr>
                <th>Identity</th>
                <td><strong>' . esc_html(ucwords(str_replace('_', ' ', $identity))) . '</strong></td>
              </tr>';
    }

    /* =========================
       Decide Which Groups to Show
    ========================= */
    $groups_to_show = ['global'];

    if ($identity === 'driver') {
        $groups_to_show[] = 'driver';
    }
    elseif ($identity === 'owner') {
        $groups_to_show[] = 'owner';
    }
    elseif ($identity === 'driver_owner') {
        $groups_to_show[] = 'driver';
        $groups_to_show[] = 'owner';
        $groups_to_show[] = 'driver_owner';
    }

    /* =========================
       Loop Fields
    ========================= */
    foreach ($groups_to_show as $group) {

        if (empty($config[$group])) continue;

        foreach ($config[$group] as $index => $field) {

            $meta_key = "qr_{$group}_{$index}";
            if (empty($meta[$meta_key][0])) continue;

            $value = $meta[$meta_key][0];
            $label = $field['label'] ?? $meta_key;

            echo '<tr>';
            echo '<th>' . esc_html($label) . '</th>';
            echo '<td>';

            /* IMAGE FIELD */
            if (($field['type'] ?? '') === 'image' && is_numeric($value)) {

                echo wp_get_attachment_image(
                    intval($value),
                    'medium',
                    false,
                    ['style' => 'max-width:220px;height:auto;border-radius:6px']
                );

            }
            /* TEXT / TEXTAREA */
            else {
                echo esc_html($value);
            }

            echo '</td></tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';
}
