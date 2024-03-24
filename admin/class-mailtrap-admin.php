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
	public function enqueue_styles( $hook ) {

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

		if ('mailtrap_page_mailtrap-inbox' === $hook || 'toplevel_page_mailtrap' === $hook || 'mailtrap_page_mailtrap-test' === $hook) {
			// wp_enqueue_style( 'tailwindcss', plugin_dir_url( __FILE__ ) . 'css/output.css', array(), microtime(), 'all' );
			wp_enqueue_style( 'tailwindcss-min', plugin_dir_url( __FILE__ ) . 'css/output.min.css' );
		}

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

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function mailtrap_menu() {
		add_menu_page('Mailtrap Settings', 'Mailtrap', 'manage_options', 'mailtrap', [$this, 'mailtrap_page']);
		add_submenu_page('mailtrap', 'Mailtrap Test', 'Test', 'manage_options', 'mailtrap-test', [$this, 'mailtrap_page']);
		add_submenu_page('mailtrap', 'Mailtrap Inbox', 'Inbox', 'manage_options', 'mailtrap-inbox', [$this, 'mailtrap_page']);
	}

	public function register_settings() {
		register_setting('mailtrap-settings', 'mailtrap_enabled');
		register_setting('mailtrap-settings', 'mailtrap_username');
		register_setting('mailtrap-settings', 'mailtrap_password');

		register_setting('mailtrap-settings', 'mailtrap_api_token');
		register_setting('mailtrap-settings', 'mailtrap_inbox_id');
	}

	public function mailtrap_page() {
		include plugin_dir_path( __FILE__ ) . '/partials/mailtrap-admin-display.php';
	}

	public function mailtrap($phpmailer) {
		if (get_option('mailtrap_enabled', false)) {
			$phpmailer->IsSMTP();
			$phpmailer->Host = 'smtp.mailtrap.io';
			// $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
			$phpmailer->SMTPAuth = true;
			$phpmailer->Port = 2525;
			$phpmailer->Username = get_option('mailtrap_username');
			$phpmailer->Password = get_option('mailtrap_password');
			// $phpmailer->SMTPSecure = get_option('mailtrap_secure');
		}
	}

	public function wp_mail_failed($wp_error) {
		echo sprintf(
			'<div class="notice notice-error"><p>%s</p></div>',
			__('Email Delivery Failure:') . $wp_error->get_error_message()
		);
	}

	public function filter_mail_from($value) {
		return get_option('admin_email');
	}

	public function filter_mail_from_name($value) {
		return get_option('blogname');
	}
}
