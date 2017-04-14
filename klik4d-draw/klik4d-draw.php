<?php
/*
Plugin Name: Klik4D Draw
Plugin URI:  https://github.com/guiwuff/wp-klik4d-draw
Description: A Wordpress plugin to fetch and store Klik4D Draw Results. Displayed via template tags.
Version:     0.1.0-alpha (0.1.0a)
Author:      GUI Wuff <gui.wuff@gmail.com>
Author URI:  https://github.com/guiwuff/
License:     MIT	
License URI: https://github.com/guiwuff/wp-klik4d-draw/blob/master/LICENSE
Text Domain: klik4d_draw
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin version
if( !defined( 'KLIK4D_VER' ) )
	define( 'KLIK4D', '0.1.0a' );
	
// Class file
require_once plugin_dir_path( __FILE__ ) . 'class-klik4d-draw.php';

function activate_klik4d() {
	Klik4d_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_klik4d() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-klik4d-deactivator.php';
	Klik4d_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_klik4d' );
register_deactivation_hook( __FILE__, 'deactivate_klik4d' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-klik4d.php';

function cron_klik4d() {
	// function to fetch data (HTTP API)
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_klik4d() {

	$plugin = new Klik4d();
	$plugin->run();

}
run_klik4d();