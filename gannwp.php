<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://gann.be
 * @since             1.0.0
 * @package           Gannwp
 *
 * @wordpress-plugin
 * Plugin Name:       GannWP Agora
 * Plugin URI:        http://gann.be/gannwp/
 * Description:       Agora organigrame
 * Version:           1.0.0
 * Author:            Morgan Schaefer
 * Author URI:        http://morganschaefer.be/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gannwp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GANNWP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gannwp-activator.php
 */
function activate_gannwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gannwp-activator.php';
	Gannwp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gannwp-deactivator.php
 */
function deactivate_gannwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gannwp-deactivator.php';
	Gannwp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gannwp' );
register_deactivation_hook( __FILE__, 'deactivate_gannwp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gannwp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gannwp() {

	$plugin = new Gannwp();
	$plugin->run();

}
run_gannwp();

if(!function_exists('wp_dump')) :
    function wp_dump(){
        if(func_num_args() === 1)
        {
            $a = func_get_args();
            echo '<pre>', var_dump( $a[0] ), '</pre><hr>';
        }
        else if(func_num_args() > 1)
            echo '<pre>', var_dump( func_get_args() ), '</pre><hr>';
        else
            throw Exception('You must provide at least one argument to this function.');
    }
endif;
