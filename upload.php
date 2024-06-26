<?php
require_once("ParFenicia.php");
define("DIRECTORIO_IMAGENES", '/var/www/html/imagenes/');

function delete($url, &$error, &$error_code){
  $error  = '';
  $return = false;
  if ($url === false || strlen($url) === 0) {
    $error = 'La url está vacía. No se pudo borrar el archivo.';
    $error_code = "500.10";
  } else {

    $elements =explode("/",$url);
    $ultimo = count($elements) - 1;
    $name_image_file = DIRECTORIO_IMAGENES . trim($elements[$ultimo]);

    //Borrando el archivo
    if (!unlink($name_image_file)) {
      $error = 'No se pudo borrar el archivo ' . $name_image_file . '!';
      $error_code = "500.11";
    } else {
        $return = true;
    }   
  }
  return $return;
}

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
  $directorio =  DIRECTORIO_IMAGENES;
  if ($img_file === false) {
    $error = 'La cadena NO es un dato Base64.';
    $error_code = "500.4";
  } else {
    if (!isset($img_file)) {
      $error = 'No se subió ningún archivo!';
      $error_code = "500.5";
    } else {

      // Validando q tenga un tamaño
      if (strlen($image_parts[1]) == 0) {
        $error = 'El archivo subido está vacío!';
        $error_code = "500.6";
      } else {

        // Validando tipo
        $img_type = $image_type_aux[1];
        if (!ValidateImage($img_type)) {  
        //if (!$img_type) {
          $error = 'El archivo subido NO es una imagen.';
          $error_code = "500.7";
          //die('El archivo subido NO es una imagen.');
        } else {

          $image_extension = image_type_to_extension($img_type, true);
          $image_name = bin2hex(random_bytes(16)) . $image_extension;
          $image_new_file = $directorio . $image_name;

          //Granado el archivo
          if (!$fp = fopen($image_new_file, 'w')) {
            $error =  "Error al intentar abrir el archivo (" . $image_new_file . "). Revisar permisos en la carpeta destino!";
            $error_code = "500.8";
          } else {
            if (fwrite($fp, $img_file) === FALSE) {
              $error = "Error al intentar guardar el archivo (" . $image_new_file . "). Revisar permisos en la carpeta destino!";
              $error_code = "500.9";
            } else {
              // Moviendo el archivo
              $ParFenicia 	= new ParFenicia();
              $elemntData 	= $ParFenicia->getParFenicia();
              $url_web = $elemntData[0]["A29_URL_IMG"];
              //Acomodando la url web
              $url_web = trim($url_web," ");
              ( substr($url_web, strlen($url_web)-1,1) == "/" ? $url_web : $url_web . "/" );
              //$url  = "Archivo almacenado en " . __DIR__ . "/images/" . $image_name;
              $url    = $url_web .  $image_name;
              fclose($fp);
              $return = true;
            } 
          }
        }
      }
    }
    return $return;
  }
}

function ValidateImage($data){
  $validExtensions = ['png', 'jpeg', 'jpg', 'gif'];

  if (!in_array(strtolower($data), $validExtensions)) {
      return false;
  } else {
    return true;
  }
}