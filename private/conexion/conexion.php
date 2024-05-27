<?php
$server = "localhost";
$user = "root";
$pass = "";
$name = "apuestatotal";

$conn = mysqli_connect($server, $user, $pass, $name);

if (!$conn) {
$data = array('estado' => 'error'
,'msg' => "Error: No se pudo conectar a MySQL." . PHP_EOL . "errno de depuración: " . mysqli_connect_errno() . PHP_EOL . "error de depuración: " . mysqli_connect_error() . PHP_EOL);
exit(json_encode($data));
}

if (!mysqli_set_charset($conn, "utf8")) {
    $data = array('estado' => 'error'
	,'msg' => "Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($conn));
	exit(json_encode($data));
}
?>