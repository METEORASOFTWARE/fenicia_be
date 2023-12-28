<?php
require_once("dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Product {
	private $tabla = 'T_PRODUCTOS';
	private $insert_fields = array();
	private $insert_values = array();

	public function addProduct(){
		$codigo  = $_POST['codigo'];
		$unidad  = $_POST['unidad'];
		$nombre  = $_POST['nombre'];
		$usuario = $_POST['usuario'];
		$descripcion = $_POST['descripcion'];

		$this->insert_fields = array(
			'COD_PRODUCTO'	=> 	'?',
			'COD_UNIDAD'   	=> 	'?',
			'NOM_PRODUCTO'  => 	'?',
			'SW_INACTIVO'  	=> 	'?',
			'COD_CLIE' 			=> 	'?',
			'TIPOI' 				=> 	'?',
			'AGRUPACION_EXTRA' 	=> 	'?',
			'DESC_GONDOLA' 	=> 	'?'
		 );

		$this->insert_values = array(
			"'" . $codigo . "'",
			"'" . $unidad . "'",
			"'" . $nombre . "'",
			0,
			 "'" . $usuario . "'",
			 "'A29'",
			 224,
			 "'" . $descripcion . "'"
		);

		// Insert record
		$insert_sql = 'INSERT INTO ' . $this->tabla
			. ' ('   . implode(', ', array_keys($this->insert_fields))   . ')'
			. ' VALUES ('    . implode(', ', array_values($this->insert_values)) . ')';

		$dbcontroller = new DBController();
		$result = $dbcontroller->executeQuery($insert_sql, $this->insert_values);
		if($result != 0){
			$result = array("success"	=> true,
											"name" 		=> "CREATED",
							 				"message" => "Producto Creado!",
							 				"code"		=> "201"
			);
		} else {
			$result = array("success"	=> false,
											"name" 		=> "ERROR",
							 				"message" => "Producto NO Creado!",
							 				"code"		=> "500.1"
			);
		}
		return $result;
	}

}
?>
