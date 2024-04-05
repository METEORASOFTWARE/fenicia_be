<?php
require_once("dbcontroller.php");

Class ProductNivel {
	private $tabla = 'R_PRODUCTO_NIVEL';
	private $insert_fields = array();
	private $insert_values = array();

	public function addProductNivel(){
		$nivel  = $_POST['nivel'];
		$codigo  = $_POST['codigo'];
		$codbase  = $_POST['codbase'];

		$this->insert_fields = array(
			'COD_NIVEL'   	=> 	'?',
			'COD_PRODUCTO'	=> 	'?',
			'COD_BASE'  => 	'?',
		 );

		$this->insert_values = array(
			"'" . $nivel . "'",
			"'" . $codigo . "'",
			 "'XA29'",
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
							"message" 	=> "Categoría Producto Creada!",
							"code"		=> "201"
			);
		} else {
			$result = array("success"	=> false,
							"name" 		=> "ERROR",
							"message" 	=> "Categoría Producto NO Creado!",
							"code"		=> "500.1"
			);
		}
		return $result;
	}
}
?>