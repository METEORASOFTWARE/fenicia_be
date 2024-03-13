<?php
require_once("dbcontroller.php");

Class Usuario {
	private $tabla = 'T_CLIENTES';
	private $insert_fields = array();
	private $insert_values = array();

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
//			'FECHA_CREACION' 	=> 	'?',
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
//			 "03/13/2024 16:00:00",
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

}
?>
