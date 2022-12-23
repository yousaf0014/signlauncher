<?php
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/fb_autoposter.php";
require_once __DIR__ . "/tw_autoposter.php";
require_once __DIR__ . "/li_autoposter.php";
require_once __DIR__ . "/instagram_autopost.php";
require_once __DIR__ . "/saveimage.php";


//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$decoded_json = json_decode($content, true);

//If json_decode failed, the JSON is invalid.
if(!is_array($decoded_json)){
    throw new Exception('Received content contained invalid JSON!');
}



//Process the JSON.
$save_image = new SaveImage();
$image_path = $save_image->save_image($decoded_json["post_image"]);

$shortenedurl = file_get_contents("http://$_SERVER[HTTP_HOST]/socialposting/urlshortner/shorten.php?longurl=" . urlencode($decoded_json["post_link"]));

$post_data = array("title" => $decoded_json["post_title"], "link" => $decoded_json["post_link"], "description" => $decoded_json["post_description"], "image_url" => $decoded_json["post_image"], "image_path" => $image_path, "short_url" => $shortenedurl);

$facebook = $decoded_json['Facebook'];
$twitter = $decoded_json['Twitter'];
$linkedin = $decoded_json['Linkedin'];
$instagram = $decoded_json['Instagram'];


$response = array('status' => 'success');

if ($facebook) {
  
  $poster = new FacebookPosting();
  $res = $poster->post_to_fb($facebook['app_id'],$facebook['app_secret'],$facebook['access_token'],$post_data);
  $response["Facebook"] = $res;
}
if ($twitter) {
  
  $poster = new TwitterPosting();
  $res = $poster->post_to_tw($twitter['app_id'],$twitter['app_secret'],$twitter['access_token'], $twitter['access_token_secret'],$post_data);
  $response["Twitter"] = $res;
}
if ($linkedin) {
  
  $poster = new LinkedinPosting();
  $res = $poster->post_to_li($linkedin['app_id'],$linkedin['app_secret'],$linkedin['access_token'],$post_data);
  $response["Linkedin"] = $res;
}
if ($instagram) {
  
  $poster = new InstagramPosting();
  $res = $poster->post_to_ig($instagram['app_id'],$instagram['app_secret'],$post_data);
  $response["Instagram"] = $res;
}

echo json_encode($response); 

