<?php
if (!defined('ABSPATH')) exit;

/*---------------------------------------------------
  Admin Menu (TOP LEVEL)
---------------------------------------------------*/
add_action('admin_menu', function () {
    add_menu_page(
        'QR Checkout Fields',
        'QR Checkout Fields',
        'manage_options',
        'qr-checkout-fields',
        'qr_cf_render_admin_page',
        'dashicons-feedback',
        58
    );
});

/*---------------------------------------------------
  Register Option
---------------------------------------------------*/
add_action('admin_init', function () {
    register_setting(
        'qr_cf_settings_group',
        'qr_cf_fields'
    );
});

/*---------------------------------------------------
  Admin Page UI
---------------------------------------------------*/
function qr_cf_render_admin_page() {

    $config = get_option('qr_cf_fields', [
        'driver' => [],
        'owner' => [],
        'driver_owner' => [],
    ]);
    ?>
    <div class="wrap">
        <h1>QR Checkout Fields</h1>

        <form method="post" action="options.php">
            <?php settings_fields('qr_cf_settings_group'); ?>

            <?php
            $groups = [
                'driver' => 'Driver Fields',
                'owner' => 'Owner Fields',
                'driver_owner' => 'Driver & Owner Fields',
            ];

            foreach ($groups as $key => $title): ?>
                <h2><?php echo esc_html($title); ?></h2>

                <table class="widefat qr-fields-table" data-group="<?php echo esc_attr($key); ?>">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Width</th>
                            <th>Required</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($config[$key] as $i => $field): ?>
                        <tr>
                            <td>
                                <input type="text"
                                    name="qr_cf_fields[<?php echo $key ?>][<?php echo $i ?>][label]"
                                    value="<?php echo esc_attr($field['label']); ?>">
                            </td>

                            <td>
                                <select name="qr_cf_fields[<?php echo $key ?>][<?php echo $i ?>][type]">
                                    <option value="text" <?php selected($field['type'], 'text'); ?>>Text</option>
                                    <option value="textarea" <?php selected($field['type'], 'textarea'); ?>>Textarea</option>
                                </select>
                            </td>

                            <td>
                                <select name="qr_cf_fields[<?php echo $key ?>][<?php echo $i ?>][width]">
                                    <option value="100" <?php selected($field['width'], '100'); ?>>100%</option>
                                    <option value="50" <?php selected($field['width'], '50'); ?>>50%</option>
                                </select>
                            </td>

                            <td>
                                <input type="checkbox"
                                    name="qr_cf_fields[<?php echo $key ?>][<?php echo $i ?>][required]"
                                    value="1" <?php checked($field['required'] ?? 0, 1); ?>>
                            </td>

                            <td><button class="button qr-remove-row">✖</button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <p>
                    <button type="button"
                        class="button button-secondary qr-add-row"
                        data-group="<?php echo esc_attr($key); ?>">
                        ➕ Add Field
                    </button>
                </p>
            <?php endforeach; ?>

            <?php submit_button('Save Fields'); ?>
        </form>
    </div>
<?php }
