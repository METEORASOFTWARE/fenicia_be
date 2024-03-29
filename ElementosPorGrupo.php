<?php
require_once("dbcontroller.php");
// 1.23.185

Class ElementosPorGrupo {
	private $elementosporgrupo = array();
	public function getAllElementosPorGrupo($AgrupacionExtra){
		// 1.23.248, cambia el query porque deben salir todos los elementos activos y una sola vez
		$query = "SELECT T_PRODUCTOS.COD_PRODUCTO, T_PRODUCTOS.NOM_PRODUCTO, T_PRODUCTOS.DESC_GONDOLA
					FROM T_PRODUCTOS
				   WHERE SW_INACTIVO='1' AND
					     AGRUPACION_EXTRA  = " . $AgrupacionExtra;
				// $query = "SELECT T_PRODUCTOS.COD_PRODUCTO, T_PRODUCTOS.NOM_PRODUCTO, T_PRODUCTOS.DESC_GONDOLA, R_PRODUCTO_IMAGENES.URL
				//			FROM   R_PRODUCTO_IMAGENES
				//				INNER JOIN T_PRODUCTOS  ON R_PRODUCTO_IMAGENES.COD_PRODUCTO = T_PRODUCTOS.COD_PRODUCTO
				//			 WHERE AGRUPACION_EXTRA  = " . $AgrupacionExtra;
		$dbcontroller = new DBController();
		$this->elementosporgrupo = $dbcontroller->executeSelectQuery($query);
		return $this->elementosporgrupo;
	}

}
?>
