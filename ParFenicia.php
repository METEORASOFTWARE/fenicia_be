<?php
require_once("dbcontroller.php");
// 1.23.183

Class ParFenicia {
	private $parfenicia = array();
	public function getParFenicia(){
		//echo "entro a getParFenicia";
		$query = "SELECT T_MANT3.LLAVE,
					T_MANT3.A29_PRE,
					T_MANT3.A29_AGREXTRA_DFLT,
					T_MANT3.A29_CIUDAD_DFLT,
					T_MANT3.A29_URL_IMG
				FROM T_MANT3";
		//1.23.188 +URL
		$dbcontroller = new DBController();
		$this->parfenicia = $dbcontroller->executeSelectQuery($query);
		return $this->parfenicia;
	}

}
?>
