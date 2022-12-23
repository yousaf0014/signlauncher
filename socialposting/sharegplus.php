<?php

require_once __DIR__ . "/google_sdk/vendor/Client.php";


$scopes = array(
    "https://www.googleapis.com/auth/plus.me",
    "https://www.googleapis.com/auth/plus.stream.write"
);

//create Google Client Object and set its configurations
$client = new Google_Client();
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/sharegplus.php');
$client->setAuthConfig('client_secrets.json');
$client->addScope($scopes);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
echo "if";
//     $client->setAccessToken($_SESSION['access_token']); 
//     $service = new Google_Service_PlusDomains($client);

//     $activity = array(
//         'access' => array(
//             'items' => array(
//                 'type' => 'domain'
//             ),
//             'domainRestricted' => true
//         ),
//         'verb' => 'post',
//         'object' => array(
//             'originalContent' => "Post using Google API PHP Client Library!" 
//         ), 
//     );

//     $options = array(
//         "headers" => array(
//             'content-type' => 'application/json; charset=UTF-8'
//         ),
//         "body" => json_encode($activity)
//     );

//     $httpClient = $client->authorize();
//     $request = $httpClient->request("POST", "https://www.googleapis.com/plusDomains/v1/people/me/activities", $options);
//     $response = $request->getBody();    

//     print_r($response->getContents());

} else {
	

    if (!isset($_GET['code'])) { //If access code is not defined  

    $auth_url = $client->createAuthUrl(); // create authentication URL
    // header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

  } else { //If access code is defined  

//     $client->authenticate($_GET['code']);
//     $_SESSION['access_token'] = $client->getAccessToken();
//     $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/sharegplus.php';
//     header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

  }

}