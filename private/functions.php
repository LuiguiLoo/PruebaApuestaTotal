<?php

function url_for($script_path='') {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}
// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}


function verificarSesion(){
  if (!(isset($_SESSION['ApuestaTotal_idUsuario']))) {
    redirect_to(url_for('/index.php'));
  }
}

function enviarMsg($estado='', $msg='', $tipo=''){
	$data = array('estado' => $estado
	,'msg' => $msg,'tipo' => $tipo);
	exit(json_encode($data));
}
?>