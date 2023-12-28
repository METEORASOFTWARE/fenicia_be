<?php
require_once("dbcontroller.php");
// 1.23.185
/* Aqui estuvo Christian
A domain Class to demonstrate RESTful web services
*/
Class GrupoElemento {
	private $grupoelementos = array();
	public function getAllGrupoElemento(){
		$query = "SELECT T_NIVEL.DESC_NIVEL, T_NIVEL.COD_NIVEL
					FROM T_NIVEL
					WHERE T_NIVEL.COD_BASE = 'XA29' and IsNull(T_NIVEL.COD_ANTERIOR,'') <> ''
					ORDER BY T_NIVEL.DESC_NIVEL ASC";
		$dbcontroller = new DBController();
		$this->grupoelementos = $dbcontroller->executeSelectQuery($query);
		return $this->grupoelementos;
	}

}
?>
