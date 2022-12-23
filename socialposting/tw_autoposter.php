<?php

require_once __DIR__ . "/twitter_php_sdk/codebird.php";
require_once __DIR__ . "/database.php";
 
/**
* 
*/
class TwitterPosting
{
  
  function post_to_tw($app_id, $app_secret, $access_token, $access_token_secret, $data)
  {
      //\Codebird\Codebird::setConsumerKey('mflQ3RtZoOaxx1r7z0TpeS6kv', 'XuMzEbCls4u2OuAIRkSAaZ0UHQiEFkge0MBhSSQKIywo2XvzLC');
      //$cb->setToken('390151758-eY2lGKOyZiBmdTfbtJ0jZMFi7XznwYUUsNYtSMFB', '9tuEeMJ0ORuU6qPOAlNSuCzJuQeECh0mNmAJk4RCXsC4b');
      \Codebird\Codebird::setConsumerKey($app_id, $app_secret);
      $cb = \Codebird\Codebird::getInstance();
      $cb->setToken($access_token, $access_token_secret);

      $reply = array();

      if($data["image_path"]) {
        $params = array(
          'status' => $data["title"].'. '.$data["short_url"],
          'media[]' => $data['image_path']
        );
        $reply = $cb->statuses_updateWithMedia($params);
      } else {
        $params = array(
          'status' => $data["title"].'. '.$data["short_url"]
        );
        $reply = $cb->statuses_update($params);
      }

      $status = $reply->httpstatus;
      if($status == 200) {
        return "Successfylly posted to Twitter";
      }
      else {
        return "Something went wrong while posting to Twitter";   
      }
    }
}
