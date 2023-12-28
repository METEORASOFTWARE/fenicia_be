<?php
	ini_set("include_path", '/usr/share/pear:' . ini_get("include_path") );

	/* Funciones Propias de la API */
	function SessionValidateR2($token, &$message) {
	  //echo "Entro a SessionValidateR2";
	  require_once 'HTTP/Request2.php';
	  $request = new HTTP_Request2();
	  //$request->setUrl('http://206.189.189.123:8080/admin/realms/4p1/users/3e8f3e80-ba67-4cb5-95da-bd6ff573f7e1/sessions');
	  $request->setUrl('http://fenicia.meteoracolombia.co:8080/admin/realms/meteora/users/7fecb76b-198c-4f75-8003-aac34daafa50/sessions');
	  $request->setMethod(HTTP_Request2::METHOD_GET);
	  $request->setConfig(array(
		'follow_redirects' => TRUE
	  ));
	  $request->setHeader(array(
		'Authorization' => 'Bearer ' . $token
	  ));
	  try {
		$response = $request->send();
		if ($response->getStatus() == 200) {
		  $message = 'Ok';
		  return true;
		}
		else {
		  $message =  'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
		  return false;
		}
	  }
	  catch(HTTP_Request2_Exception $e) {
		$message =  'Error: ' . $e->getMessage();
		return false;
	  }
	 return false;
	}

	function SessionValidateCurl($token, &$message) {
	/*  $curl = curl_init();

	  curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://206.189.189.123:8080/admin/realms/4p1/users/3e8f3e80-ba67-4cb5-95da-bd6ff573f7e1/sessions',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
		  'Authorization: Bearer ' . $token
		),
	  ));

	  $response = curl_exec($curl);

	  curl_close($curl);
	  echo $response;*/
	  return false;
	}

	/**
	 * Get hearder Authorization
	 * */
	function getAuthorizationHeader(){
		//echo "entro a getAuthorizationHeader";
		$headers = null;

		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}
		else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	/**
	 * get access token from header
	 * */
	function getBearerToken() {
		//echo "Entro a getBearerToken";
		$headers = getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}
