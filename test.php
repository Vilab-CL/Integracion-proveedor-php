<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use Httpful\Request;

$url = "http://127.0.0.1/";
$key = "labmovil";

$user = array(
    "nombres" => "Manuel",
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



$token=  json_encode($user);


$jwt = JWT::encode($token, $key);

$uri = $url;
	$response = \Httpful\Request::post($uri)
                // 
                ->body('agente=Iniciar&info='.$jwt)
                 ->sendsType(\Httpful\Mime::FORM)
                ->send();
	$body = $response->body;

	$body = json_decode($body);



?>
	<body style="margin:0px;padding:0px;overflow:hidden">


<form id="moodleform" target="iframe"
      method="post" action="<?php echo $body->website ?>" >
    <input type="hidden" name="token" value="<?php echo $body->token?>"/>
</form>



    <iframe name="iframe" frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>

    <script type="text/javascript">
    document.getElementById('moodleform').submit();
</script>

</body>