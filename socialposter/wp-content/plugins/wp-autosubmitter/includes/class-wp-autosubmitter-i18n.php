<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://logicso.tech
 * @since      1.0.0
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/includes
 * @author     Logicso.tech <talha@logicso.tech>
 */
class Wp_Autosubmitter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-autosubmitter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
