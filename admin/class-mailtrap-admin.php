<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Mailtrap
 * @subpackage Mailtrap/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mailtrap
 * @subpackage Mailtrap/admin
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Mailtrap_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mailtrap_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mailtrap_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mailtrap-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mailtrap_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mailtrap_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mailtrap-admin.js', array( 'jquery' ), $this->version, false );

		// print_r($hook);
		if ('admin_page_mailtrap-inbox' == $hook || 'settings_page_mailtrap-settings' == $hook) {
			wp_enqueue_script( 'tailwindcss', plugin_dir_url( __FILE__ ) . 'js/tailwindcss.min.js', array(), $this->version, false );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function mailtrap_menu() {
		add_options_page( 'Mailtrap for Wordpress', 'Mailtrap', 'manage_options', 'mailtrap-settings', array($this, 'settings_page' ) );
		add_submenu_page( '', 'Mailtrap for Wordpress', 'Mailtrap Test', 'manage_options', 'mailtrap-test', array($this, 'test_page' ));
		add_submenu_page( '', 'Mailtrap for Wordpress', 'Mailtrap Inbox', 'manage_options', 'mailtrap-inbox', array($this, 'inbox_page' ));
	}

	public function register_settings() {
		register_setting('mailtrap-settings', 'mailtrap_enabled');
		register_setting('mailtrap-settings', 'mailtrap_username');
		register_setting('mailtrap-settings', 'mailtrap_password');

		register_setting('mailtrap-settings', 'mailtrap_api_token');
		register_setting('mailtrap-settings', 'mailtrap_inbox_id');
	}

	public function settings_page() {
		include plugin_dir_path( __FILE__ ) . '/partials/settings.php';
	}

	public function test_page() {
		$email_sent = null;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!wp_verify_nonce($_POST['_wpnonce'], 'mailtrap_test_action')) {
				die ('Failed security check');
			}

			$email_sent = wp_mail($_POST['to'], __('Mailtrap for Wordpress Plugin', 'mailtrap-for-wp'), $_POST['message']);
		}

		include plugin_dir_path( __FILE__ ) . '/partials/test.php';
	}

	public function inbox_page() {
		include plugin_dir_path( __FILE__ ) . '/partials/inbox.php';
	}

	public function mailtrap($phpmailer) {
		if (get_option('mailtrap_enabled', false)) {
			$phpmailer->IsSMTP();
			$phpmailer->Host = 'smtp.mailtrap.io';
			// $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
			$phpmailer->SMTPAuth = true;
			$phpmailer->Port = 2525;
			// $phpmailer->Port = get_option('mailtrap_port');
			$phpmailer->Username = get_option('mailtrap_username');
			$phpmailer->Password = get_option('mailtrap_password');
			// $phpmailer->SMTPSecure = get_option('mailtrap_secure');
		}
	}
}
