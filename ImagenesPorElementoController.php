<?php
include_once("4p1_core.php");
include_once("ImagenesPorElemento.php");
// 1.23.248
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
	$token = getBearerToken();
	$message = '';
	$elemento   = $_GET["elemento"];
	if (!isset($elemento)) {
		http_response_code(400);
		$respuesta = array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro elemento NO enviado.",
												"code"			=> "400.1"
								);
		echo returnData(400, $respuesta);
		die();
	} elseif ( !SessionValidateR2($token, $message) ) {
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "UNAUTHORIZED",
							"message" 	=> "La sesion del Usuario ha expirado. Se requiere un nuevo Token. O hubo error en el llamado. Error:". $message,
							"code"		=> "401.1"
		);
		echo returnData(401, $respuesta);
		die();
	} else {
		$ImagenesPorElemento 	= new ImagenesPorElemento();
		$elemntData 	= $ImagenesPorElemento->getAllImagenesPorElemento($elemento);

		if(empty($elemntData)) {
			$statusCode = 404;
			$rawData 	= array("success" 	=> false,
								"name" 		=> "Sin imágenes asociadas",
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
}
else {
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "METHOD NOT ALLOWED",
							"message" 	=> "Metodo NO permitido.",
							"code"		=> "405.1"
		);
		echo returnData(405, $respuesta);
}
?>
