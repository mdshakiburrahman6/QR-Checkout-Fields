<?php
if (!defined('ABSPATH')) exit;

add_action('pmpro_checkout_after_username', function () {

    $config = get_option('qr_cf_fields', []);
    ?>

    <fieldset>
        <legend>I am</legend>
        <label><input type="radio" name="qr_identity" value="driver" required> Driver</label><br>
        <label><input type="radio" name="qr_identity" value="owner"> Owner</label><br>
        <label><input type="radio" name="qr_identity" value="driver_owner"> Driver & Owner</label>
    </fieldset>

    <div id="qr-dynamic-fields"></div>

    <script>
        window.QR_CF_FIELDS = <?php echo json_encode($config); ?>;
    </script>
    <?php
});
