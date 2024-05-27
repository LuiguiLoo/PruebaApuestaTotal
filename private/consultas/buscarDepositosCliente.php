<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$idcliente = trim($_POST['idcliente'] ?? 0);
$numerovoucher = trim($_POST['numerovoucher'] ?? '');

$arr_sql = [];
if($numerovoucher!=''){
	$arr_sql[]=" AND nrovoucher='$numerovoucher'";
}
if($_SESSION['ApuestaTotal_Tipo']==2){
	$arr_sql[]=" AND d.idcliente = '$idcliente' ";
}
$sql_cons = implode(' ',$arr_sql);
$query = "SELECT
t.descripcion as tipo_deposito,
b.nombre_banco,
d.monto,
d.fecha,
d.nrovoucher,d.estado,d.iddeposito
FROM deposito d
INNER JOIN tipo_deposito t ON t.idtipo_deposito = d.idtipo_deposito
LEFT JOIN banco b ON b.idbanco = d.idbanco
WHERE d.estado in (1,2)
$sql_cons
ORDER BY d.fecha ASC";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
	$html = '<table class="table">
	<thead class="table-dark">
		<tr>
			<th scope="col">#</th>
			<th scope="col">Nro Voucher</th>
			<th scope="col">Fecha del depósito</th>
			<th scope="col">Tipo de depósito</th>
			<th scope="col" align ="right">Monto</th>
			<th scope="col" align ="right">Estado</th>
		</tr>
	</thead>
	<tbody>';

	$contador = 1;
	$monto_total = 0;
	$arr_estado[0]='Anulado';
	$arr_estado[1]='Activado';
	$arr_estado[2]='Pendiente';

	while ($row = mysqli_fetch_array($result)) {
		$tipo_deposito = trim($row['tipo_deposito']);
		$nombre_banco = trim($row['nombre_banco']);
		$monto = trim($row['monto']);
		$fecha = trim($row['fecha']);
		$nrovoucher = trim($row['nrovoucher']);
		

		if (!(empty($nombre_banco))) {
			$nombre_banco = '(' . $nombre_banco . ')';
		}
		$html .= '
		<tr>
          <th scope="row">' . $contador . '</th>
          <th scope="row">' . $nrovoucher . '</th>
          <td>' . $fecha . '</td>
          <td>' . $tipo_deposito . $nombre_banco . '</td>
          <td  align ="right">S/ ' . number_format($monto, 2, '.', ',') . '</td>
          <td>' . $arr_estado[$row['estado']] . '</td>
        </tr>';

        $monto_total = $monto_total + $monto;
        $contador++;
	}

	$html .= '</tbody>
	</table>';

	$data = array('estado' => 'ok'
	,'tabla' => $html
	,'saldo' => 'S/ ' .number_format($monto_total, 2, '.', ','));
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