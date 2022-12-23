<?php 
//defined('ABSPATH') or die('No script kiddies please!');

// echo "talha";
// print_r($_POST);
// print_r($_SERVER);
// exit();


$errors = new WP_Error();

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['method'] )) {
	
	// print_r($_POST);
	// print_r($_POST['method']);
	
    if ( $_POST['method'] == "submit-fb-details" ) {
        
        $fields = array(
                'fb_api_key',
                'fb_app_secret'              
            );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) 
                $posted[$field] = stripslashes(trim($_POST[$field])); 
            else 
                $posted[$field] = '';
        }
        
        if ($posted['fb_api_key'] != null ) {
            $fb_api_key =  $_POST['fb_api_key'];
        }
        else {
            $errors->add('empty_title', __('<strong>WARRNING</strong>: Please enter your facebook app id first.', 'sws'));
        }
        if ($posted['fb_app_secret'] != null ) {
            $fb_app_secret =  $_POST['fb_app_secret'];
        }
        else {
            $errors->add('empty_secret', __('<strong>WARRNING</strong>: Please enter your facebook app secret first.', 'sws'));
        }
        if (!$errors->get_error_code() ) { 

            if (save_SBW_account_data($fb_api_key, $fb_app_secret, null, null, 'Facebook')) {
                unset($fb_api_key, $fb_app_secret);
            	redirect_to_accounts_page('Facebook', null, true);
            }
        }
        else {
        	redirect_to_accounts_page('Facebook', $errors, false);
        }

    }
    else if ($_POST['method'] == "submit-tw-details") {
        $fields = array(
                'tw_api_key',
                'tw_app_secret',
                'tw_access_token',
                'tw_access_token_secret'             
            );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) 
                $posted[$field] = stripslashes(trim($_POST[$field])); 
            else 
                $posted[$field] = '';
        }
        
        if ($posted['tw_api_key'] != null ) {
            $tw_api_key =  $_POST['tw_api_key'];
        }
        else {
            $errors->add('empty_title', __('<strong>WARRNING</strong>: Please enter your twitter api key first.', 'sws'));
        }
        if ($posted['tw_app_secret'] != null ) {
            $tw_app_secret =  $_POST['tw_app_secret'];
        }
        else {
            $errors->add('empty_secret', __('<strong>WARRNING</strong>: Please enter your twitter api secret first.', 'sws'));
        }
        if ($posted['tw_access_token'] != null ) {
            $tw_access_token =  $_POST['tw_access_token'];
        }
        else {
            $errors->add('empty_access_token', __('<strong>WARRNING</strong>: Please enter your twitter access token first.', 'sws'));
        }
        if ($posted['tw_access_token_secret'] != null ) {
            $tw_access_token_secret =  $_POST['tw_access_token_secret'];
        }
        else {
            $errors->add('empty_access_token_secret', __('<strong>WARRNING</strong>: Please enter your twitter access token secret first.', 'sws'));
        }
        if (!$errors->get_error_code() ) { 

            if (save_SBW_account_data($tw_api_key, $tw_app_secret, $tw_access_token, $tw_access_token_secret, 'Twitter')) {
                unset($tw_api_key, $tw_app_secret, $tw_access_token, $tw_access_token_secret);
                redirect_to_accounts_page('Twitter', null, true);
            }
        }
        else {
        	redirect_to_accounts_page('Twitter', $errors, false);
        }
    }
    else if ($_POST['method'] == "submit-li-details") {
        $fields = array(
                'li_api_key',
                'li_app_secret'              
            );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) 
                $posted[$field] = stripslashes(trim($_POST[$field])); 
            else 
                $posted[$field] = '';
        }
        
        if ($posted['li_api_key'] != null ) {
            $li_api_key =  $_POST['li_api_key'];
        }
        else {
            $errors->add('empty_title', __('<strong>WARRNING</strong>: Please enter your linkedin client id first.', 'sws'));
        }
        if ($posted['li_app_secret'] != null ) {
            $li_app_secret =  $_POST['li_app_secret'];
        }
        else {
            $errors->add('empty_secret', __('<strong>WARRNING</strong>: Please enter your linkedin client secret first.', 'sws'));
        }
        if (!$errors->get_error_code() ) { 

            if (save_SBW_account_data($li_api_key, $li_app_secret, null, null, 'Linkedin')) {
                unset($li_api_key, $li_app_secret);
            	redirect_to_accounts_page('Linkedin', null, true);
            }
        }
        else {
        	redirect_to_accounts_page('Linkedin', $errors, false);
        }
    }
    else if ($_POST['method'] == "submit-ig-details") {
        $fields = array(
                'ig_api_key',
                'ig_app_secret'              
            );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) 
                $posted[$field] = stripslashes(trim($_POST[$field])); 
            else 
                $posted[$field] = '';
        }
        
        if ($posted['ig_api_key'] != null ) {
            $ig_api_key =  $_POST['ig_api_key'];
        }
        else {
            $errors->add('empty_title', __('<strong>WARRNING</strong>: Please enter your instagram username first.', 'sws'));
        }
        if ($posted['ig_app_secret'] != null ) {
            $ig_app_secret =  $_POST['ig_app_secret'];
        }
        else {
            $errors->add('empty_secret', __('<strong>WARRNING</strong>: Please enter your instagram password first.', 'sws'));
        }
        if (!$errors->get_error_code() ) { 

            if (save_SBW_account_data($ig_api_key, $ig_app_secret, null, null, 'Instagram')) {
                unset($ig_api_key, $ig_app_secret);
            	redirect_to_accounts_page('Instagram', null, true);
            }
        }
        else {
        	redirect_to_accounts_page('Instagram', $errors, false);
        }
    }
    

    
}

function save_SBW_account_data($app_id, $app_secret, $access_token, $access_token_secret, $account_type){
    global $wpdb; 
    $tbl_name = $wpdb->prefix.'sbwaccounts'; 
    $access_token = (empty($access_token))? '' : $access_token;
    $access_token_secret = (empty($access_token_secret))? '' : $access_token_secret;
    if(account_exist($account_type)){

        $wpdb->query("UPDATE $tbl_name SET app_id='$app_id', app_secret='$app_secret', access_token='$access_token', access_token_secret='$access_token_secret'  WHERE account_type='$account_type'");
        return true;
    }
    else {
        $kv_data = array( 
            'app_id' => $app_id, 
            'app_secret'    => $app_secret,
            'access_token' => $access_token,
            'access_token_secret' => $access_token_secret,
            'account_type' => $account_type
        ) ; 
        


        if ($wpdb->insert( $tbl_name, $kv_data ) ) {
            return true;
        }
        else {
            return false;
        }
    }

    
}

function redirect_to_accounts_page($account_type, $errors = null, $success = true){
	$_SESSION['sbw_message'] = $account_type . ' details saved successfully';
	$_SESSION['sbw_success'] = $success;
	$_SESSION['sbw_errors'] = $errors;
	$redirect_url = admin_url() . 'admin.php?page=sbw_accounts';
    wp_redirect($redirect_url);
	
	exit();
}

function account_exist($account_type) {
    global $wpdb;
    $tbl_name = $wpdb->prefix.'sbwaccounts';
    $row = $wpdb->get_row("SELECT * FROM $tbl_name where account_type='$account_type'");
    if($row != null) {
        return true;
    }
    else {
        return false;
    }
}



