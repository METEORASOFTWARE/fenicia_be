<?php
require_once("dbcontroller.php");

Class AccesoPWA {
	private $tabla = 'T_ACCESOS_PWA';
	private $insert_fields = array();
	private $insert_values = array();

	public function addAccesoPWA(){
		$pwaid  	= $_POST['pwaid'];
		// $fechahora  = $_POST['fechahora'];
		$ip 		= $_POST['ip'];
		$usuario	= $_POST['usuario'];
		

		$this->insert_fields = array(
			'PWA_ID'	=> 	'?',
			// 'FECHA_HORA'   	=> 	'?',
			'IP'  => 	'?',
			'USUARIO'  	=> 	'?'
		 );

		$this->insert_values = array(
			"'" . $pwaid . "'",
			// "'" . $fechahora . "'",
			"'" . $ip . "'",
			"'" . $usuario . "'"
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
							 				"message" => "Acceso Registrado!",
							 				"code"		=> "201"
			);
		} else {
			$result = array("success"	=> false,
											"name" 		=> "ERROR",
							 				"message" => "Acceso no registrado!",
							 				"code"		=> "500.1"
			);
		}
		return $result;
	}

}
?>
