<div class="wrap">
    <?php include 'page-header.php'; ?>

    <div style="padding: 20px 5px">
        <?php try { ?>
            <?php if (get_option('mailtrap_inbox_id')): ?>

                <?php
                $current_message = null;
                $message_body = '<p style="text-align:center">No messages found</p>';
                $messages = Mailtrap_API::getInboxMessages(get_option('mailtrap_inbox_id'));

                if (array_key_exists('message_id', $_GET) && !empty ($_GET['message_id'])) {
                    $current_message = Mailtrap_API::getMessage(get_option('mailtrap_inbox_id'), $_GET['message_id']);
                    $message_body = Mailtrap_API::getMessageBody(get_option('mailtrap_inbox_id'), $_GET['message_id']);
                } else {
                    if (count($messages) > 0) {
                        $current_message = $messages[0];
                        $message_body = Mailtrap_API::getMessageBody(get_option('mailtrap_inbox_id'), $current_message->id);
                    }
                }

                ?>

                <h3 style="background: #fff; margin-bottom:0; padding: 20px;border:1px solid #eee">Inbox View </h3>

                <div style="display: flex;align-items: stretch;">
                    <?php if (count($messages) > 0): ?>
                        <ul style="flex-basis: 30%;background: #fff; margin:0; flex-shrink: 0;">
                            <?php foreach ($messages as $message): ?>
                                <?php $is_current_item = $current_message && $message->id == $current_message->id; ?>
                                <li
                                    style="<?php echo $is_current_item ? 'background: #00b08c;' : ($message->is_read ? 'background: #eee;' : '') ?>display:flex; flex-direction: column; padding: 15px 10px 5px 20px; border-bottom: 1px solid #eee;margin:0;">
                                    <a style="<?php echo $is_current_item ? 'color: #fff;' : 'color: #292929;' ?><?php echo !$message->is_read ? 'font-weight: bold' : '' ?>;font-size:0.9rem;margin-bottom:1px;text-decoration:none"
                                        href="<?php echo admin_url('admin.php?page=mailtrap-inbox&inbox_id=' . $message->inbox_id . '&message_id=' . $message->id); ?>">
                                        <?php echo $message->subject ?>
                                    </a>
                                    <p
                                        style="margin:2px 0;display:flex;justify-content: space-between;<?php echo $is_current_item ? 'color: #fff;' : '' ?>">
                                        <span style="font-size:0.6rem">To:
                                            <?php echo $message->to_email ?>
                                        </span>
                                        <span style="font-size:0.6rem;flex-shrink: 0;">
                                            <?php echo Mailtrap_API::time2str($message->sent_at) ?>
                                        </span>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div style="flex:1 1 auto;background: #fff; border-left: 1px solid #eee; padding: 10px 20px 20px 20px;">

                        <?php if ($current_message): ?>
                            <div style="border-bottom:1px solid #ccc;margin-bottom:25px">
                                <h2 style="font-size:1.5rem">
                                    <?php echo $current_message->subject ?> <small style="font-size: 0.7rem; float: right">
                                        <?php echo date('Y-m-d H:i', strtotime($current_message->sent_at)) ?>
                                    </small>
                                </h2>
                                <p>
                                    From:
                                    <?php echo $current_message->from_name ?> &lt;
                                    <?php echo $current_message->from_email ?>&gt; <br>
                                    To:
                                    <?php echo $current_message->to_name ?> &lt;
                                    <?php echo $current_message->to_email ?>&gt;
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php echo $message_body ?>
                    </div>
                </div>

            <?php endif; ?>
        <?php } catch (Exception $e) { ?>
            <div class="notice notice-error is-dismissible">
                <p>Mailtrap API Error:
                    <?php echo $e->getMessage() ?>
                </p>
            </div>
        <?php } ?>
    </div>

</div>
