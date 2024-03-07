<?php
require_once("dbcontroller.php");
// 1.23.247

Class ClientesPWA {
	private $clientespwa = array();
	public function getAllClientesPWA($PWAid){
		$query = "  SELECT T_CLIENTES.COD_CLIE,  T_CLIENTES.NOM_CLIE, T_CLIENTES.TEL_CLIE, T_CLIENTES.SW_INACTIVO, T_CLIENTES.E_MAIL, T_CLIENTES.PWA_ID 
    			      FROM T_CLIENTES  
			     WHERE T_CLIENTES.PWA_ID = '" . $PWAid . "'";
		
		$dbcontroller = new DBController();
		$this->clientespwa = $dbcontroller->executeSelectQuery($query);
		return $this->clientespwa;
	}

}
?>
