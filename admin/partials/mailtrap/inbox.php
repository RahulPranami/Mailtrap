<div class="my-2 flex border border-gray-500 rounded-lg">
    <?php try {
        if (get_option('mailtrap_inbox_id')):
            $current_message = null;
            $message_body = '<p>No messages found</p>';
            $messages = Mailtrap_API::getInboxMessages();

            if (array_key_exists('message_id', $_GET) && !empty ($_GET['message_id'])) {
                $current_message = Mailtrap_API::getMessage($_GET['message_id']);
                $message_body = Mailtrap_API::getMessageBody($_GET['message_id']);
            } else {
                if (count($messages) > 0) {
                    $current_message = $messages[0];
                    $message_body = Mailtrap_API::getMessageBody($current_message->id);
                }
            }

            ?>
            <div class="flex flex-col border-r border-gray-500">
                <div dir="ltr" class="relative flex-1">
                    <div class="h-full w-full rounded-[inherit]">
                        <div>
                            <?php if (count($messages) > 0): ?>
                                <ul class="p-2 grid gap-2">
                                    <?php foreach ($messages as $message): ?>
                                        <?php $is_current_item = $current_message && $message->id == $current_message->id; ?>

                                        <li
                                            class="rounded-lg border border-gray-500 bg-gray-300 p-4 transition-colors cursor-pointer hover:bg-gray-400">
                                            <div class="flex items-center space-x-4 text-base">
                                                <a
                                                    href="<?php echo admin_url("admin.php?page=mailtrap-inbox&message_id={$message->id}"); ?>">
                                                    <?php echo $message->subject ?>
                                                </a>
                                            </div>
                                            <div class="flex justify-between items-center space-x-2">
                                                <span>To:
                                                    <?php echo $message->to_email ?>
                                                </span>
                                                <span class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="w-5 h-5">
                                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                                        <line x1="16" x2="16" y1="2" y2="6"></line>
                                                        <line x1="8" x2="8" y1="2" y2="6"></line>
                                                        <line x1="3" x2="21" y1="10" y2="10"></line>
                                                    </svg>
                                                    <span class="text-sm text-gray-500">
                                                        <?php echo Mailtrap_API::time2str($message->sent_at) ?>
                                                    </span>
                                                </span>
                                            </div>
                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($current_message): ?>
                <div class="flex-1 flex flex-col">
                    <div class="p-4 border-b border-gray-500 flex justify-between items-center bg-gray-300">
                        <h2 class="text-lg w-96">
                            <?php echo $current_message->subject ?>
                        </h2>

                        <span class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-5 h-5">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo date('Y-m-d H:i', strtotime($current_message->sent_at)) ?>
                            </span>
                        </span>
                    </div>
                    <div class="flex-1 p-4 grid gap-4 text-sm">
                        <p>
                            From:
                            <?php echo $current_message->from_name ?> &lt;
                            <?php echo $current_message->from_email ?>&gt; <br>
                            To:
                            <?php echo $current_message->to_name ?> &lt;
                            <?php echo $current_message->to_email ?>&gt;
                        </p>

                        <?php echo $message_body ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
        endif;
    } catch (Exception $e) { ?>
        <div class="notice notice-error is-dismissible">
            <p>Mailtrap API Error:
                <?php echo $e->getMessage() ?>
            </p>
        </div>
    <?php } ?>
</div>