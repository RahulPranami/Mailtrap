<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Mailtrap
 * @subpackage Mailtrap/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<?php
	if ( 'mailtrap' === $_GET['page'] ) {
		include_once 'mailtrap/index.php';
	} elseif ( 'mailtrap-test' === $_GET['page'] ) {
		include_once 'mailtrap/test.php';
	} elseif ( 'mailtrap-inbox' === $_GET['page'] ) {
		include_once 'mailtrap/inbox.php';
	}
	?>
</div>