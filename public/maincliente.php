<?php
require_once('../private/initialize.php');
$page_title = 'Apuesta Total - Intranet'; 
include(SHARED_PATH . '/header.php');
include(SHARED_PATH . '/sidebar.php');
include_once(CONEXION_PATH . '/conexion.php');
?>

<main class="page-content">
	<div class="container">
    	<h4>Recarga</h4>
  		<hr>

	    <div class="row">
			<div class="col-md-12">
				<div class="card card-body">
				<input type="hidden" id="idtipo_usuario" name="idtipo_usuario" value="<?php echo $_SESSION['ApuestaTotal_Tipo']; ?>">

					<form id="frmConsultar">
						<div class="row g-3">
							<div class="col-md-3 col-sm-4 col-xs-12">
								<input type="text" id="numerovoucher" name="numerovoucher" class="form-control maskNumeDocuIdentidad" style="text-transform: uppercase;" placeholder="N° de Voucher" autocomplete="off" autofocus>
								<input type="hidden" id="nNumDigitos" name="nNumDigitos">
							</div>
							<div class="col-md-2 col-sm-4 col-xs-12">
                            <button type="button" id="btnConsultarCliente" name="btnConsultarCliente" class="btn btn-success" onclick="buscarDepositosCliente('<?php echo $_SESSION['ApuestaTotal_idUsuario'] ?? 0; ?>','si',1,2)"><i class="fas fa-search"></i> Consultar</button>
							</div>
                            
							<div class="col-md-3 col-sm-4 col-xs-12">
                            <button type="button" class="btn btn-success" id="btnModalAgregarDeposito" data-bs-toggle="button" autocomplete="off"><i class="fas fa-plus"></i> ¿Necesita Recargar?</button>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
                            <button type="button" class="btn btn-primary" id="btnActualizarTablaDeposito" data-bs-toggle="button" autocomplete="off"><i class="fas fa-sync"></i> Actualizar tabla de recargar</button>
							</div>
							<button type="button" id="btnConsutarGif" name="btnConsutarGif" class="btn btn-success col-4" style="display: none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="32px"></button>
						</div>
					</form>
				</div>
			</div>
            
			<div class="col-md-8">
				<div class="card card-body">
					<form id="frmTransacciones" class="row g-3">
						<div class="table-responsive-sm" id="tblDepositos">
						</div>
						<div class="col-md-12">
						    <label id="lblSaldo" name="lblSaldo" class="form-label" style="font-weight: bold; font-size: 15px;"></label>
						</div>
					</form>
				</div>
			</div>
		</div>

		<br>

		<div class="row" id="rowVentanaDesposito" style="display:none">
			<div class="col-md-12">
				<div class="card card-body">
					<form id="frmDatosCliente" class="row g-3">
						
                            <div class="col-md-12">
                                <div class="card card-body">
                                    <form id="frmTransacciones" class="row g-3">
                                        <div class="col-md-12">
                                            <label id="lblSaldo" name="lblSaldo" class="form-label" style="font-weight: bold; font-size: 15px;"></label>
                                        </div>
                                    </form>
                                </div>
                            </div>
					</form>
				</div>
			</div>
		</div>
	</div>	    
</main>


<div class="modal fade" id="modalAgregarDeposito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar recarga</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="frmAgregarDeposito">
				<input type="hidden" id="idcliente" name="idcliente" value="<?php echo $_SESSION['ApuestaTotal_idUsuario'] ?? 0; ?>">
					<div class="mb-3">
						<input type="hidden" id="idplataforma" name="idplataforma" value="0">
						<label for="nombre_cliente" class="col-form-label">Cliente:</label>
						<input type="text" class="form-control" id="nombre_cliente" readonly>
					</div>
					<div class="mb-3">
						<label for="codigo_cliente" class="col-form-label">Codigo del Cliente:</label>
						<input type="text" class="form-control" id="codigo_cliente" readonly>
					</div>
					<div class="mb-3">
						<label for="codigo_cliente" class="col-form-label">Seleccione una plataforma para comunicarse con el Asesor:</label>
					</div>
					<div class="mb-12 plataforma">
                            <ul>
                            <?php
                                $query = "SELECT idplataforma,icono,descripcion FROM plataforma WHERE estado=1";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li onclick="MostrarDatos('.$row['idplataforma'].');"><a href="#"><i class="'.$row['icono'].'" aria-hidden="true"></i></a>'.$row['descripcion'].'</li>';
                                }
                                ?>
                            </ul>
					</div>
                    <div id="mostrarDatosCliente" style="display: none;">
                        <div class="mb-3">
                            <label for="idtipo_deposito" class="col-form-label">Tipo de recarga:</label>
                            <select class="form-select" id="idtipo_deposito" name="idtipo_deposito">
                                <option value="">Seleccione el tipo de despósito</option>
                                <?php
                                $query = "SELECT * FROM tipo_deposito WHERE estado = 1";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['idtipo_deposito'] . '">' . $row['descripcion'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3" id="divBancos" style="display:none">
                            <label for="id_banco" class="col-form-label">Tipo de banco:</label>
                            <select class="form-select" id="id_banco" name="id_banco">
                                <option value="">Seleccione el banco</option>
                                <?php
                                $query = "SELECT * FROM banco WHERE estado = 1";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['idbanco'] . '">' . $row['nombre_banco'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nrovoucher" class="col-form-label">Nro. Voucher:</label>
                            <input type="text" class="form-control" id="nrovoucher" name="nrovoucher" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="adjuntovoucher" class="col-form-label">Voucher</label>
                            <input type="file" class="form-control" id="adjuntovoucher" name="adjuntovoucher" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="nMontoAdepositar" class="col-form-label">Monto(en soles):</label>
                            <input type="text" class="form-control money" id="nMontoAdepositar" name="nMontoAdepositar" autocomplete="off">
                        </div>
                    </div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="btnCancelarDeposito"><i class="far fa-window-close"></i> Cancelar operación</button>
				<button type="button" class="btn btn-success" id="btnGuardarDeposito" style="display: none;" onclick="editardeposito('','grabar');"><i class="far fa-save"></i> Guardar recarga</button>
				<button type="button" class="btn btn-success" id="btnGuardarDepositoGif" style="display:none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="24px"> Guardando</button>
			</div>
		</div>
	</div>
</div>


<?php include(SHARED_PATH .'/scripts.php'); ?>
<script type="text/javascript" src="js/main.js"></script>
<?php include(SHARED_PATH .'/footer.php'); ?>
