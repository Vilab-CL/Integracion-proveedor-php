<?php

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$key = "shhhhh";
$user = array(
    "nombre" => "Manuel",
    "apellidos" => "Alba Escobar",
    "email" => "malba@mmae.cl",
    "telefono" => "96344738",
    "rut" => "18020677-9",
    "identificador" => 26645,
    "predios" => array()
);

$predio = array(
    "nombre" => "Santa Lina",
    "latitud" => -34.3453,
    "longitud" => -79.3453,
    "dispositivos_solicitados" => 0 ,
    "habilitados" => 2
);


array_push($user["predios"],$predio);

$predio = array(
    "nombre" => "Santa Sofia",
    "latitud" => -38.3453,
    "longitud" => -74.3453,
    "dispositivos_solicitados" => 0 ,
    "habilitados" => 2
);


array_push($user["predios"],$predio);








$jwt = JWT::encode($token, $key);

print_r($jwt);

print_r('<br>');

$decoded = JWT::decode($jwt, $key, array('HS256'));

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));

?>
