<?php
require_once("dbcontroller.php");
// 1.23.248

Class ImagenesPorElemento {
	private $imagenesporelemento = array();
	public function getAllImagenesPorElemento($elemento){
		$query = "    SELECT R_PRODUCTO_IMAGENES.COD_PRODUCTO,   
							 R_PRODUCTO_IMAGENES.CONSECUTIVO,   
							 R_PRODUCTO_IMAGENES.URL  
						FROM R_PRODUCTO_IMAGENES  
					   WHERE R_PRODUCTO_IMAGENES.COD_PRODUCTO = '" . $elemento . "'";
		$dbcontroller = new DBController();
		$this->imagenesporelemento = $dbcontroller->executeSelectQuery($query);
		return $this->imagenesporelemento;
	}

}
?>