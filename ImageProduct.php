<?php
require_once("dbcontroller.php");
require_once("upload.php");

Class ImageProduct {
	private $imagenesproducto = array();
	private $tabla = 'R_PRODUCTO_IMAGENES';
	private $insert_fields = array();
	private $insert_values = array();
	private $delete_fields = array();
	private $delete_values = array();

	public function addImageProduct(){
		$codigo  = $_POST['codigo'];
		$consecutivo  = $_POST['consecutivo'];

		//Tomando la imagen para procesarla
		$url 			= '';
		$error 		= '';
		$error_code = '';
		if ( upload($url, $error, $error_code) ) {

			$this->insert_fields = array(
				'COD_PRODUCTO'	=> 	'?',
				'CONSECUTIVO'   	=> 	'?',
				'URL'  => 	'?'
			 );

			$this->insert_values = array(
				"'" . $codigo . "'",
				"'" . $consecutivo . "'",
				"'" . $url . "'"
			);

			// Insert record
			$insert_sql = 'INSERT INTO ' . $this->tabla
				. ' ('   . implode(', ', array_keys($this->insert_fields))   . ')'
				. ' VALUES ('    . implode(', ', array_values($this->insert_values)) . ')';

			$dbcontroller = new DBController();
			//echo "Insert SQL: " . $insert_sql . "<br>";
			$result = $dbcontroller->executeQuery($insert_sql, $this->insert_values);
			if($result != 0){
				$result = array("success"	=> true,
												"name" 		=> "CREATED",
								 				"message" => "Imagen de Producto Creado!",
												"url"			=> $url,
								 				"code"		=> "201"
				);
			} else {
				$result = array("success"	=> false,
												"name" 		=> "ERROR",
								 				"message" => "Imagen de Producto NO Creado!",
								 				"code"		=> "500.1"
				);
			}
		} else {
			$result = array("success"	=> false,
											"name" 		=> "ERROR",
											"message" => $error,
											"code"		=> $error_code
			);

		}
		return $result;
	}

	public function delImageProduct($consecutivo, $codigo){

		//Borrando el archivo asociado
		$error = '';
		$error_code = 0;
		$url = '';

		//Consultando la url
		$elemntData =$this->getImageProduct($consecutivo, $codigo)[0];
		$url = $elemntData['URL'];	
		if (delete($url, $error, $error_code) ){
			$this->delete_fields = array(
				'COD_PRODUCTO = (?)',
				'CONSECUTIVO = (?)'
			);

			$this->delete_values = array(
				$codigo,
				$consecutivo 
			);

			// Delete record
			$delete_sql = 'DELETE FROM ' . $this->tabla
				. ' WHERE ' . implode(' AND ', array_values($this->delete_fields)) ;

			$dbcontroller = new DBController();
			$result = $dbcontroller->executeQuery($delete_sql, $this->delete_values);
			if($result != 0){
				$result = array("success"	=> true,
					"name" 		=> "DELETED",
					"message"    => "Imagen de Producto Borrada! Registro Borrado y Archivo Borrado.",
					"url"		=> $url,
					"code"		=> "200.2"
				);
			} else {
				$result = array("success"	=> true,
								"name" 		=> "DELETED/ACEPTED",
								"message" => "Imagen de Producto Parcialmente Borrada! Registro No Borrado y Archivo Borrado.",
								"code"		=> $error_code
				);
			}
		} else {
			$result = array("success"	=> false,
							"name" 		=> "ERROR",
							"message" => "Imagen de Producto NO Borrada! Registro NO Borrado y Archivo NO Borrado. Error:" . $error,
							"code"		=> "500.2"
			);
		}

		return $result;
	}	

	public function getImageProduct($consecutivo, $codigo){
		$query = "SELECT COD_PRODUCTO, CONSECUTIVO, URL 
				   	FROM R_PRODUCTO_IMAGENES rpi  
					WHERE  CONSECUTIVO = ". $consecutivo . " AND COD_PRODUCTO = '" . $codigo . "'";
		//echo "Query en getImageProduct: " . $query . "\n";
		//echo "llamando a l dbcontroller\n";
		$dbcontroller = new DBController();
		//var_dump($dbcontroller);
		$this->imagenesproducto = $dbcontroller->executeSelectQuery($query);
		//echo "despues del llamado\n";
		return $this->imagenesproducto;
	}
}
?>
