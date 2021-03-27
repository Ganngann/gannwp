<?php

/**
* Fired during plugin activation
*
* @link       http://example.com
* @since      1.0.0
*
* @package    Gannwp
* @subpackage Gannwp/includes
*/

/**
* Fired during plugin activation.
*
* This class defines all code necessary to run during the plugin's activation.
*
* @since      1.0.0
* @package    Gannwp
* @subpackage Gannwp/includes
* @author     Your Name <email@example.com>
*/
class Gannwp_Activator {
	/**
	* Short Description. (use period)
	*
	* Long Description.
	*
	* @since    1.0.0
	*/
	public static function activate() {

		Gannwp_Activator::create_gannwp_params();
	}



	/**
	* create_gannwp_params. (use period)
	*
	* create and seed gannwp_params table.
	*
	* @since    1.0.0
	*/
	public static function create_gannwp_params() {

		global $wpdb;
		$alreadyexist;
		$table_name = $wpdb->prefix . "gannwp_params";
		$gannwp_db_version = '1.0';
		$charset_collate = $wpdb->get_charset_collate();


		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$alreadyexist = false;
		}else {
			$alreadyexist = true;
		};


		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			lastUpdate timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			valueTXT varchar(255) DEFAULT '' NOT NULL,
			valueINT INT DEFAULT '0' NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
		add_option( 'gannwp_db_version', $gannwp_db_version );

		// seed table if new
		// TODO update db if already exist
		if (!$alreadyexist) {
			$wpdb->insert(
				$table_name,
				array(
					'name' => 'first param',
					'valueTXT' => 'param text value',
					'valueINT' => '1',
				)
			);
		}

	}


}
