<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://logicso.tech
 * @since      1.0.0
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Autosubmitter
 * @subpackage Wp_Autosubmitter/admin
 * @author     Logicso.tech <talha@logicso.tech>
 */
class Wp_Autosubmitter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
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
		 * defined in Wp_Autosubmitter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Autosubmitter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-autosubmitter-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'sbw-custom-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), '1.12.1', 'all' );

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
		 * defined in Wp_Autosubmitter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Autosubmitter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		

		wp_enqueue_script( 'sbw-custom-jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array( 'jquery' ), '1.12.4', false );

		wp_enqueue_script( 'sbw-custom-jquery-ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array( 'jquery' ), '1.12.1', false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-autosubmitter-admin.js', array( 'jquery' ), $this->version.'1', false );

	}


	/**
	*
	* admin/class-wp-autosubmitter-admin.php - Don't add this
	*
	**/

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */
	    //add_options_page( 'SBW Auto Submitter Setup', 'SBW Settings', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));

	    add_menu_page('SBW Auto Submitter', 'SBW|Auto Poster', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), plugin_dir_url(__FILE__) . '/images/icon_sbw.png', null);

	    add_submenu_page($this->plugin_name, 'SBW Settings', 'Post', 'manage_options', $this->plugin_name);
	    add_submenu_page($this->plugin_name, 'SBW Accounts', 'Accounts', 'manage_options', 'sbw_accounts', array($this, 'display_plugin_account_page'));
	    //add_submenu_page($this->plugin_name, 'SBW Test', 'Test', 'manage_options', 'sbw_test', array($this, 'display_plugin_test_page'));
	    
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/wp-autosubmitter-admin-display.php' );
	}


	/**
	 * Render the accounts page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_account_page() {
	    include_once( 'partials/wp-autosubmitter-accounts-display.php' );
	    //include_once( 'partials/test.php' );
	}

	/**
	 * Render the test page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_test_page() {
	    include_once( 'partials/test.php' );
	}

	
	/**
	 * Action to post data to API
	 */
	public function sbw_post_action() {
	    include('inc/post.php');
	}

	/**
	 * Action to save accounts
	 */
	public function sbw_save_action() {
	    include('inc/cores/save-accounts.php');
	}


	/**
	 * Action to redirect to accounts page
	 */
	public function sbw_setup_account() {
	    include('inc/cores/load-accounts.php');
	}

	


	/**
	 * Action to authorize the facebook
	 */
	public function fb_authorize_action() {
	    include('inc/cores/fb-authorization.php');
	}

	/**
	 * Facebook Authorize Callback
	 */
	public function sbw_callback_authorize() {
	    include('inc/cores/fb-authorization-callback.php');
	}

	/**
	 * Action to authorize the linkedin
	 */
	public function li_authorize_action() {
	    include('inc/cores/li-authorization.php');
	}

	/**
	 * Linkedin Authorize Callback
	 */
	public function sbw_li_callback_authorize() {
	    include('inc/cores/li-authorization-callback.php');
	}

}
