<?php

/**
 * Admin facing Elements of API Boilerplate
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/admin
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

/**
 * The admin-facing functionality of API Boilerplate.
 *
 * Add the Options Page to select sections and enqueues
 * the stylesheets and JavaScripts.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/admin
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */
class api_boilerplate_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name prefix for API Boilerplate
	 *
	 * @since  	0.1.2
	 * @access 	private
	 * @var  		string 		$option_name 		Option name prefix for API Boilerplate
	 */
	private $option_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param 	 string 	$plugin_name 				The name of this plugin.
	 * @param    string    	$version    				The version of this plugin.
	 * @param    string    	$option_name   				The option prefix for this plugin.
	 *
	 */
	public function __construct( $plugin_name, $version, $option_name ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->option_name        = $option_name;

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  0.1
	 */
	public function add_options_page() {

		$this->plugin_options_page = add_options_page(
			__( 'API Boilerplate Example Settings Page', 'api-boilerplate' ),
			__( 'API Boilerplate', 'api-boilerplate' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for API Boilerplate
	 *
	 * @since  0.1
	 */
	public function display_options_page() {

		include_once 'partials/api-boilerplate-admin-display.php';

	}

	/**
	 * Register the admin page settings
	 *
	 * @since  0.1.2
	 */
	public function register_settings() {

		add_settings_section(
			$this->option_name . 'example',
			__( 'Example Section', 'api-boilerplate' ),
			'',
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . 'key',
			__( 'Example Field', 'api-boilerplate' ),
			array( $this, $this->option_name . 'example_output' ),
			$this->plugin_name,
			$this->option_name . 'example',
			array( 'label_for' => $this->option_name . 'key' )
		);

		register_setting( $this->plugin_name, $this->option_name . 'key', $this->option_name . 'validate_sections' );
	}

	/**
	 * Render the API Example input
	 *
	 * @since  0.1.2
	 */
	public function Boilerplate_example_output() {
		$name = $this->option_name . 'key';
		$key = get_option( $name ); ?>

		<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_html( $key ); ?>">

		<?php
	}

	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $option
	 * @param  $_POST value
	 * @since  0.1.2
	 * @return string           Sanitized value
	 */
	public function Boilerplate_validate_sections( $option, $value ) {

		return esc_html( $value );

	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		$screen = get_current_screen();

		// Only enqueue our files to the options page
		if ( 'settings_page_api-boilerplate' === $screen->base ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/css/api-boilerplate-admin.min.css', array(), $this->version, 'all' );

		}

	}

}
