<?php defined('ABSPATH') or die('No script kiddies please!');
//$account_details = get_option('afap_settings');
//$this->print_array($account_details);die();
global $wpdb;
$tbl_name = $wpdb->prefix.'sbwaccounts';
$row = $wpdb->get_row("SELECT * FROM $tbl_name where account_type='Facebook'");
$app_id = $row->app_id;//'409286219523395';
$app_secret = $row->app_secret;//'03d0dc394c1ee22587949bc531e4a141';


$redirect_url = admin_url('admin-post.php?action=sbw_callback_authorize');
$api_version = 'v2.0';
$param_url = urlencode($redirect_url);
$asap_session_state = md5(uniqid(rand(), TRUE));
setcookie("afap_session_state", $asap_session_state, "0", "/");

$dialog_url = "https://www.facebook.com/" . $api_version . "/dialog/oauth?client_id="
        . $app_id . "&redirect_uri=" . $param_url . "&state="
        . $asap_session_state . "&scope=email,user_about_me,publish_pages,user_posts,publish_actions,manage_pages";
//die($dialog_url);

header("Location: " . $dialog_url);
