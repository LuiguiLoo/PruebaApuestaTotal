<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$idcliente = trim($_POST['idcliente']);

$query = "SELECT idcliente,apellidos,nombres,idplayer FROM cliente WHERE idcliente = '$idcliente'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_assoc($result);
	$nombre = $row['apellidos'] . ' ' . $row['nombres'];

	$data = array('estado' => 'ok','nombre' => $nombre,'codigo_cliente'=>$row['idplayer']);
	exit(json_encode($data));
} else {
	enviarMsg('error','El cliente no existe en la base de datos.');
}

?>