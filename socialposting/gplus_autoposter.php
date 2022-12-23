<?php

// require_once __DIR__ . "/google_sdk/vendor/autoload.php";
require_once __DIR__ . "/google_sdk/vendor/Client.php";
require_once __DIR__ . "/database.php";
 
/**
* 
*/
class GooglePosting
{
  
  function post_to_gplus()
  {
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google_Service_Plus::PLUS_ME);

    // returns a Guzzle HTTP Client
    $httpClient = $client->authorize();

    // make an HTTP request
    $response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
    print_r($response);
    //echo "talha";
      // $client = new Google_Client();
      // $client->setApplicationName("SocialPoster");
      // $client->setClientId("892955956328-1hgtocdbhd36fejsd0vuunmornu517tq.apps.googleusercontent.com");
      // $client->setClientSecret("0PvdIu1VJp45xDOpbLF-VkcT");
      // $client->setAccessType("offline");        // offline access
      // $client->setIncludeGrantedScopes(true);   // incremental auth
      // $client->setAccessToken(
      //     json_encode(
      //         array(
      //             'access_token' => $accessToken,
      //             'expires_in' => 3600,
      //             'token_type' => 'Bearer',
      //         )
      //     )
      // );
      // $client->setScopes(
      //     array(
      //         "https://www.googleapis.com/auth/userinfo.email",
      //         "https://www.googleapis.com/auth/plus.me",
      //         "https://www.googleapis.com/auth/plus.stream.write",
      //     )
      // );
      // $client = $client->authorize();

      // // create the URL for this user ID
      // $url = sprintf('https://www.googleapis.com/plusDomains/v1/people/me/activities');

      // // create your HTTP request object
      // $headers = ['content-type' => 'application/json'];
      // $body = [
      //     "object" => [
      //         "originalContent" => "Just WOW! #php #gplus #autopost",
      //     ],
      //     "access" => [
      //         "items" => [
      //             ["type" => "domain"],
      //         ],
      //         "domainRestricted" => true,
      //     ],
      // ];
      // $request = new Request('POST', $url, $headers, json_encode($body));

      // // make the HTTP request
      // $response = $client->send($request);

      // // did it work??
      // echo $response->getStatusCode().PHP_EOL;
      // echo $response->getReasonPhrase().PHP_EOL;
      // echo $response->getBody().PHP_EOL;
  }
}

// $database = new Database();
// $conn = $database->getConnection();
// $sql  = 'SELECT * FROM wp_sbwaccounts where account_type="Twitter"';
// $query  = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_array($query))
// {
  //echo $row['id'];
  $poster = new GooglePosting();
  //$poster->post_to_gplus($row['app_id'],$row['app_secret'],$row['access_token'], 
  $poster->post_to_gplus();

// }

