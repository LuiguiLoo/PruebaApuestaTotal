<?php
require_once('../initialize.php');
$usuario = trim($_POST['usuario']);
$clave = trim($_POST['contrasena']);

if( empty($usuario) OR empty($clave) ){
	enviarMsg('error','Ingrese el usuario o la contraseña.');
} else {
	include_once(CONEXION_PATH . '/conexion.php');
	// $contrasena = md5($usuario.$clave);
	$contrasena = $clave;

	$query = "SELECT * FROM usuario WHERE usuario = '$usuario'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$contrasenaResult = trim($row['password']);
		$estado = $row['estado'];
		$idusuario = $row['idusuario'];
		$nombre = $row['nombre'];
		$cargo = $row['cargo'];
		if ($contrasenaResult != $contrasena) {
			enviarMsg('error','Contraseña incorrecta.');
		} else if ($estado != 1) {
			enviarMsg('error','El usuario se encuentra deshabilitado.');
		} else {
			$_SESSION['ApuestaTotal_idUsuario'] = $idusuario;
			$_SESSION['ApuestaTotal_nombre'] = $nombre;
			$_SESSION['ApuestaTotal_cargo'] = $cargo;
			$_SESSION['ApuestaTotal_Tipo'] = 1;

			enviarMsg('ok','Inicio de sesión correcto.',1);
		}		
	} else {
		$query_cli = "SELECT idcliente,password,estado,nombres,apellidos FROM cliente WHERE dni = '$usuario' and password='$contrasena'";
		//echo $query_cli;
		$result_cli = mysqli_query($conn, $query_cli);
		if (mysqli_num_rows($result_cli) == 1) {
			$row_cli = mysqli_fetch_assoc($result_cli);
			$contrasenaResult = trim($row_cli['password']);
			$estado = $row_cli['estado'];
			$idcliente = $row_cli['idcliente'];
			$apellidos = $row_cli['apellidos'];
			$nombres = $row_cli['nombres'];
			if ($contrasenaResult != $contrasena) {
				enviarMsg('error','Contraseña incorrecta.');
			} else if ($estado != 1) {
				enviarMsg('error','El usuario se encuentra deshabilitado.');
			} else {
				$_SESSION['ApuestaTotal_idUsuario'] = $idcliente;
				$_SESSION['ApuestaTotal_nombre'] = $apellidos.' '.$nombres;
				$_SESSION['ApuestaTotal_Tipo'] = 2;
	
				enviarMsg('ok','Inicio de sesión correcto.',2);
			}
		}else{
			enviarMsg('error','Datos Incorrectos');
		}
	}
}

?>