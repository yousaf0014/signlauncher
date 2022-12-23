<?php

$errors = new WP_Error();


if( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	
	$fields = array(
            'post_title',
            'post_link',
            'post_description',
            'image_attachment_url'
        );
    foreach ($fields as $field) {
        if (isset($_POST[$field])) 
            $posted[$field] = stripslashes(trim($_POST[$field])); 
        else 
            $posted[$field] = '';
    }
    
    if ($posted['post_title'] != null ) {
        $post_title =  $_POST['post_title'];
    }
    else {
        $errors->add('empty_title', __('<strong>WARRNING</strong>: Please enter title first.', 'sws'));
    }

    if ($posted['post_link'] != null ) {
        $post_link =  $_POST['post_link'];
    }
    else {
        $errors->add('empty_link', __('<strong>WARRNING</strong>: Please enter link first.', 'sws'));
    }

    if ($posted['post_description'] != null ) {
        $post_description =  $_POST['post_description'];
    }
    else {
        $errors->add('empty_description', __('<strong>WARRNING</strong>: Please enter discription first.', 'sws'));
    }

    if ($posted['image_attachment_url'] != null ) {
        $image_attachment_url =  $_POST['image_attachment_url'];
    }
    else {
        $errors->add('empty_image', __('<strong>WARRNING</strong>: Please enter image first.', 'sws'));
    }

    
    if (!$errors->get_error_code() ) { 

        if (save_SBW_post_data($post_title, $post_link, $post_description, $image_attachment_url)) {
        	$accounts = get_accounts();
            $response = post_data_to_api($post_title, $post_link, $post_description, $image_attachment_url,$accounts);
            unset($post_title, $post_link, $post_description, $image_attachment_url);
        	redirect_to_post_page($response, null, true);
        }
    }
    else {
    	redirect_to_post_page(null, $errors, false);
    }

}


function save_SBW_post_data($post_title, $post_link, $post_description, $post_image) {
    global $wpdb; 
    $tbl_name = $wpdb->prefix.'sbwposts'; 
    $kv_data = array( 
        'post_title' => $post_title, 
        'post_link'    => $post_link,
        'post_description' => (empty($post_description))? '' : $post_description,
        'post_image' => (empty($post_image))? '' : $post_image
    ) ; 
    
    if ($wpdb->insert( $tbl_name, $kv_data ) ) {
        return true;
    }
    else {
        return false;
    }
}

function get_accounts() {
	$jsonData = array();
	global $wpdb;
    $tbl_name = $wpdb->prefix.'sbwaccounts';
	$results = $wpdb->get_results("SELECT * FROM $tbl_name");
	foreach($results as $row){ 
	  if ($row->account_type === 'Facebook') {
	  	if (!empty($row->access_token)){
		    $fb = array(
		    	'app_id' => $row->app_id, 
		    	'app_secret' => $row->app_secret, 
		    	'access_token' => $row->access_token);
		  	$jsonData['Facebook'] = $fb;
		  }
	  }
	  else if ($row->account_type === 'Twitter') {
	  	$tw = array(
	  		'app_id' => $row->app_id, 
	  		'app_secret' => $row->app_secret, 
	  		'access_token' => $row->access_token, 
	  		'access_token_secret' => $row->access_token_secret);
	  	$jsonData['Twitter'] = $tw;
	  }
	  else if ($row->account_type === 'Linkedin') {
	  	if (!empty($row->access_token)){
		  	$li = array(
		  		'app_id' => $row->app_id, 
		  		'app_secret' => $row->app_secret, 
		  		'access_token' => $row->access_token);
		  	$jsonData['Linkedin'] = $li;
		  }
	  }
	  else if ($row->account_type === 'Instagram') {
	    
	    $ig = array(
	    	'app_id' => $row->app_id, 
	    	'app_secret' => $row->app_secret);
	  	$jsonData['Instagram'] = $ig;
	  }
	}

	return $jsonData;
}



function post_data_to_api($post_title, $post_link, $post_description, $post_image,$jsonData) {
	// echo "Talha";
	//API Url
	$url = 'http://signlauncher.com/socialposting/autopost.php';//'http://localhost:8080/SocialPosting/autopost.php';

	//Initiate cURL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//The JSON data.
	$jsonData['post_title'] = (empty($post_title))? '' : $post_title;
	$jsonData['post_link'] = (empty($post_link))? '' : $post_link;
	$jsonData['post_description'] = (empty($post_description))? '' : $post_description;
	$jsonData['post_image'] = (empty($post_image))? '' : $post_image;

	//Encode the array into JSON.
	$jsonDataEncoded = json_encode($jsonData);

	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);

	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

	//Set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

	//Execute the request
	$response = curl_exec($ch);
	$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);    

    // echo "<pre>-----http----";
    //     print_r($http);
    //     echo "<br/>----response----";
    //     print_r($response);
    //     echo "</pre><br/>";
    
    curl_close($ch);   
	return json_decode($response);
	
}

function redirect_to_post_page($response, $errors = null, $success = true) {
	$_SESSION['sbw_post_response'] = $response;
	$_SESSION['sbw_success'] = $success;
	$_SESSION['sbw_errors'] = $errors;
	$redirect_url = admin_url() . 'admin.php?page=wp-autosubmitter';
    wp_redirect($redirect_url);
	
	exit();
}


