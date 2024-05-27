<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$nNumDocuIdentidad = trim($_POST['nNumDocuIdentidad']);
$sTipoDocuIdentidad = trim($_POST['sTipoDocuIdentidad']);

$query = "SELECT * FROM cliente WHERE dni = '$nNumDocuIdentidad'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$idcliente = trim($row['idcliente']);
	$idtipo_documento = trim($row['idtipo_documento']);
	$dni = trim($row['dni']);
	$apellidos = trim($row['apellidos']);
	$nombres = trim($row['nombres']);
	$email = trim($row['email']);
	$telefono = trim($row['telefono']);

	$data = array('estado' => 'ok'
	,'idcliente' => $idcliente
	,'idtipo_documento' => $idtipo_documento
	,'dni' => $dni
	,'apellidos' => $apellidos
	,'nombres' => $nombres
	,'email' => $email
	,'telefono' => $telefono);
	exit(json_encode($data));
} else {
	enviarMsg('error','El cliente no existe en la base de datos.');
}
?>