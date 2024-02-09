<?php
include_once("4p1_core.php");
include_once("ParFenicia.php");
// 1.23.183
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
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
		echo returnData(401, $respuesta);
		die();
	} else {
		//echo "creando el Grupo Elemento<br>";
		$ParFenicia 	= new ParFenicia();
		//echo "Trayendo los datos de la DB Par Fenicia (getParFenicia)<br>";
		$elemntData 	= $ParFenicia->getParFenicia();

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
		echo returnData($statusCode, $rawData);
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
		echo returnData(405, $respuesta);
}
?>
