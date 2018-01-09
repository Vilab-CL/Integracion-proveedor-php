<?php

use \Firebase\JWT\JWT;
use Httpful\Request;
use \ParagonIE\EasyRSA\EasyRSA;
use \ParagonIE\EasyRSA\PrivateKey;
use \ParagonIE\EasyRSA\PublicKey;
$DATA= $post;



require_once ('config.php');
//require_once ('system/crypto.php');
require_once('core/web.php');
require_once('core/android.php');



if ( !isset($DATA["json"]) ) {
 
  $agente = $DATA["agente"];
}
else {
 $agente="";
}

//echo "AQUI";

if ($agente == "Iniciar"){
	//$inicio= new Iniciar();
	//$inicio->BeforeCheck($DATA["usuario"]);

    $token = $DATA["info"];
  
    $decoded = JWT::decode($token, $key_system, array('HS256'));

    $usuario = json_decode($decoded);
    $usuario = (array) $usuario;

    
    $jwt  =  JWT::encode($usuario, $key_propia);

    $profile  = array();
    $profile["data"] = $jwt;
    $profile["usuario"] = $usuario;
    $profile["jwt"] = $jwt;
    $profile["passwd"] =$password;
    $profile["user"] =$user;


	//$jwt = JWT::encode($profile, $vilabKey, 'HS256');

	/*$keyPair = KeyPair::generateKeyPair(4096);

$secretKey = $keyPair->getPrivateKey();
$publicKey = $keyPair->getPublicKey();
*/


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}




openssl_get_publickey($vilabKey);


$source  = generateRandomString(20);

$res =openssl_get_publickey($vilabKey);
openssl_public_encrypt($source,$crypttext,$res,OPENSSL_PKCS1_OAEP_PADDING);

//print_r($crypttext);
$key= urlencode(base64_encode($crypttext));



$jwt = JWT::encode($profile, $source, 'HS256');


//echo "\n".$aca2;

$response = \Httpful\Request::post($url."login2")
                ->body('key='.$key.'&data='.$jwt)
                 ->sendsType(\Httpful\Mime::FORM)
                ->send();
	$body = $response->body;
//print_r($body);


	//$body = JWT::decode($body, $privateKey, array('RS256'));*/







$crypttext= base64_decode($body->key);



$res = openssl_get_privatekey($privateKey);

openssl_private_decrypt($crypttext, $newsource, $res, OPENSSL_PKCS1_OAEP_PADDING ) ;


//echo $newsource;

JWT::$leeway = 5; 
$result =  JWT::decode($body->data , $newsource, array('HS256'));

print_r(json_encode($result));

}else {

	$DATA= $DATA['json'];

	$DATA2= json_decode ($DATA,true);
	$DATA2 =  (array) $DATA2;

	$DATA= json_decode ($DATA,true);
	$DATA =  (array) $DATA;


	

	//var_dump($DATA);
	$agente = $DATA["agente"];

	

if($agente == "Web") {
	$router= new Web();


	$uri = $url."Queue";



	$SEND = array();


	$SEND['parametros']= $DATA["parametros"];
	$SEND['consultar']=$DATA["consultar"];
	$router->Consulta($DATA2["consultar"],$DATA2["parametros"]);
	

	$jwt = JWT::encode(json_encode($SEND), $key_proovedor);
	$response = \Httpful\Request::post($uri)
                // 
                ->body('data='.$jwt)
                 ->sendsType(\Httpful\Mime::FORM)
                ->send();
	$body = $response->body;

	prettyPrint($body);


	

}

elseif ($agente == "Android"){
	$router= new Android();
}
else
{
	echo "No Autorizado Agente Desconocido";
	//exit(0);
 
}

}

//echo "ahola LINE";

//echo var_dump($DATA);
//echo ;

/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


$Router= new Android();

$Router->identificar($DATA["token"]);

try {
$vilab->Iniciar($user,$password)

} catch (Exception $e) {
    echo 'Excepción capturada: ';
}

if (!$router->send($ruta,$parametros) );
  exit(0);





$vilab->parametros($json);
$out = $vilab->ejecutar();
header('Content-Type: application/json');
echo json_encode( $out );
*/


?>
