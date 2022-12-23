<?php defined('ABSPATH') or die('No script kiddies please!');
require_once("OAuth.php");
 
 global $wpdb;
$tbl_name = $wpdb->prefix.'sbwaccounts';
$row = $wpdb->get_row("SELECT * FROM $tbl_name where account_type='Linkedin'");
$app_id = $row->app_id;//'77gfx74tir39pu';
$app_secret = $row->app_secret;//'MtbvLvpnu4BtNK6N';
$data = array(
    'consumer_key' => $app_id,
    'consumer_secret' => $app_secret,
    'callback_url' => admin_url('admin-post.php?action=sbw_li_callback_authorize')
);

// echo "kjhdajkshd";
// $code = sanitize_text_field($_GET['oauth_verifier']);
// print_r($_REQUEST);
// print_r($_SESSION);
// exit();
 

if(isset($_REQUEST['oauth_verifier'])){
 
    $data['oauth_token'] = $_SESSION['oauth_request_token'];
    $data['oauth_token_secret'] = $_SESSION['oauth_request_token_secret'];
 
    $method = new OAuthSignatureMethod_HMAC_SHA1();
    $consumer = new OAuthConsumer($data['consumer_key'], $data['consumer_secret']);
    $token = new OAuthConsumer($data['oauth_token'],$data['oauth_token_secret']);
 
    $args = array();
    $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', "https://api.linkedin.com/uas/oauth/accessToken", $args);
    $request->set_parameter("oauth_verifier", $_REQUEST['oauth_verifier']);
    $request->sign_request($method, $consumer, $token);

    $request = http($request->to_url());
 
    
 
    parse_str($request, $token);
 
    $tokens = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret'], 1);
    $access_token = serialize($tokens);

    //print_r(unserialize($access_token));
    // Update db 
    global $wpdb; 
    $tbl_name = $wpdb->prefix.'sbwaccounts';
    $app_id = $data['consumer_key'];
    $wpdb->query("UPDATE $tbl_name SET access_token='$access_token' WHERE app_id='$app_id'");

    $_SESSION['sbw_auth_message'] = 'Linkedin account authorized successfully. Now you are all setup for posting.';
    $redirect_url = admin_url() . 'admin.php?page=sbw_accounts';
    // die($redirect_url);
    wp_redirect($redirect_url);
    //header('Location:'.  admin_url());
    exit();
}

function http($url, $post_data = null) {
    $ch = curl_init();

    if(defined("CURL_CA_BUNDLE_PATH"))
    curl_setopt($ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    if(isset($post_data))
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}