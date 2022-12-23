<?php
//require_once("/path/to/facebook_php_sdk/facebook.php"); // set the right path
require_once __DIR__ . "/OAuth/OAuth.php";
require_once __DIR__ . "/database.php";
 
/**
* 
*/
class LinkedinPosting
{
  
  function post_to_li($app_id, $app_secret, $access_token, $jsondata)
  {

    // print_r($app_id);
    // print_r($app_secret);
    // print_r($access_token);
    // print_r($jsondata);

 
 
    $data = array(
        'consumer_key' => $app_id,
        'consumer_secret' => $app_secret,
        'callback_url' => ''
    );
     
    $method = new OAuthSignatureMethod_HMAC_SHA1();
    $consumer = new OAuthConsumer($data['consumer_key'], $data['consumer_secret']);
     
    $access_token = unserialize($access_token);
     
    $title = $jsondata["title"];
    $targetUrl = $jsondata["link"];
    $imgUrl = $jsondata["image_url"];
    $description= $jsondata["description"];
     
    $shareUrl = "http://api.linkedin.com/v1/people/~/shares";
    $xml = "<share>";
    $xml .= "<content>
    <title>{$title}</title>
    <description>{$description}</description>";
    if(!empty($targetUrl)){
        $xml .= "<submitted-url>{$targetUrl}</submitted-url>";
    }
     
    if(!empty($imgUrl)){
        $xml .= "<submitted-image-url>{$imgUrl}</submitted-image-url>";
    }
    $xml .= "</content>
      <visibility>
        <code>anyone</code>
      </visibility>
    </share>";
     
    $request = OAuthRequest::from_consumer_and_token($consumer, $access_token, "POST", $shareUrl);
    $request->sign_request($method, $consumer, $access_token);
    $auth_header = $request->to_header("https://api.linkedin.com");
     
    $response = $this->httpRequest($shareUrl, $auth_header, "POST", $xml);

    if(!empty($response) && ($response[0] >= 200 && $response[0] < 300)) {
      return "Successfylly posted to Linkedin";
    }
    else {
      return "Something went wrong while posting to Linkedin";
    }
    //return $response;
  }

  function httpRequest($url, $auth_header, $method, $body = NULL) {
      if (!$method) {
          $method = "GET";
      }
   
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header)); // Set the headers.
   
      if ($body) {
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
          curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header, "Content-Type: text/xml;charset=utf-8"));  
      }
   
      $data = curl_exec($curl);
      $http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      return array($http, $data);
    }
}

// $database = new Database();
// $conn = $database->getConnection();
// $sql  = 'SELECT * FROM wp_sbwaccounts where account_type="Linkedin"';
// $query  = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_array($query))
// {
//   //echo $row['id'];
//   $poster = new LinkedinPosting();
//   $poster->post_to_li($row['app_id'],$row['app_secret'],$row['access_token']);

// }


?>

