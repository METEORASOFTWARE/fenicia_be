<?php
require_once("dbcontroller.php");

Class Product {
	private $tabla = 'T_PRODUCTOS';
	private $insert_fields = array();
	private $insert_values = array();
	private $update_fields = array();
	private $update_values = array();

	public function addProduct(){
		$codigo  = $_POST['codigo'];
		$unidad  = $_POST['unidad'];
		$nombre  = $_POST['nombre'];
		$usuario = $_POST['usuario'];
		$descripcion = $_POST['descripcion'];
		$agrextra = $_POST['agrextra'];
		$tipotrueque = $_POST['tipotrueque'];  // 2.03.260

		$this->insert_fields = array(
			'COD_PRODUCTO'	=> 	'?',
			'COD_UNIDAD'   	=> 	'?',
			'NOM_PRODUCTO'  => 	'?',
			'SW_INACTIVO'  	=> 	'?',
			'COD_CLIE' 			=> 	'?',
			'TIPOI' 				=> 	'?',
			'AGRUPACION_EXTRA' 	=> 	'?',
			'DESC_GONDOLA' 	=> 	'?',
			'SW_INV_SERIALIZADO' 	=> 	'?'
		 );

		$this->insert_values = array(
			"'" . $codigo . "'",
			"'" . $unidad . "'",
			"'" . $nombre . "'",
			0,
			 "'" . $usuario . "'",
			 "'A29'",
			 "'" . $agrextra . "'",
			 "'" . $descripcion . "'",
			 "'" . $tipotrueque . "'"
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
							"message" 	=> "Producto Creado!",
							"code"		=> "201"
			);
		} else {
			$result = array("success"	=> false,
							"name" 		=> "ERROR",
							"message" 	=> "Producto NO Creado!",
							"code"		=> "500.1"
			);
		}
		return $result;
	}

	public function updateProduct(){
		$_PUT = getParameter('PUT');
		$codigo= $_PUT['codigo'];
		if (!empty($_PUT['nombre'])) {
			array_push($this->update_fields, "NOM_PRODUCTO = (?)");
			array_push($this->update_values, $_PUT['nombre']);
		}
		
		if (!empty($_PUT['descripcion'])) {
			array_push($this->update_fields, "DESC_GONDOLA = (?)");
			//array_push($this->update_values, mb_convert_encoding($_PUT['descripcion'], 'UTF-8', 'Windows-1252'));
			array_push($this->update_values, $_PUT['descripcion']);
		}
		
		if (!empty($_PUT['unidad'])) {
			array_push($this->update_fields, "COD_UNIDAD = (?)");
			array_push($this->update_values, $_PUT['unidad']);
		}
		
		if (!empty($_PUT['agrextra'])) {
			array_push($this->update_fields, "AGRUPACION_EXTRA = (?)");
			array_push($this->update_values, $_PUT['agrextra']);
		}
		// 2.02.261+
		if (!empty($_PUT['tipotrueque'])) {
			array_push($this->update_fields, "SW_INV_SERIALIZADO = (?)");
			array_push($this->update_values, $_PUT['tipotrueque']);
		}

		// Query para actualizar el producto en la base de datos
		$update_sql = "UPDATE " . $this->tabla . " SET " . implode(", ", $this->update_fields) . " WHERE COD_PRODUCTO = (?)";
		
		array_push($this->update_values, $codigo);
		/*var_dump($this->update_fields);
		var_dump($this->update_values);
		echo "Update SQL: " . $update_sql;		*/
		$dbcontroller = new DBController();
		$result = $dbcontroller->executeQuery($update_sql, $this->update_values);
		if($result != 0){
			$result = array("success"	=> true,
							"name" 		=> "UPDATED",
							"message" 	=> "Producto Actualizado!",
							"code"		=> "200.1"
			);
		} else {
			$result = array("success"	=> false,
							"name" 		=> "ERROR",
							"message" 	=> "Producto NO Actualizado!",
							"code"		=> "500.1"
			);
		}
		return $result;
	}
}
?>
