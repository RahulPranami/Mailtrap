<div class="min-h-screen-wp flex justify-center items-center">

    <form id="mailtrap-form" method="post" action="<?php echo admin_url('admin.php?page=mailtrap-test'); ?>">

        <h3>
            <?php echo esc_html(get_admin_page_title()); ?>
        </h3>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'):
            if (!wp_verify_nonce($_POST['_wpnonce'], 'mailtrap_test_action')) {
                die ('Failed security check');
            }

            $email_sent = wp_mail($_POST['to'], __('Mailtrap for Wordpress Plugin', 'mailtrap'), $_POST['message']);

            // var_dump($email_sent);
            if ($email_sent === true): ?>
                <div class="notice notice-success is-dismissible">
                    <p>
                        <?php echo __('Your email has been sent successfully', 'mailtrap') ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="notice notice-error is-dismissible">
                    <p>
                        <?php echo __('Oops Something went wrong. Your email did not sent successfully', 'mailtrap') ?>
                    </p>
                </div>
            <?php endif;
        endif; ?>

        <?php wp_nonce_field('mailtrap_test_action'); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="to">
                        <?php echo __('To', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <input type="email" id="to" name="to" value="<?php echo get_option('admin_email') ?>" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="message">
                        <?php echo __('Message', 'mailtrap') ?>
                    </label>
                </th>
                <td>
                    <textarea id="message" name="message"
                        rows="5"><?php echo __('This is a Mailtrap for Wordpress Plugin test email.', 'mailtrap') ?></textarea>
                </td>
            </tr>
        </table>

        <button type="submit" id="submit_btn" class="my-4">
            <?php echo __('Send', 'mailtrap') ?>
        </button>

    </form>
</div>