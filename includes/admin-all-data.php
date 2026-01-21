<?php
if (!defined('ABSPATH')) exit;

function qr_cf_render_all_data_page() {

    $users = get_users();

    echo '<div class="wrap">';
    echo '<h1>QR Checkout – All User Data</h1>';

    echo '<table class="widefat striped">';
    echo '<thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Identity</th>
                <th>Action</th>
            </tr>
          </thead><tbody>';

    foreach ($users as $user) {

        $identity = get_user_meta($user->ID, 'qr_identity', true);

        $view_url = admin_url(
            'admin.php?page=qr-checkout-view-user&user_id=' . $user->ID
        );

        echo '<tr>
            <td>' . esc_html($user->user_login) . '</td>
            <td>' . esc_html($user->user_email) . '</td>
            <td>' . esc_html($identity ?: '—') . '</td>
            <td><a class="button button-primary" href="' . esc_url($view_url) . '">View Data</a></td>
        </tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}
