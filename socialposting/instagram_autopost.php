<?php

include 'simpleimage.class.php';
include 'instagram.class.php';

/**
* 
*/
class InstagramPosting
{
	
	function post_to_ig($username, $password, $data)
	{
		$username = $username;//'talhalogicso';   // your username
		$password = $password;//'Daredevil';   // your password
		$filename = $data["image_path"];//'logicso.jpg';   // your sample photo
		$caption = $data["title"].'. '.$data["description"].'. '.$data["short_url"];   // your caption

		$product_image= getcwd() .'/' . $filename;
		$square = getcwd().'/' . $filename;
		$image = new SimpleImage(); 
		$image->load($product_image); 
		$image->resize(480,600); 						
		$image->save($square, IMAGETYPE_JPEG);  
		unset($image);

		$insta = new instagram();
		$response = $insta->Login($username, $password);

		if(strpos($response[1], "Sorry")) {
		    echo "Request failed, there's a chance that this proxy/ip is blocked";
			print_r($response);
			exit();
		}         
		if(empty($response[1])) {
		    echo "Empty response received from the server while trying to login";
			print_r($response);	
			exit();	
		}

		$response = $insta->Post($square, $caption);
		if(!empty($response) && ($response[0] >= 200 && $response[0] < 300)) {
			return "Successfylly posted to Instagram";
		}
		else {
			return "Something went wrong while posting to Instagram";
		}
		//return $response;
	}
}

?>
