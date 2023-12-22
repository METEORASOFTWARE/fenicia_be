<?php
include_once("4p1_core.php");
include_once("GrupoElemento.php");
// 1.23.185 - Nuevo Cambio!
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
		echo json_encode($respuesta);
		die();
	} else {
		$GrupoElemento 	= new GrupoElemento();
		$elemntData 	= $GrupoElemento->getAllGrupoElemento();

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

		http_response_code($statusCode);
		echo json_encode($rawData);
	}
} // if ($method == 'GET')
else {
		http_response_code(405);
		$respuesta = array(	"success" 	=> false,
							"name" 		=> "METHOD NOT ALLOWED",
							"message" 	=> "Metodo NO permitido.",
							"code"		=> "405.1"
		);
		echo json_encode($respuesta);
}


?>
