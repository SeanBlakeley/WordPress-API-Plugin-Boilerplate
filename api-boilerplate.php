<?php

/**
 * API Boilerplate Plugin
 *
 * @package    api_boilerplate
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 * Plugin Name:       WordPress API Plugin Boilerplate
 * Description:       Provides a boilerplate starting point for creating custom WP API endpoints
 * Version:           0.1.0
 * Author:            Sean Blakeley <sean@seanblakeley.co.uk>
 * Author URI:        http://www.seanblakeley.co.uk
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Runs during API Boilerplate activation.
 * This action is documented in includes/class-api-boilerplate-activator.php
 */
function activate_api_boilerplate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-boilerplate-activator.php';
	api_boilerplate_Activator::activate();
}

/**
 * Runs during API Boilerplate deactivation.
 * This action is documented in includes/class-api-boilerplate-deactivator.php
 */
function deactivate_api_boilerplate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-boilerplate-deactivator.php';
	api_boilerplate_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_api_boilerplate' );
register_deactivation_hook( __FILE__, 'deactivate_api_boilerplate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-api-boilerplate.php';

/**
 * Initialize API Boilerplate.
 *
 * @since    0.1.0
 */
function run_api_boilerplate() {

	$plugin = new api_boilerplate();
	$plugin->run();

}
run_api_boilerplate();
