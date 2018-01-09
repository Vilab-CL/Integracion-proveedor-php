<?php
require 'vendor/autoload.php';
use Httpful\Request;
$uri = "http://152.231.102.198:3030/login2";
$response = \Httpful\Request::get($uri)->send();
$body = $response->body;
echo  json_encode($body);
?>
