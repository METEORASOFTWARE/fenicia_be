<?php
require_once("ParFenicia.php");

function upload(&$url, &$error, &$error_code){
  //$img_file = $_FILES["imagen"];

  //Modificación manejando base64
  $image_parts = explode(";base64,", $_POST['imagen']);
  $image_type_aux = explode("image/", $image_parts[0]);
  
  $img_file = base64_decode($image_parts[1]);

  //var_dump($img_file);
  $error  = '';
  $url    = '';
  $return = false;
  $directorio =  '/var/www/html/imagenes/';
  if (!isset($img_file)) {
    $error = 'No se subió ningún archivo!';
    $error_code = "400.4";
    //die('No se subió ningún archivo!');
  } else {

    // Validando q tenga un tamaño
    if (filesize($img_file["tmp_name"]) <= 0) {
      $error = 'El archivo subido está vacío!';
      $error_code = "400.5";
      //die('El archivo subido está vacío!');
    } else {

      // Validando tipo
      //$img_type = exif_imagetype($img_file["tmp_name"]);
      $img_type = $image_type_aux[1];
      if (!$img_type) {
        $error = 'El archivo subido NO es una imagen.';
        $error_code = "400.6";
        //die('El archivo subido NO es una imagen.');
      } else {

        $image_extension = image_type_to_extension($img_type, true);
        $image_name = bin2hex(random_bytes(16)) . $image_extension;
        $image_new_file = $directorio . $image_name;
        // Moviendo el archivo
        if ( move_uploaded_file( $img_file["tmp_name"],  $image_new_file) === true ) {
          $ParFenicia 	= new ParFenicia();
      		$elemntData 	= $ParFenicia->getParFenicia();
          $url_web = $elemntData[0]["A29_URL_IMG"];
          //Acomodando la url web
          $url_web = trim($url_web," ");
          ( substr($url_web, strlen($url_web)-1,1) == "/" ? $url_web : $url_web . "/" );
          //$url  = "Archivo almacenado en " . __DIR__ . "/images/" . $image_name;
          $url    = $url_web .  $image_name;
          $return = true;
        } else {
          $error = 'Errol al intentar copiar el archivo!<br>';
          $error_code = "400.7";
        }
      }
    }
  }
  return $return;
}
