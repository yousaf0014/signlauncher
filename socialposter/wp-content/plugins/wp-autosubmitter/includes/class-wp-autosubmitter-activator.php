<?php

/**
 * Fired during plugin activation
 *
 * @link       http://logicso.tech
 * @since      1.0.0
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 * @author     Logicso.tech <talha@logicso.tech>
 */
class Wp_Autosubmitter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		$table_name = $wpdb->prefix . "sbwaccounts";
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  `app_id` VARCHAR(255) NOT NULL,
		  `app_secret` VARCHAR(255) NULL,
		  `access_token` VARCHAR(255) NULL,
		  `access_token_secret` VARCHAR(255) NULL,
		  `account_type` ENUM('Facebook', 'Twitter', 'Google +', 'Linkedin', 'Instagram', 'Pintrest') NULL,
		  `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY  (id)
		) $charset_collate;";


		$table_name2 = $wpdb->prefix . "sbwposts";

		$sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  `post_title` VARCHAR(255) NOT NULL,
		  `post_link` VARCHAR(255) NULL,
		  `post_description` VARCHAR(255) NULL,
		  `post_image` VARCHAR(255) NULL,
		  `facebook` tinyint(1) DEFAULT 0,
		  `twitter` tinyint(1) DEFAULT 0,
		  `linkedin` tinyint(1) DEFAULT 0,
		  `instagram` tinyint(1) DEFAULT 0,
		  `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY  (id)
		) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sql2 );

	add_option("wp_autosubmitter_db_version","1.0.0");

	}

}
