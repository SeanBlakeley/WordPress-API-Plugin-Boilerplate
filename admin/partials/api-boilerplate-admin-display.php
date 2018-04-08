<?php
/**
 * Template for API Boilerplate settings page
 *
 * @package    api_boilerplate
 * @subpackage api_boilerplate/admin
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !current_user_can( 'manage_options' ) ) {
	return;
}
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
			settings_fields( 'api-boilerplate' );
			do_settings_sections( 'api-boilerplate' );
			submit_button( 'Save Settings' );
		?>
	</form>
</div>
