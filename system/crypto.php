<?php
class ViLabApi {
 private $user;
  private $passwd;
  private $expired;
  public $token;
  private $key;
  private $ruta;
  private $parametros;
    const METHOD = 'aes-256-cbc';
    function __construct() {
    }
   function Iniciar($user,$passwd) {
     $this->user = $user;
     $this->passwd = $passwd;
    //$this->autentificar();
    }
   function Token($Token) {
	$this->token = $Token;
    }
   function aes_encrypt()
    {
        $message = json_encode($this->parametros);
        $key = $this->key;
/*
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
*/
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivsize);
        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return bin2hex($iv . $ciphertext);
    }
    function decrypt($message)
    {
        $message = hex2bin($message);
        $key = $this->key;
/*  
      if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
*/
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($message, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($message, $ivsize, null, '8bit');
        return openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
   function autentificar(){

    return ;
$fp=fopen("keys/key.public.pem","r");

$pub_key=fread($fp,8192);
fclose($fp);
openssl_get_publickey($pub_key);
$source  = "$this->passwd";
$res =openssl_get_publickey($pub_key);
openssl_public_encrypt($source,$crypttext,$res,OPENSSL_PKCS1_OAEP_PADDING);
$aca2= urlencode(base64_encode($crypttext));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.labmovil.cl/v1/auth");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$this->user&cifrado=$aca2");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = "Pragma: no-cache";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Accept-Language: es-419,es;q=0.8";
$headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36";
$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$fp=fopen("keys/key.pem","r");
$priv_key=fread($fp,2048);
fclose($fp);
$crypttext= base64_decode($result);
$res = openssl_get_privatekey($priv_key);
$priv_key =$priv_key;
$res = openssl_get_privatekey($priv_key);
openssl_private_decrypt($crypttext, $newsource, $res, OPENSSL_PKCS1_OAEP_PADDING ) ;
$data = json_decode($newsource);
$this->token = $data->token;
$this->key = $data->key;
curl_close ($ch);
}
function consultar($ruta){
$this->ruta = $ruta;
$this->parametros = array();
}
function parametros($parametros){
$this-> parametros= $parametros;
}

function parametro($llave,$valor){
$this-> parametros[$llave] = $valor;
}
function ejecutar(){
$aca2= urlencode($this->aes_encrypt());
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.labmovil.cl/v1/$this->ruta");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "token=$this->token&cifrado=$aca2");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = "Pragma: no-cache";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Accept-Language: es-419,es;q=0.8";
$headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36";
$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Connection: keep-alive";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
return json_decode($this->decrypt($result));
}
}
?>