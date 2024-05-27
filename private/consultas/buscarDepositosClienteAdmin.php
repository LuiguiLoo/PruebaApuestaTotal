<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$idcliente = trim($_POST['idcliente'] ?? 0);
$numerovoucher = trim($_POST['numerovoucher'] ?? '');
$nNumDocuIdentidad = trim($_POST['nNumDocuIdentidad'] ?? '');
$estado_bus = trim($_POST['estado_bus'] ?? '');

$arr_sql = [];
if($numerovoucher!=''){
	$arr_sql[]=" AND d.nrovoucher='$numerovoucher'";
}
if($_SESSION['ApuestaTotal_Tipo']==2){
	$arr_sql[]=" AND d.idcliente = '$idcliente' ";
}
if($nNumDocuIdentidad!=''){
	$arr_sql[]=" AND c.dni='$nNumDocuIdentidad'";
}
if($estado_bus!=''){
	$arr_sql[]=" AND d.estado='$estado_bus'";
}
$sql_cons = implode(' ',$arr_sql);
$query = "SELECT
t.descripcion as tipo_deposito,
b.nombre_banco,
d.monto,
d.fecha,
u.usuario,d.nrovoucher,d.estado,d.iddeposito,c.dni, p.descripcion
FROM deposito d
INNER JOIN tipo_deposito t ON t.idtipo_deposito = d.idtipo_deposito
LEFT JOIN usuario u ON u.idusuario = d.idusuario
INNER JOIN cliente c ON c.idcliente = d.idcliente
INNER JOIN banco b ON b.idbanco = d.idbanco
INNER JOIN plataforma p ON p.idplataforma = d.idplataforma
WHERE d.estado in (1,2)
$sql_cons
ORDER BY d.fecha ASC";
//echo $query;
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
	$html = '<table class="table">
	<thead class="table-dark">
		<tr>
			<th scope="col">#</th>
			<th scope="col">DNI</th>
			<th scope="col">Nro Voucher</th>
			<th scope="col">Fecha del depósito</th>
			<th scope="col">Tipo de depósito</th>
			<th scope="col" align ="right">Monto</th>
			<th scope="col" align ="right">Estado</th>
			<th scope="col">Registrado por</th>
			<th scope="col">Plataforma</th>
			<th scope="col">Editar</th>
		</tr>
	</thead>
	<tbody>';

	$contador = 1;
	$monto_total = $saldoactivo = $saldopendiente = 0;
	$arr_estado[0]='Anulado';
	$arr_estado[1]='Activado';
	$arr_estado[2]='Pendiente';

	while ($row = mysqli_fetch_assoc($result)) {
		$tipo_deposito = trim($row['tipo_deposito']);
		$nombre_banco = trim($row['nombre_banco']);
		$monto = trim($row['monto']);
		$fecha = trim($row['fecha']);
		$usuario = trim($row['usuario']);
		$nrovoucher = trim($row['nrovoucher']);
		

		if (!(empty($nombre_banco))) {
			$nombre_banco = '(' . $nombre_banco . ')';
		}
		$html .= '
		<tr>
          <th scope="row">' . $contador . '</th>
          <th scope="row">' . $row['dni'] . '</th>
          <th scope="row">' . $nrovoucher . '</th>
          <td>' . $fecha . '</td>
          <td>' . $tipo_deposito . $nombre_banco . '</td>
          <td  align ="right">S/ ' . number_format($monto, 2, '.', ',') . '</td>
          <td>' . $arr_estado[$row['estado']] . '</td>
          <td>' . $usuario . '</td>
          <td>' . $row['descripcion'] . '</td>
          <td><a href="#"><i class="fas fa-edit" onclick="editardeposito('.$row['iddeposito'].',\'visualizar\')"></i></a></td>
        </tr>';

        $monto_total = $monto_total + $monto;

		if($row['estado']==1){
			$saldoactivo = $saldoactivo + $monto;
		}
		if($row['estado']==2){
			$saldopendiente = $saldopendiente + $monto;
		}
        $contador++;
	}

	$html .= '</tbody>
	</table>';

	$data = array('estado' => 'ok'
	,'tabla' => $html
	,'saldo' => 'S/ ' .number_format($monto_total, 2, '.', ',')
	,'saldoactivo' => 'S/ ' .number_format($saldoactivo, 2, '.', ',')
	,'saldopendiente' => 'S/ ' .number_format($saldopendiente, 2, '.', ',')
	);
	exit(json_encode($data));
} else {
	$msg = '<div class="alert alert-primary d-flex align-items-center" role="alert">
	  <i class="fas fa-info-circle"> </i>
	  <div>
	    &nbsp; No hay datos por mostrar
	  </div>
	</div>';

	$data = array('estado' => 'ok'
	,'tabla' => $msg
	,'saldo' => '0');
	exit(json_encode($data));
}

?>