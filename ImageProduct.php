<?php
require_once("dbcontroller.php");
require_once("upload.php");

Class ImageProduct {
	private $tabla = 'R_PRODUCTO_IMAGENES';
	private $insert_fields = array();
	private $insert_values = array();

	public function addImageProduct(){
		$codigo  = $_POST['codigo'];
		$consecutivo  = $_POST['consecutivo'];

		//Tomando la imagen para procesarla
		$url 			= '';
		$error 		= '';
		$error_code = '';
		if ( upload($url, $error, $error_code) ) {

			$this->insert_fields = array(
				'COD_PRODUCTO'	=> 	'?',
				'CONSECUTIVO'   	=> 	'?',
				'URL'  => 	'?'
			 );

			$this->insert_values = array(
				"'" . $codigo . "'",
				"'" . $consecutivo . "'",
				"'" . $url . "'"
			);

			// Insert record
			$insert_sql = 'INSERT INTO ' . $this->tabla
				. ' ('   . implode(', ', array_keys($this->insert_fields))   . ')'
				. ' VALUES ('    . implode(', ', array_values($this->insert_values)) . ')';

			$dbcontroller = new DBController();
			//echo "Insert SQL: " . $insert_sql . "<br>";
			$result = $dbcontroller->executeQuery($insert_sql, $this->insert_values);
			if($result != 0){
				$result = array("success"	=> true,
												"name" 		=> "CREATED",
								 				"message" => "Imagen de Producto Creado!",
												"url"			=> $url,
								 				"code"		=> "201"
				);
			} else {
				$result = array("success"	=> false,
												"name" 		=> "ERROR",
								 				"message" => "Imagen de Producto NO Creado!",
								 				"code"		=> "500.1"
				);
			}
		} else {
			$result = array("success"	=> false,
											"name" 		=> "ERROR",
											"message" => $error,
											"code"		=> $error_code
			);

		}
		return $result;
	}
}
?>
