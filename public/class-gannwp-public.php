<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Gannwp
 * @subpackage Gannwp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gannwp
 * @subpackage Gannwp/public
 * @author     Your Name <email@example.com>
 */
class Gannwp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $gannwp    The ID of this plugin.
	 */
	private $gannwp;

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
	 * @param      string    $gannwp       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $gannwp, $version ) {

		$this->gannwp = $gannwp;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gannwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gannwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->gannwp, plugin_dir_url( __FILE__ ) . 'css/gannwp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gannwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gannwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->gannwp, plugin_dir_url( __FILE__ ) . 'js/gannwp-public.js', array( 'jquery' ), $this->version, false );

	}

}
