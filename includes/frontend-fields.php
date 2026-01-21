<?php
if (!defined('ABSPATH')) exit;

add_action('pmpro_checkout_after_username', function () {

    $config = get_option('qr_cf_fields', []);
    ?>

    <fieldset>
        <legend>I am</legend>
        <label class="qr_role"><input type="radio" name="qr_identity" value="driver" required> Driver</label><br>
        <label class="qr_role"><input type="radio" name="qr_identity" value="owner"> Owner</label><br>
        <label class="qr_role"><input type="radio" name="qr_identity" value="driver_owner"> Driver & Owner</label>
    </fieldset>

        <div id="qr-dynamic-fields"></div>


    <?php if (!empty($config['global'])): ?>
        <div class="qr-global-fields">
            <?php foreach ($config['global'] as $i => $field): ?>

                <?php if ($field['type'] === 'image'): ?>

                    <?php
                    $max_size = isset($field['max_size']) && $field['max_size']
                        ? (int) $field['max_size']
                        : 5;
                    ?>

                    <div class="qr-image-field">
                        <label><?php echo esc_html($field['label']); ?></label>

                        <div class="qr-upload-box"
                            data-max="<?php echo esc_attr($max_size); ?>">

                            <input type="file"
                                name="qr_global_<?php echo $i; ?>"
                                accept="image/*"
                                hidden>

                            <div class="qr-placeholder">
                                Click or drag image
                            </div>

                            <div class="qr-preview" style="display:none">
                                <img src="" alt="">
                                <button type="button" class="qr-remove"><i class="fa-regular fa-circle-xmark"></i></button>
                            </div>
                        </div>

                        <small>
                            Maximum Image Size: <?php echo esc_html($max_size); ?>MB
                        </small>
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>



    <script>
        window.QR_CF_FIELDS = <?php echo json_encode($config); ?>;
    </script>
    <?php
});

add_action('pmpro_checkout_validation', function ($errors) {

    if (empty($_POST['qr_identity'])) {
        $errors[] = 'Please select Driver / Owner / Driver & Owner.';
    }

    return $errors;
});
