<?php
if (!defined('ABSPATH')) exit;

/* Admin Menu */
add_action('admin_menu', function () {
    add_menu_page(
        'QR Checkout Fields',
        'QR Checkout Fields',
        'manage_options',
        'qr-checkout-fields',
        'qr_cf_admin_page',
        'dashicons-forms',
        58
    );
});

/* Register option */
add_action('admin_init', function () {
    register_setting('qr_cf_group', 'qr_cf_fields');
});

/* Admin Page */
function qr_cf_admin_page() {

    if (!current_user_can('manage_options')) return;

    $config = get_option('qr_cf_fields', [
        'driver' => [],
        'owner' => [],
        'driver_owner' => [],
    ]);
    ?>
    <div class="wrap">
        <h1>QR Checkout Fields</h1>

        <form method="post" action="options.php">
            <?php settings_fields('qr_cf_group'); ?>

            <?php
            $groups = [
                'driver' => 'Driver Fields',
                'owner' => 'Owner Fields',
                'driver_owner' => 'Driver & Owner Fields'
            ];

            foreach ($groups as $key => $title): ?>
                <h2><?php echo esc_html($title); ?></h2>

                <table class="widefat qr-table" data-group="<?php echo esc_attr($key); ?>">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Width</th>
                            <th>Required</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <p>
                    <button type="button"
                            class="button qr-add-row"
                            data-group="<?php echo esc_attr($key); ?>">
                        ➕ Add Field
                    </button>
                </p>
            <?php endforeach; ?>

            <?php submit_button('Save Fields'); ?>
        </form>
    </div>
    <?php
}
