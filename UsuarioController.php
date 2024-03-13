<?php
include_once("4p1_core.php");
include_once("Usuario.php");
// 2.03.250
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
												"message" 	=> "Parametro codigo del usuario NO enviado.",
												"code"			=> "400.1"
			);
		} elseif (empty($_POST['nombre'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro nombre del usuario NO enviado.",
												"code"			=> "400.3"
			);
		} elseif (empty($_POST['telefono'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro teléfono NO enviado.",
												"code"			=> "400.4"
			);
		} elseif (empty($_POST['email'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro email NO enviado.",
												"code"			=> "400.5"
			);
		} elseif (empty($_POST['pwaid'])) {
			$statusCode = 400;
			$rawData =	array(	"success" 	=> false,
												"name" 			=> "BAD REQUEST",
												"message" 	=> "Parametro pwaid NO enviado.",
												"code"			=> "400.5"
			);
		} else {
			$Usuario 	= new Usuario();
			$rawData = $Usuario->addUsuario();

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
