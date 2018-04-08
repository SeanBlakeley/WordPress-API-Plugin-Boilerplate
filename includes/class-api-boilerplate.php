<?php

/**
 * API Boilerplate Core Class
 *
 * A class definition that includes hooks & functions used by the
 * admin area, public-facing area and custom endpoint.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

/**
 * API Boilerplate core class.
 *
 * This is used to define internationalization, admin-specific hooks,
 * public-facing hooks & custom endpoint.
 *
 * Also maintains the unique identifier for API Boilerplate as well as the current
 * version of the plugin & the default sections order.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 */
class api_boilerplate {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      api_boilerplate_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of API Boilerplate.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The Option Prefix for API Boilerplate.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $option_name    The option prefix for API Boilerplate.
	 */
	protected $option_name;

	/**
	 * Define the core functionality of API Boilerplate.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->plugin_name        = 'api-boilerplate';
		$this->version            = '0.1.0';
		$this->option_name        = 'Boilerplate_';

		$this->load_dependencies();
		$this->set_locale();
		$this->create_endpoint();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for API Boilerplate.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - api_boilerplate_Loader. Orchestrates the hooks of the plugin.
	 * - api_boilerplate_i18n. Defines internationalization functionality.
	 * - api_boilerplate_Custom_Endpoint. Defines the custom endpoint & content.
	 * - api_boilerplate_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-boilerplate-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-boilerplate-i18n.php';

		/**
		 * The class responsible for creating the custom endpoint for API Boilerplate.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-api-boilerplate-custom-endpoint.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-api-boilerplate-admin.php';

		$this->loader = new api_boilerplate_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the api_boilerplate_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new api_boilerplate_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define the Custom Endpoint for API Boilerplate.
	 *
	 * Create the Route, Custom Endpoint & data for API Boilerplate.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function create_endpoint() {

		$plugin_endpoint = new api_boilerplate_Custom_Endpoint( $this->get_plugin_name(), $this->get_version(), $this->get_option_name() );

		// Add Admin Notice if Below WordPress version 4.7 & WordPress API plugin is not installed
		$this->loader->add_action( 'admin_notices', $plugin_endpoint, 'api_boilerplate_nag_message' );

		// Construct Custom Endpoint
		$this->loader->add_action( 'rest_api_init', $plugin_endpoint, 'Boilerplate_custom_api_route_constructor' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new api_boilerplate_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_option_name() );

		// Add API Boilerplate Options Page (under Settings Menu)
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );

		// Register API Boilerplate Settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

		// Enqueue Styles & Scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {

		$this->loader->run();

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;

	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1
	 * @return    api_boilerplate_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	}

	/**
	 * Retrieve the version number of API Boilerplate.
	 *
	 * @since     0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;

	}

	/**
	 * Retrieve the option prefix for API Boilerplate.
	 *
	 * @since     0.1
	 * @return    string    The option name prefix of the plugin.
	 */
	public function get_option_name() {

		return $this->option_name;

	}

}
