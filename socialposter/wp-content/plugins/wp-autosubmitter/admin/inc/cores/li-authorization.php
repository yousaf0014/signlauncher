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
 
$method = new OAuthSignatureMethod_HMAC_SHA1();
$consumer = new OAuthConsumer($data['consumer_key'], $data['consumer_secret']);
$token = NULL;
 
$args = array('scope' => 'w_share');
 
$request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET',
  "https://api.linkedin.com/uas/oauth/requestToken", $args);
 
$request->set_parameter("oauth_callback", $data['callback_url']);
$request->sign_request($method, $consumer, $token);
$request = http($request->to_url());
 
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
 
parse_str($request, $token);
 
$_SESSION['oauth_request_token'] = $token['oauth_token'];
$_SESSION['oauth_request_token_secret'] =   $token['oauth_token_secret'];
 
if(is_array($token)){
    $token = $token['oauth_token'];
}
 
$request_link = "https://api.linkedin.com/uas/oauth/authorize?oauth_token=" . $token;
 
header('Location: '. $request_link);
exit;