<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Gannwp
 * @subpackage Gannwp/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Gannwp
 * @subpackage Gannwp/includes
 * @author     Your Name <email@example.com>
 */
class Gannwp_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Gannwp_Deactivator::dropGannwp_users_fields_visibility();
		Gannwp_Deactivator::dropGannwpUser();
		Gannwp_Deactivator::dropGannwp_users_meta();
		Gannwp_Deactivator::dropGannwp_users_roles();
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function dropGannwpUser() {

		global $wpdb;

		$table_name = $wpdb->prefix . "gannwp_users";
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function dropGannwp_users_meta() {

		global $wpdb;

		$table_name = $wpdb->prefix . "gannwp_users_meta";
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function dropGannwp_users_roles() {

		global $wpdb;

		$table_name = $wpdb->prefix . "gannwp_users_roles";
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
	}

		/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function dropGannwp_users_fields_visibility() {

		global $wpdb;

		$table_name = $wpdb->prefix . "gannwp_users_fields_visibility";
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
	}

}
