<?php
/**
 * Support Chat Bot
 * Plugin Name: U.Group Support
 * Plugin URI: https://u.group
 * Description: Support plugin for U.Group clients
 * version: 1.0.0
 * Author: rayflores
 * Author URI:  https://rayflores.com
 * Text Domain: uchat
 */
namespace Pangolin\WPR;

if ( !defined( 'WPINC' ) ) {
	die;
}

define( 'WP_REACTIVATE_VERSION', '1.0.0' );

/**
 * Autoloader
 *
 * @param string $class The fully-qualified class name.
 * @return void
 *
 *  * @since 1.0.0
 */
spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = __NAMESPACE__;

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/includes/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});

/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {
	$wpr = Plugin::get_instance();
	$wpr_shortcode = Shortcode::get_instance();
	$wpr_admin = Admin::get_instance();
	$wpr_rest_admin = Endpoint\Admin::get_instance();
	$wpr_rest_submission = Endpoint\Submission::get_instance(); // connect our new endpoint
}
add_action( 'plugins_loaded', 'Pangolin\\WPR\\init' );



/**
 * Register the widget
 *
 * @since 1.0.0
 */
function widget_init() {
	return register_widget( new Widget );
}
add_action( 'widgets_init', 'Pangolin\\WPR\\widget_init' );

/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, array( 'Pangolin\\WPR\\Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Pangolin\\WPR\\Plugin', 'deactivate' ) );