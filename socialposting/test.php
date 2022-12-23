<?php

require_once __DIR__ . "/database.php";

$database = new Database();
$conn = $database->getConnection();
$sql  = 'SELECT * FROM wp_sbwaccounts where account_type="Twitter"';
$query  = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query))
{
  //echo $row['id'];
  $poster = new TwitterPosting();
  $poster->post_to_tw($row['app_id'],$row['app_secret'],$row['access_token'], $row['access_token_secret']);

}
