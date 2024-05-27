<?php 
include_once('../conexion/conexion.php');
require_once('../functions.php');

session_start();
$dni = trim($_POST['dni']);
$idtipo_documento = trim($_POST['idtipo_documento']);
$apellidos = trim($_POST['apellidos']);
$nombres = trim($_POST['nombres']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$password = trim($_POST['password']);
$idplayer = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

if ($dni=='') {
	enviarMsg('error','Por favor ingrese DNI.');
}
if ($apellidos=='') {
	enviarMsg('error','Por favor ingrese Apellidos.');
}
if ($nombres=='') {
	enviarMsg('error','Por favor ingrese Nombres.');
}
if ($password=='') {
	enviarMsg('error','Por favor ingrese Passowrd.');
}


$query = "INSERT INTO cliente (idtipo_documento,dni,apellidos,nombres,email,telefono,password,idplayer)
VALUES ('$idtipo_documento', '$dni', '$apellidos', '$nombres','$email', '$telefono','$password','$idplayer')";
if(mysqli_query($conn, $query)){
	$idcliente = mysqli_insert_id($conn);
	$_SESSION['ApuestaTotal_idUsuario'] = $idcliente;
	$_SESSION['ApuestaTotal_nombre'] = $apellidos.' '.$nombres;
	$_SESSION['ApuestaTotal_Tipo'] = 2;
	enviarMsg('ok','Registro guardado satisfactoriamente');
	

} else{
	enviarMsg('error','No se pudo guardar.' . mysqli_error($conn) );
}
