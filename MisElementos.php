<?php
require_once("dbcontroller.php");
// 1.23.248

Class MisElementos {
	private $miselementos = array();
	public function getAllMisElementos($propietario){
		$query = "  SELECT T_PRODUCTOS.COD_PRODUCTO,  T_PRODUCTOS.NOM_PRODUCTO, 
					T_PRODUCTOS.AGRUPACION_EXTRA, T_PRODUCTOS.SW_INACTIVO, T_NIVEL.DESC_NIVEL
    			      FROM T_PRODUCTOS  , T_NIVEL
			     WHERE  T_PRODUCTOS.AGRUPACION_EXTRA = T_NIVEL.COD_NIVEL AND
                        T_PRODUCTOS.COD_CLIE = '" . $propietario . "'";
		
		$dbcontroller = new DBController();
		$this->miselementos = $dbcontroller->executeSelectQuery($query);
		return $this->miselementos;
	}

}
?>