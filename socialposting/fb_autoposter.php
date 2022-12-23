<?php
//require_once("/path/to/facebook_php_sdk/facebook.php"); // set the right path
require_once __DIR__ . "/facebook_php_sdk/facebook.php";
require_once __DIR__ . "/database.php";
 
/**
* 
*/
class FacebookPosting
{
  
  function post_to_fb($app_id, $app_secret, $access_token, $data)
  {
      $config = array();
      $config['appId'] = $app_id;//'409286219523395';
      $config['secret'] = $app_secret;//'03d0dc394c1ee22587949bc531e4a141';
      $config['fileUpload'] = false; // optional
      $fb = new Facebook($config);
       
      $params = array(
        // this is the main access token (facebook profile)
        "access_token" => $access_token,//"EAAF0PlZB55UMBALPVH2kXieS26i1JiaZA9L0hNM7y7c6Xw8PP3ZBz3tC95gHZCA5FQxY6CIb9mUMwzCB13qonNPgMZARYn2980f8QHjZB4RqiAMlDQkZASVs4fF5gWPxrEEwjA7RnFXehxKhBbkHZCLZBGhwUEsl6soWj7EDqA7z9agZDZD",
        "message" => $data["title"],
        "link" => $data["link"],
        "picture" => $data["image_url"],
        "name" => $data["title"],
        "caption" => $data["title"],
        "description" => $data["description"]
      );

      // print_r($params);
       
      try {
        $ret = $fb->api('/me/feed', 'POST', $params);
        return "Successfylly posted to Facebook";
      } catch(Exception $e) {
        return "Something went wrong while posting to Facebook -- ".$e->getMessage();
      }
  }
}

?>

