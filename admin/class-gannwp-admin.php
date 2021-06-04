<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       http://example.com
* @since      1.0.0
*
* @package    Gannwp
* @subpackage Gannwp/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Gannwp
* @subpackage Gannwp/admin
* @author     Your Name <email@example.com>
*/
class Gannwp_Admin {

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
	* @param      string    $gannwp       The name of this plugin.
	* @param      string    $version    The version of this plugin.
	*/
	public function __construct( $gannwp, $version ) {

		$this->gannwp = $gannwp;
		$this->version = $version;

	}

	/**
	* Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->gannwp, plugin_dir_url( __FILE__ ) . 'css/gannwp-admin.css', array(), $this->version, 'all' );

	}

	/**
	* Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->gannwp, plugin_dir_url( __FILE__ ) . 'js/gannwp-admin.js', array( 'jquery' ), $this->version, false );

	}



	// Add a new top level menu link to the ACP
	function gann_add_admin_links()
	{
		wp_enqueue_script('jquery-ui-sortable');

		add_menu_page(
			'My First Page', // Title of the page
			"GannWP Agora", // Text to show on the menu link
			'manage_options', // Capability requirement to see the link
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php' // The 'slug' - file to display when clicking the link
		);
		add_submenu_page(
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php',
			'Liste des utilisateurs',
			'Liste des utilisateurs',
			'manage_options',
			plugin_dir_path(__FILE__) . '/partials/gann_userList.php'
		);
		add_submenu_page(
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php',
			'Champs de profil personalisés',
			'Champs de profil personalisés',
			'manage_options',
			plugin_dir_path(__FILE__) . '/partials/gann_customfields.php'
		);
		add_submenu_page(
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php',
			'test',
			'test',
			'manage_options',
			plugin_dir_path(__FILE__) . '/partials/gann_test.php'
		);
		add_submenu_page(
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php',
			'Ajouter un utilisateur',
			'Ajouter un utilisateur',
			'manage_options',
			plugin_dir_path(__FILE__) . '/partials/gann_userForm.php'
		);
		add_submenu_page(
			plugin_dir_path(__FILE__) . '/partials/gann_menu.php',
			'Roles utilisateurs',
			'Roles utilisateurs',
			'manage_options',
			plugin_dir_path(__FILE__) . '/partials/gann_customroles.php'
		);
	}
}
