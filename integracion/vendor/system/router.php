<?php
//echo "Aku333i";
use \Firebase\JWT\JWT;
use Httpful\Request;
$DATA= $post;

$url ="http://152.231.102.198:3030/";

require_once ('config.php');
//require_once ('system/crypto.php');
require_once('core/web.php');
require_once('core/android.php');
//require_once('core/android.php');
/*$vilab = new ViLabApi();
$vilab->consultar("Queue");
*/
//echo "ACA";




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

    $perfil   = array();
    $usuario  = array();
    $campos  = array();
    $usuario['nombre']   = "Manuel";
    $usuario['apellido'] = "Alba";
    $usuario['rut']     = "18020677-9";
    
    $campos





    $perfil['user']= $usuario;

    $a_cifrar= json_encode($perfil);

	$perfil['token'] = JWT::encode($a_cifrar, $privateKey, 'RS256');

	$a_cifrar= json_encode($perfil);

$jwt = JWT::encode($a_cifrar , $privateKey, 'RS256');



echo "Encode:\n" . print_r($jwt, true) . "\n";

$decoded = JWT::decode($jwt, $publicKey, array('RS256'));

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

 

$decoded_array = (array) $decoded;
echo "Decode:\n" . print_r($decoded_array, true) . "\n";
/*


	$jwt = JWT::encode($own_token, $key_proovedor);


	

	

	$uri = $url."login2";
	$response = \Httpful\Request::post($uri)
                // 
                ->body('data='.$jwt)
                 ->sendsType(\Httpful\Mime::FORM)
                ->send();
	$body = $response->body;

	echo  json_encode($body);

	*/



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

	echo  json_encode($body);


	

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

