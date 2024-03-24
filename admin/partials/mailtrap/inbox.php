<div id="mailtrap-inbox" class="min-h-screen-wp">
	<?php $inbox = Mailtrap_API::getInbox(); ?>

	<h3>
		<?php echo esc_html( get_admin_page_title() ); ?>

		<?php if ( isset( $inbox->name ) ) : ?>
			-
			<?php echo $inbox->name; ?>
		<?php endif; ?>

		<?php if ( array_key_exists( 'message_id', $_GET ) && ! empty( $_GET['message_id'] ) ) : ?>
			<span class="float-right">
				<a href="<?php echo admin_url( 'admin.php?page=mailtrap-inbox' ); ?>" class="">
					<img class="rounded-lg hover:bg-gray-500"
						src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAABpUlEQVR4nO2WvU5CQRCFv14pMf6AMYLCwyixJbwBAhaK72FJ1MYKQYONP7WWUEkBxqcQbESI5ibnJhvivXe5oKHwJFOwnJmzOzs7c+Efc4h1oAg8AF3gXdbVWgGIz1JwDagAQ+ArwEZADdiYVnQP6CvoB1AFskAKWJCltHYpjsPtAZmwogc6gRPoCti08EkA18bpS2FOOlJ6D0Ns+kj+o0lOHjPSG0bURdlI+6qNw7mR3mnRUKxTmyczVJF43ekS0AKeLISTijVUJj1R1A6rPqJtcZrYoSb+vh/pXqRsgGhbv22Qk8+tH+lVpK2x9SjwrP86wDL2SMnP6XCe6IkUGVtvWXQt18bvPmJU968KP4YRfhFpOyDVK9gjbfjNX3EVRHIa/qyeU138vB8pbjSQhI9484e79GogA+AzqIE4ONMOnSkzLW4Uq2I7+N3qdqZMWBwrxtskxZgxxlo5pKjrvzupc8n4EGjovoKQNNI7Uu8PhYyR9oEafk5vc1GW1lpdHDe9O0yJKHCiyrT52LuYsMEEIqbRdqcu1Jd11BzyNk/mH/w1vgGuqrP60R8g2QAAAABJRU5ErkJggg==">
				</a>
			</span>
		<?php endif; ?>
	</h3>

	<?php if ( $inbox ) : ?>
		<div class="bg-gray-100 p-4 shadow-md rounded-md flex justify-between">
			<p class="text-sm text-gray-600">Total Sent - <span class="font-medium text-gray-800">
					<?php echo $inbox->sent_messages_count; ?>
				</span></p>
			<p class="text-sm text-gray-600">Messages - <span class="font-medium text-gray-800">
					<?php echo $inbox->emails_unread_count; ?>/
					<?php echo $inbox->emails_count; ?>
				</span></p>
			<p class="text-sm text-gray-600">Max Size - <span class="font-medium text-gray-800">
					<?php echo $inbox->max_size; ?>
				</span></p>
		</div>
	<?php endif; ?>


	<div class="py-2.5 w-screen-wp flex items-stretch">

		<?php try { ?>
			<?php
			$current_message = null;
			$messages        = Mailtrap_API::getInboxMessages();

			if ( array_key_exists( 'message_id', $_GET ) && ! empty( $_GET['message_id'] ) ) {
				$current_message = Mailtrap_API::getMessage( $_GET['message_id'] );
			}

			if ( is_array( $messages ) ) :
				?>

				<ul class="pr-2.5 border-r border-gray-500 w-1/3 grid gap-2">
					<?php foreach ( $messages as $message ) : ?>
						<?php $active = $current_message && $message->id == $current_message->id ? 'active' : ''; ?>
						<?php $read = $message->is_read ? 'read' : ''; ?>

						<a href="<?php echo admin_url( 'admin.php?page=mailtrap-inbox&message_id=' . $message->id ); ?>">
							<li class="px-4 py-2 m-0 text-base no-underline <?php echo $active; ?> <?php echo $read; ?>">
								<?php echo $message->subject; ?>

								<p class="mt-2 text-xs flex justify-between">
									<span>To:
										<?php echo $message->to_email; ?>
									</span>
									<span style="flex-shrink: 0;">
										<?php echo Mailtrap_API::time2str( $message->sent_at ); ?>
									</span>
								</p>
							</li>
						</a>
					<?php endforeach; ?>
				</ul>

			<?php else : ?>
				<p style="text-align:center">No messages found</p>
			<?php endif; ?>

			<?php if ( null !== $current_message ) : ?>
				<div class="w-2/3 border border-l-0 border-gray-500 rounded-lg rounded-tl-none rounded-bl-none">
					<div class="rounded-tr-md border-b border-gray-500 bg-gray-300 p-2.5">
						<h2 class="text-lg mb-2.5">
							<?php echo $current_message->subject; ?>

							<small class="float-right flex items-center text-sm">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
									stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
									class="mr-2.5">
									<rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
									<line x1="16" x2="16" y1="2" y2="6"></line>
									<line x1="8" x2="8" y1="2" y2="6"></line>
									<line x1="3" x2="21" y1="10" y2="10"></line>
								</svg>
								<?php echo date( 'Y-m-d H:i', strtotime( $current_message->sent_at ) ); ?>
							</small>
						</h2>
						<p>
							From:
							<?php echo $current_message->from_name; ?> &lt;
							<?php echo $current_message->from_email; ?>&gt; <br>
							To:
							<?php echo $current_message->to_name; ?> &lt;
							<?php echo $current_message->to_email; ?>&gt;
						</p>
					</div>

					<div class="m-2.5">
						<?php echo Mailtrap_API::getMessageBody( $_GET['message_id'] ); ?>
					</div>
				</div>
			<?php endif; ?>

		<?php } catch ( Exception $e ) { ?>
			<div class="notice notice-error is-dismissible">
				<p>Mailtrap API Error:
					<?php echo $e->getMessage(); ?>
				</p>
			</div>
		<?php } ?>
	</div>
</div>