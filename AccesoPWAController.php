<?php
include_once("4p1_core.php");
include_once("AccesoPWA.php");
// 2.02.250
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
	$token = getBearerToken();
	$message = '';
	if ( !SessionValidateR2($token, $message) ) {
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "UNAUTHORIZED",
							"message" 	=> "La sesion del Usuario ha expirado. Se requiere un nuevo Token.",
							"code"		=> "401.1"
		);
		echo returnData(401, $respuesta);
		die();
	} else {

		if (empty($_POST['pwaid'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro pwaid NO enviado.",
												"code"			=> "400.1"
			);
/* 		} elseif (empty($_POST['fechahora'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro fecha-hora NO enviado.",
												"code"			=> "400.2"
			); */
		} elseif (empty($_POST['ip'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro IP NO enviado.",
												"code"			=> "400.3"
			);
		} else {
			$AccesoPWA 	= new AccesoPWA();
			$rawData = $AccesoPWA->addAccesoPWA();

			if(empty($rawData)) {
				$statusCode = 500;
			} else {
				$statusCode = 201;
			}
		}
		echo returnData($statusCode, $rawData);
	}
} // if ($method == 'POST')
elseif ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		echo returnData(200, '');
    exit;
} else {
		http_response_code(405);
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "METHOD NOT ALLOWED",
							"message" 	=> "Metodo NO permitido.",
							"code"		=> "405.1"
		);
		echo returnData(405, $respuesta);
}
?>
