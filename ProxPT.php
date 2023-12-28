<?php
require_once("dbcontroller.php");
// 1.23.195
/* 
A domain Class to demonstrate RESTful web services
*/
Class ProxPT {
	private $proxpt = array();
	public function getProxPT(){
		$query = "SELECT MAX (CAST(substring(T_PRODUCTOS.COD_PRODUCTO,4,7) as INT)) + 1			
   				 FROM T_PRODUCTOS  
				WHERE T_PRODUCTOS.COD_PRODUCTO LIKE 'FE-%'";
		//
		$dbcontroller = new DBController();
		$this->proxpt = $dbcontroller->executeSelectQuery($query);
		return $this->proxpt;
	}
	
}
?>
