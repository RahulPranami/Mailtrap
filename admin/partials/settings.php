<div class="wrap">
    <?php include 'page-header.php'; ?>

    <form method="post" action="options.php">
        <?php settings_fields('mailtrap-settings'); ?>
        <?php do_settings_sections('mailtrap-settings'); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label class="mb-2 uppercase text-gray-700" for="mailtrap_enabled">
                        <?php echo __('Enabled', 'mailtrap-for-wp') ?>
                    </label>
                </th>
                <td>
                    <input type="checkbox" id="mailtrap_enabled" name="mailtrap_enabled" value="1" <?php echo get_option('mailtrap_enabled') === '1' ? 'checked' : '' ?> class="form-checkbox" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label class="mb-2 uppercase text-gray-700" for="mailtrap_username">
                        <?php echo __('Username', 'mailtrap-for-wp') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_username" name="mailtrap_username"
                        value="<?php echo esc_attr(get_option('mailtrap_username')); ?>"
                        class="border-2 border-gray-300 px-4 py-2 rounded-md" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label class="mb-2 uppercase text-gray-700" for="mailtrap_password">
                        <?php echo __('Password', 'mailtrap-for-wp') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_password" name="mailtrap_password"
                        value="<?php echo esc_attr(get_option('mailtrap_password')); ?>"
                        class="border-2 border-gray-300 px-4 py-2 rounded-md" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label class="mb-2 uppercase text-gray-700" for="mailtrap_api_token">
                        <?php echo __('API Token', 'mailtrap-for-wp') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_api_token" name="mailtrap_api_token"
                        value="<?php echo esc_attr(get_option('mailtrap_api_token')); ?>"
                        class="border-2 border-gray-300 px-4 py-2 rounded-md" /><br>
                    <small>
                        <a href="https://mailtrap.io/public-api" target="blank">
                            https://mailtrap.io/public-api
                        </a>
                    </small>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label class="mb-2 uppercase text-gray-700" for="mailtrap_inbox_id">
                        <?php echo __('Inbox ID', 'mailtrap-for-wp') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_inbox_id" name="mailtrap_inbox_id"
                        value="<?php echo esc_attr(get_option('mailtrap_inbox_id')); ?>"
                        class="border-2 border-gray-300 px-4 py-2 rounded-md" />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>

    </form>
</div>
