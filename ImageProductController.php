<?php
include_once("4p1_core.php");
include_once("ImageProduct.php");
// get the HTTP method, path and body of the request
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

		if (empty($_POST['codigo'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro codigo del Producto NO enviado.",
												"code"			=> "400.1"
			);
		} elseif (empty($_POST['consecutivo'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro consecutivo NO enviado.",
												"code"			=> "400.2"
			);
		} elseif (empty($_FILES["imagen"])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro imagen del Producto NO enviado.",
												"code"			=> "400.3"
			);
		} else {
			$ImageProduct 	= new ImageProduct();
			$rawData = $ImageProduct->addImageProduct();

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
