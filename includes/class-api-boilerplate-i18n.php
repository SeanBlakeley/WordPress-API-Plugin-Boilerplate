<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for API Boilerplate.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/includes
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 */
class api_boilerplate_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'api-boilerplate',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
