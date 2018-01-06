<?php 
require 'vendor/autoload.php';
if (true && $_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$post= $_POST;
	//$post = [];
	//echo "Aku2i";
	require_once ('system/router.php');
	//echo "Akui";
}
else{

	echo "No Autorizados";
}
?>