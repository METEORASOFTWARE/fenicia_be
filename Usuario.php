<?php
require_once("dbcontroller.php");

Class Usuario {
	private $tabla = 'T_CLIENTES';
	private $insert_fields = array();
	private $insert_values = array();
	private $update_fields = array();
	private $update_values = array();
	
	public function addUsuario(){
		$codigo  = $_POST['codigo'];
		$nombre  = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$email = $_POST['email'];
		$pwaid = $_POST['pwaid'];

		$this->insert_fields = array(
			'COD_CLIE'	=> 	'?',
			'NOM_CLIE'  => 	'?',
			'COD_CIUDAD' 	=> 	'?',
			'COD_MACROCLIE' 	=> 	'?',
			'SW_INACTIVO'  	=> 	'?',
			'TIPO_CLIENTE' 	=> 	'?',
			'CELULAR' 			=> 	'?',
			'E_MAIL' 			=> 	'?',
			'FECHA_CREACION' 	=> 	'?',
			'COD_SUCURSAL' 	    => 	'?',
			'PWA_ID' 	=> 	'?',
		 );

		$this->insert_values = array(
			"'" . $codigo . "'",
			"'" . $nombre . "'",
            "'OTRA'",
            "'MCLI'",			
			0,
			"'F'",
			 "'" . $telefono . "'",
			 "'" . $email . "'",
			'getdate()',
			 "'PPAL'",
			 "'" . $pwaid . "'"
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
							 				"message" => "Usuario Creado!",
							 				"code"		=> "201"
			);
		} else {
			$result = array("success"	=> false,
											"name" 		=> "ERROR",
							 				"message" => "Usuario NO Creado!",
							 				"code"		=> "500.1"
			);
		}
		return $result;
	}


	public function updateUsuario(){
		$_PUT = getParameter('PUT');
		$codigo= $_PUT['codigo'];
		if (!empty($_PUT['pwaid'])) {
			array_push($this->update_fields, "PWA_ID = ?");
			array_push($this->update_values, $_PUT['pwaid']);
		}
		
		// Query para actualizar el producto en la base de datos
		$update_sql = "UPDATE " . $this->tabla . " SET " . implode(", ", $this->update_fields) . " WHERE COD_CLIE = ?";
		
		array_push($this->update_values, $codigo);
	
		$dbcontroller = new DBController();
		$result = $dbcontroller->executeQuery($update_sql, $this->update_values);
		if($result != 0){
			$result = array("success"	=> true,
							"name" 		=> "UPDATED",
							"message" 	=> "Usuario Actualizado!",
							"code"		=> "204.1"
			);
		} else {
			$result = array("success"	=> false,
							"name" 		=> "ERROR",
							"message" 	=> "Usuario NO Actualizado!",
							"code"		=> "500.1"
			);
		}
		return $result;
	}
}
?>
