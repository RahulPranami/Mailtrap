<div class="min-h-screen-wp flex justify-center items-center">

    <form id="mailtrap-form" method="post" action="options.php">
        <h3>
            <?php echo esc_html(get_admin_page_title()); ?>
        </h3>

        <?php settings_errors(); ?>

        <?php settings_fields('mailtrap-settings'); ?>
        <?php do_settings_sections('mailtrap-settings'); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="mailtrap_enabled">
                        <?php echo __('Enabled', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="checkbox" id="mailtrap_enabled" name="mailtrap_enabled" value="1" <?php echo get_option('mailtrap_enabled') === '1' ? 'checked' : '' ?> />
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="mailtrap_username">
                        <?php echo __('Username', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_username" name="mailtrap_username"
                        value="<?php echo esc_attr(get_option('mailtrap_username')); ?>"
                        class="focus:outline-none focus:shadow-outline" />
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="mailtrap_password">
                        <?php echo __('Password', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_password" name="mailtrap_password"
                        value="<?php echo esc_attr(get_option('mailtrap_password')); ?>"
                        class="focus:outline-none focus:shadow-outline" />
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="mailtrap_api_token">
                        <?php echo __('API Token', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_api_token" name="mailtrap_api_token"
                        value="<?php echo esc_attr(get_option('mailtrap_api_token')); ?>"
                        class="focus:outline-none focus:shadow-outline" />
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="mailtrap_inbox_id">
                        <?php echo __('Inbox ID', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="text" id="mailtrap_inbox_id" name="mailtrap_inbox_id"
                        value="<?php echo esc_attr(get_option('mailtrap_inbox_id')); ?>"
                        class="focus:outline-none focus:shadow-outline" />
                </td>
            </tr>
        </table>

        <div class="flex justify-center py-4">
            <button type="submit" id="submit_btn">Save</button>
        </div>

    </form>
</div>