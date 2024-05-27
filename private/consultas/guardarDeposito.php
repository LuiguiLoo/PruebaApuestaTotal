<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

if($_POST['accion']=='grabar'){
	$idcliente = trim($_POST['idcliente']);
	$idtipo_deposito = trim($_POST['idtipo_deposito']);
	$idbanco = trim($_POST['id_banco']);
	$monto = trim($_POST['nMontoAdepositar']);
	$nrovoucher = trim($_POST['nrovoucher']);
	$idplataforma = trim($_POST['idplataforma']);
	$nrovoucher = str_replace(',', '', $monto);
	$idusuario = $_SESSION['ApuestaTotal_idUsuario'];
	if (esVacio($idcliente)) {
		enviarMsg('error','El sistema no puede detectar al cliente, vuelva a realizar la consulta.');
	}

	if (esVacio($monto)) {
		enviarMsg('error','El sistema no detecta el monto, vuelva a realizar la consulta.');
	}
	if (esVacio($nrovoucher)) {
		enviarMsg('error','El sistema no detecta el voucher, vuelva a realizar la consulta.');
	}

	if (!(is_numeric($monto) & preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $monto))) {
		enviarMsg('error','En monto ingresado no es un número.');
	}

	if($idtipo_deposito != 1){
		$idbanco = '';
	}

	$query = "INSERT INTO deposito (idcliente, idtipo_deposito, idbanco, monto, nrovoucher, idplataforma,estado)
	VALUES ('$idcliente', '$idtipo_deposito', '$idbanco', '$monto','$nrovoucher', '$idplataforma','2')";
	if(mysqli_query($conn, $query)){
		enviarMsg('ok','Depósito guardado exitosamente. Se activará en unos minutos de confirmación');
	} else{
		enviarMsg('error','No se pudo guardar el deposito.' . mysqli_error($conn) );
	}
}else if($_POST['accion']=='editar'){
	$iddeposito = trim($_POST['iddeposito']);
	$idtipo_deposito = trim($_POST['idtipo_deposito']);
	$estado = trim($_POST['estado']);
	$idbanco = trim($_POST['id_banco']);
	$monto = trim($_POST['nMontoAdepositar']);
	$monto = str_replace(',', '', $monto);
	$idusuario = $_SESSION['ApuestaTotal_idUsuario'];

	if (esVacio($monto)) {
		enviarMsg('error','El sistema no detecta el monto, vuelva a realizar la consulta.');
	}
	if (!(is_numeric($monto) & preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $monto))) {
		enviarMsg('error','En monto ingresado no es un número.');
	}

	if($idtipo_deposito != 1){
		$idbanco = '';
	}

	$query = "UPDATE deposito SET idtipo_deposito='$idtipo_deposito', idbanco='$idbanco', monto='$monto', idusuario='$idusuario', estado='$estado' WHERE iddeposito='$iddeposito'";
	//echo $query;exit;
	if(mysqli_query($conn, $query)){
		enviarMsg('ok','Depósito guardado exitosamente');
	} else{
		enviarMsg('error','No se pudo guardar el deposito.' . mysqli_error($conn) );
	}
}else if($_POST['accion']=='visualizar'){
	$iddeposito = $_POST['iddeposito'];

	$query = "SELECT
	t.descripcion as tipo_deposito,
	b.nombre_banco,
	d.monto,
	d.fecha, d.idtipo_deposito,d.nrovoucher,
	d.nrovoucher,d.estado,d.iddeposito,c.nombres, c.apellidos,d.idbanco,c.idplayer,d.estado
	FROM deposito d
	INNER JOIN tipo_deposito t ON t.idtipo_deposito = d.idtipo_deposito
	INNER JOIN cliente c ON c.idcliente	 = d.idcliente	
	LEFT JOIN banco b ON b.idbanco = d.idbanco
	WHERE d.iddeposito='$iddeposito'
	";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);

	$arr_datos = [
				'apellidos'=>$row['apellidos'],
				'nombres'=>$row['nombres'],
				'monto'=>$row['monto'],
				'idtipo_deposito'=>$row['idtipo_deposito'],
				'id_banco'=>$row['idbanco'],
				'nrovoucher'=>$row['nrovoucher'],
				'idplayer'=>$row['idplayer'],
				'estado'=>$row['estado'],
				'accionb'=>'visualizar',
				
	];

	echo json_encode($arr_datos);

}

function esVacio($variable){
	return is_null($variable) || empty($variable) || $variable == 0;
}
?>