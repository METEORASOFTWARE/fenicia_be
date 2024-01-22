<?php
require_once("dbcontroller.php");
// 1.23.185

Class ElementosPorGrupo {
	private $elementosporgrupo = array();
	public function getAllElementosPorGrupo(){
		$query = "SELECT T_PRODUCTOS.COD_PRODUCTO, T_PRODUCTOS.NOM_PRODUCTO, T_PRODUCTOS.DESC_GONDOLA, R_PRODUCTO_IMAGENES.URL
							FROM   R_PRODUCTO_IMAGENES
								INNER JOIN T_PRODUCTOS  ON R_PRODUCTO_IMAGENES.COD_PRODUCTO = T_PRODUCTOS.COD_PRODUCTO
							WHERE AGRUPACION_EXTRA  = 230";
		$dbcontroller = new DBController();
		$this->elementosporgrupo = $dbcontroller->executeSelectQuery($query);
		return $this->elementosporgrupo;
	}

}
?>
