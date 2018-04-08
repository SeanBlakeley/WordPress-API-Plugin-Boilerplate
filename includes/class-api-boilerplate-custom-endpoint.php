<?php

/**
 * The Custom Endpoint
 *
 * Create the custom endpoint and add the data for API Boilerplate.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

/**
 * Define the custom endpoint content.
 *
 * Add the route for the API Boilerplate Custom Endpoint and generate
 * the necessary data for the frontend.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 */
class api_boilerplate_Custom_Endpoint {

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
	 * @since  	0.1
	 * @access 	private
	 * @var  		string 		$option_name 	Option name prefix for API Boilerplate
	 */
	private $option_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param 	 string 	$plugin_name 		  The name of this plugin.
	 * @param    string    	$version    		  The version of this plugin.
	 * @param    string    	$option_name   		  The option prefix for this plugin.
	 */
	public function __construct( $plugin_name, $version, $option_name ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->option_name        = $option_name;

	}

	/**
	 * Admin nag message is WP API not enabled.
	 *
	 * @since    0.1.0
	 */
	public function api_boilerplate_nag_message() {

		global $wp_version;

		// WP v4.7 was the first WP version with the API fully baked in :)
		if ( $wp_version >= 4.7 ) {

			return;

		} elseif ( is_plugin_active( 'WP-API-develop/plugin.php' ) || is_plugin_active( 'rest-api/plugin.php' )  || is_plugin_active( 'WP-API/plugin.php' ) ) {

				return;

		} else { ?>

			<div class="update-nag notice">

				<p>
					<?php __( 'To use <strong>API Boilerplate</strong>, you need to update to the latest version of WordPress (version 4.7 or above). To use an older version of WordPress, you can install the <a href="https://wordpress.org/plugins/rest-api/">WP API Plugin</a> plugin. However, we&apos;d strongly advise youto update WordPress.', 'api-boilerplate' ); ?>
				</p>

			</div>

		<?php
		}

	}

	/**
	 * API Route Constructor.
	 *
	 * @since    0.1.0
	 */
	public function Boilerplate_custom_api_route_constructor() {

		register_rest_route( '/example/v1', '/first-example', array(
			'methods' => 'GET',
			'callback' => array( $this, 'Boilerplate_custom_api_endpoint_first_example' )
		) );

		register_rest_route( '/example/v1', '/second-example', array(
			'methods' => 'GET',
			'callback' => array( $this, 'Boilerplate_custom_api_endpoint_second_example' )
		) );

	}

	/**
	 * API Endpoint first example.
	 *
	 * @since    0.1.0
	 */
	public function Boilerplate_custom_api_endpoint_first_example( WP_REST_Request $params ) {

		$api = array();

		$api['first-example'] = "this is the first example endpoint data";

		return $api;

	}

	/**
	 * API Endpoint second example.
	 *
	 * @since    0.1.0
	 */
	public function Boilerplate_custom_api_endpoint_second_example( WP_REST_Request $params ) {

		$api = array();

		$api['second-example'] = "this is the second example endpoint data";

		return $api;

	}

}
