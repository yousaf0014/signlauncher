<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://logicso.tech
 * @since      1.0.0
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 * @author     Logicso.tech <talha@logicso.tech>
 */
class Wp_Autosubmitter_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		global $wpdb;
     	$table_name = $wpdb->prefix . "sbwaccounts"; 
     	$sql = "DROP TABLE IF EXISTS $table_name;";
     	$wpdb->query($sql);

     	$table_name2 = $wpdb->prefix . "sbwposts"; 
     	$sql2 = "DROP TABLE IF EXISTS $table_name2;";
     	$wpdb->query($sql2);
     	delete_option("wp_autosubmitter_db_version");

	}

}
