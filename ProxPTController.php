<?php
include_once("4p1_core.php");
include_once("ProxPT.php");
// 1.23.195
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
//echo "Metodo: " . $method;
//$ipaddress = get_client_ip();
//echo "method: " . $method;
if ($method == 'GET') {
	$token = getBearerToken();
	$message = '';
	if ( !SessionValidateR2($token, $message) ) {
		http_response_code(401);
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "UNAUTHORIZED",
							"message" 	=> "La sesion del Usuario ha expirado. Se requiere un nuevo Token.",
							"code"		=> "401.1"
		);
		// 1.23.234
		echo returnData(401, $respuesta);
		//echo json_encode($respuesta);
		die();
	} else {
		$ProxPT 	= new ProxPT();
		$elemntData 	= $ProxPT ->getProxPT();

		if(empty($elemntData)) {
			$statusCode = 404;
			$rawData 	= array("success" 	=> false,
								"name" 		=> "Datos No Encontrados",
								"code"		=> "404.2"
			);
		} else {
			$statusCode = 200;
			$rawData = array("success" 	=> true,
							 "name" 	=> "OK",
							 "data" 	=> $elemntData,
							 "code"		=> "200"
			);
		}
		// 1.23.234
		echo returnData($statusCode, $rawData);
		//http_response_code($statusCode);
		//echo json_encode($rawData);
	}
} // if ($method == 'GET')
elseif ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		echo returnData(200, '');
  	exit;
}else {
		http_response_code(405);
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "METHOD NOT ALLOWED",
							"message" 	=> "Metodo NO permitido.",
							"code"		=> "405.1"
		);
		// 1.23.234
		echo returnData(405, $respuesta);
		//echo json_encode($respuesta);
}


?>
