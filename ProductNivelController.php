<?php
$GLOBALS['_PUT']=array();
$GLOBALS['_DELETE']=array();
include_once("4p1_core.php");
include_once("ProductNivel.php");
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

		if (empty($_POST['nivel'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro nivel del Producto NO enviado.",
								"code"			=> "400.1"
			);
		} elseif (empty($_POST['codigo'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro codigo del Producto NO enviado.",
								"code"			=> "400.2"
			);
		} elseif (empty($_POST['codbase'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro codigo base Producto NO enviado.",
								"code"			=> "400.3"
			);

		} else {
			$Product 	= new ProductNivel();
			$rawData = $Product->addProductNivel();

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
} // if ($method == 'OPTIONS')
else {
		http_response_code(405);
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "METHOD NOT ALLOWED",
							"message" 	=> "Metodo NO permitido.",
							"code"		=> "405.1"
		);
		echo returnData(405, $respuesta);
}
?>
