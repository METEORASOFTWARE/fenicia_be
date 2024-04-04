<?php
class DBController {
	private $conn = "";
	private $host = "190.242.40.162, 3405";
	private $user = "sa";
	private $password = "General123";
	private $database = "cel823e";

	function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->conn = $conn;
		}
	}

	function connectDB() {
		$connectionInfo = array( "Database"=>$this->database, "UID"=>$this->user, "PWD"=>$this->password, "CharacterSet" => "UTF-8");
		$conn = sqlsrv_connect( $this->host, $connectionInfo);
		if ( $conn === false) {
			http_response_code(503);
			$respuesta = array(	"success" 	=> false,
								"name" 			=> "INTERNAL SERVER ERROR",
								"message" 	=> "No se pudo establecer Conexion a Base de Datos " . $this->host,
								"code"			=> "503.1"
			);
			echo json_encode($respuesta);
			die();
		} else {
			return $conn;
		}
	}

	function executeQuery($query, $values) {

        $conn = $this->connectDB();
				$stmt = sqlsrv_query( $conn, $query, $values);
				if ( $stmt === false ) {
						http_response_code(503);
						$respuesta = array(	"success" 	=> false,
							"name" 			=> "INTERNAL SERVER ERROR",
							"message" 	=> "No se pudo guardar la informacion en la Base de Datos en el servidor " . $this->host . " Db: " . $this->database,
							"code"			=> "503.2",
							"sql_error" => json_encode(sqlsrv_errors())  . " / SQL: " . $query
						);
						sqlsrv_rollback( $conn );
						echo returnData(503, $respuesta);
						die();
				}
				/*echo "SQL: " . $query;
				echo json_encode($values);*/
				$affectedRows = sqlsrv_rows_affected( $stmt);
				sqlsrv_commit( $conn );
				return $affectedRows;
    }

	function executeSelectQuery($query) {
		$result = sqlsrv_query($this->conn,$query);
		if( $result === false ) {
			http_response_code(503);
			$respuesta = array(	"success" 	=> false,
				"name" 		=> "SQL ERROR",
				"message" 	=> "No se pudo realizar la siguiente consulta la informacion en la Base de Datos en el servidor " . $this->host . " Db: " . $this->database,
				"code"		=> "503.3",
				"sql_error" => json_encode(sqlsrv_errors()) . " / SQL: " . $query
			);
			echo returnData(503, $respuesta);
			die();
	   } else {
			while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$resultset[] = $row;
			}
			if(!empty($resultset))
				return $resultset;
		}
	}
}
?>
