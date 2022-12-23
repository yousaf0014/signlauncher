<?php

$response = array('status' => 'success');

$res = array('response' => 'Response Facebook');
$response["Facebook"] = $res;

$res = array('response' => 'Response Twitter');
$response["Twitter"] = $res;

$res = array('response' => 'Response Linkedin');
$response["Linkedin"] = $res;

$res = array('response' => 'Response Instagram');
$response["Instagram"] = $res;


echo json_encode($response); 