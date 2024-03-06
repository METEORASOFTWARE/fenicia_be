<?php
require_once("dbcontroller.php");
// 1.23.248
Class ProxCL {
	private $proxcl = array();
	public function getProxCL(){
		$query = "SELECT MAX (CAST(substring(T_CLIENTES.COD_CLIE,4,7) as INT)) + 1			
   				 FROM T_CLIENTES  
				WHERE T_CLIENTES.COD_CLIE LIKE 'FE-%'";
		//
		$dbcontroller = new DBController();
		$this->proxcl = $dbcontroller->executeSelectQuery($query);
		return $this->proxcl;
	}
	
}
?>
