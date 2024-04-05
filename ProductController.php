<?php
$GLOBALS['_PUT']=array();
$GLOBALS['_DELETE']=array();
include_once("4p1_core.php");
include_once("Product.php");
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
		} elseif (empty($_POST['unidad'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro unidad del Producto NO enviado.",
								"code"			=> "400.2"
			);
		} elseif (empty($_POST['nombre'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro nombre del Producto NO enviado.",
								"code"			=> "400.3"
			);
		} elseif (empty($_POST['usuario'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro usuario del Producto NO enviado.",
								"code"			=> "400.4"
			);
		} elseif (empty($_POST['descripcion'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 			=> "BAD REQUEST",
								"message" 	=> "Parametro descripcion del Producto NO enviado.",
								"code"			=> "400.5"
			);
		} else {
			$Product 	= new Product();
			$rawData = $Product->addProduct();

			if(empty($rawData)) {
				$statusCode = 500;
			} else {
				$statusCode = 201;
			}
		}
		echo returnData($statusCode, $rawData);
	}
} // if ($method == 'POST')
elseif ($method == 'PUT') {
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
		setGlobal($method);

		//if (empty($GLOBALS["_PUT"]['codigo'])) {
		if (empty(getVariable('PUT','codigo'))) {			
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 		=> "BAD REQUEST",
								"message" 	=> "Parametro codigo del Producto NO enviado.",
								"code"		=> "400.1"
			);
		} elseif (empty(getVariable('PUT','nombre')) && empty(getVariable('PUT','descripcion')) && empty(getVariable('PUT','unidad')) && empty(getVariable('PUT','agrextra'))) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
								"name" 		=> "BAD REQUEST",
								"message" 	=> "Se debe proporcionar al menos un parámetro adicional para actualizar.",
								"code"		=> "400.2"
			);
		} else {
			$Product 	= new Product();
			//$rawData = $Product->updateProduct($_PUT);
			$rawData = $Product->updateProduct();
			
			if(empty($rawData)) {
				$statusCode = 500;
			} else {
				$statusCode = 200;
			}
		}
		echo returnData($statusCode, $rawData);
	}
} // if ($method == 'PUT')
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
