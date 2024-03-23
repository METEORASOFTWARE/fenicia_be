<?php
	ini_set("include_path", '/usr/share/pear:' . ini_get("include_path") );

	/* Funciones Propias de la API */
	function SessionValidateR2($token, &$message) {
	  //echo "Entro a SessionValidateR2";
	  require_once 'HTTP/Request2.php';
	  $request = new HTTP_Request2();
	  $request->setUrl('https://fenicia.meteoracolombia.co:8443/admin/realms/meteora/users/7fecb76b-198c-4f75-8003-aac34daafa50/sessions');	  
	  $request->setMethod(HTTP_Request2::METHOD_GET);
	  $request->setConfig(array(
		'follow_redirects' => TRUE
	  ));
	  $request->setHeader(array(
		'Authorization' => 'Bearer ' . $token
	  ));
	  try {
		$response = $request->send();
		if ($response->getStatus() == 200) {
		  $message = 'Ok';
		  return true;
		}
		else {
		  $message =  'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		  return false;
		}
	  }
	  catch(HTTP_Request2_Exception $e) {
		$message =  'Error: ' . $e->getMessage();
		return false;
	  }
	 return false;
	}

	function SessionValidateR3($token, &$message) {
		//echo "Entro a SessionValidateR3 usando curl";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://fenicia.meteoracolombia.co:8443/admin/realms/meteora/users/7fecb76b-198c-4f75-8003-aac34daafa50/sessions',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_SSL_VERIFYPEER => false, 
		  CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer ' . $token
		  ),
		));
		
		$response = curl_exec($curl);
		if ($response === false) {
			$message =  'Error: ' . curl_error($curl);
			curl_close($curl);
			return false;			
		} else {
			$message = 'Ok';
			curl_close($curl);
			return true;
		}
	  }
  

	  function SessionValidateCurl($token, &$message) {
	/*  $curl = curl_init();

	  curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://206.189.189.123:8080/admin/realms/4p1/users/3e8f3e80-ba67-4cb5-95da-bd6ff573f7e1/sessions',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
		  'Authorization: Bearer ' . $token
		),
	  ));

	  $response = curl_exec($curl);

	  curl_close($curl);
	  echo $response;*/
	  return false;
	}

	/**
	 * Get hearder Authorization
	 * */
	function getAuthorizationHeader(){
		//echo "entro a getAuthorizationHeader";
		$headers = null;

		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}
		else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	/**
	 * get access token from header
	 * */
	function getBearerToken() {
		//echo "Entro a getBearerToken";
		$headers = getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	function getHttpStatusMessage($statusCode){
		$httpStatus = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}

function returnData($statusCode, $data){

	// Habilitaando CORS para todos los orígenes Evitar usar *
	header("Access-Control-Allow-Origin: *");

	// Permitir diferentes métodos  (GET, POST, etc.)
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");

	// Permitir diferentes secciones en el encabezado
	header("Access-Control-Allow-Headers: Content-Type, Authorization");

	// Permite usar de credenciales
	header("Access-Control-Allow-Credentials: true");

	// Establecer el tipo de contenido de la respuesta como JSON
	header("Content-Type: application/json");

	http_response_code($statusCode);

	//Escribiendo el log para revisar los mensajes recibidos y los devueltos
	//Escribiendo el dato de entrada
	$method = $_SERVER['REQUEST_METHOD'];
	logFile(date("d/M/Y h:i:s A") );
	logFile('Url: ' . $_SERVER['REQUEST_URI']);
	logFile('Método: ' . $method);
	logFile('Datos de Entrada');
	
	switch ($method) {
		case 'GET':
			logFile($_GET);
		  	break;
		case 'POST':
			logFile($_POST);
		  	break;
		case 'PUT':
			$_PUT = getParameter('PUT');
			logFile($_PUT);
			break;
		case 'DELETE':
			$_DELETE = getParameter('DELETE');
			logFile($_DELETE);
			break;
		  }
	//Escribiendo el dato de salida
	logFile('Datos de Salida');
	logFile('Status: ' . $statusCode);
	logFile($data);
	logFile('----------------------------');

	return json_encode($data);
}

function logFile ($mensajeLog){
	$filename = 'feniciaWS.log';

	if (is_array($mensajeLog)) {
		$mensaje = json_encode($mensajeLog).PHP_EOL;
	} else {
		$mensaje = $mensajeLog.PHP_EOL;
	}
	// Let's make sure the file exists and is writable first.
	if ($fp = fopen($filename, 'a')) {
		// Write $mensaje to our opened file.
		fwrite($fp, $mensaje);
	}	

	fclose($fp);
	

}

if (!function_exists("getParameter")){
    function getParameter($parameter) {
        $value=null;
        if(($_SERVER['REQUEST_METHOD'] == 'POST')&& (isset($_POST[$parameter]))){
            $value=$_POST[$parameter];
        }
        else if(($_SERVER['REQUEST_METHOD'] == 'PUT')&& (isset($GLOBALS["_PUT"]))) {
                $value=$GLOBALS["_PUT"];
        }
        else if(($_SERVER['REQUEST_METHOD'] == 'DELETE')&& (isset($GLOBALS["_DELETE"]))){
            $value=$GLOBALS["_DELETE"];
        }
        else if(($_SERVER['REQUEST_METHOD'] == 'PATCH')&& (isset($GLOBALS["_PATCH"]))){
            $value=$GLOBALS["_PATCH"];
        }
        return $value;
    }
}   

function setGlobal($requestMethod) {
	//if($_SERVER['REQUEST_METHOD'] == 'PUT') {
	if($requestMethod == 'PUT' || $requestMethod == 'DELETE') {
		$form_data= json_encode(file_get_contents("php://input"));
		$key_size=52;
		$key=substr($form_data, 1, $key_size);
		$acc_params=explode($key,$form_data);
		array_shift($acc_params);
		array_pop($acc_params);
		foreach ($acc_params as $item){
			$start_key=' name=\"';
			$end_key='\"\r\n\r\n';
			$start_key_pos=strpos($item,$start_key)+strlen($start_key);
			$end_key_pos=strpos($item,$end_key);
			
			$key=substr($item, $start_key_pos, ($end_key_pos-$start_key_pos));
			
			$end_value='\r\n';
			$value=substr($item, $end_key_pos+strlen($end_key), -strlen($end_value));
			$TEMP[$key]=$value;
		}
		switch ($requestMethod) {
			case 'PUT':
				$GLOBALS["_PUT"]=$TEMP;
				break;
			case 'DELETE':
				$GLOBALS["_DELETE"]=$TEMP;
				break;
		} 
		
	}
}