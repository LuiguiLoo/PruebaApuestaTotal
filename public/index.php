<?php
require_once('../private/initialize.php');
$page_title = 'Apuesta Total - Login'; 
include_once(CONEXION_PATH . '/conexion.php');
include(SHARED_PATH . '/header.php');
?>

<link href="<?php echo url_for('/dist/css/signin.css'); ?>" rel="stylesheet">
    
<main class="form-signin map-section">
  <form id="frmIniciarSesion" name="frmIniciarSesion">
    <img class="mb-4" src="<?php echo url_for('/dist/img/logo.png'); ?>" alt="" width="300" height="67">
    <h1 class="h3 mb-3 fw-normal">Inicie Sessión</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" autofocus="">
      <label for="usuario">Usuario / DNI</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
      <label for="contrasena">Contraseña</label>
    </div>

    <div class="row g-3">
      <div class="col-md-6 col-sm-6 col-xs-12">
      <button id="btnIniciarSesion" class="w-100 btn btn-primary" type="button"><i class="fas fa-unlock-alt"></i> Iniciar Sesión</button>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">

      <button id="btnIniciarSesionRegistrar" class="w-100 btn btn-primary" type="button" onclick="CrearUsuario();"><i class="fas fa-unlock-alt"></i> Registrarse</button>
    <button id="btnIniciarSesionGif" class="w-100 btn btn-primary" type="button"  style="display: none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="32px"></button>
      </div>
    </div>
    
    
    <br>
    <br>
    
    <p class="mt-5 mb-3 text-muted">Creado por Luigui Loo &copy; <?php echo date('Y');?></p>
  </form>

</main>

<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="text-align: center;">Agregar Cliente <br> (Recordar que el usuario será el DNI)</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
      <form id="frmDatosCliente" class="row g-3">
						<div class="row g-3">
							<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="idtipo_documento" class="form-label">Tipo de Documento de Identidad</label>
							<select class="form-select" id="idtipo_documento" name="idtipo_documento">
								<?php
								$query = "SELECT idtipo_documento,documento FROM tipo_documento";
								$result = mysqli_query($conn, $query);
								while ($row = mysqli_fetch_assoc($result)) {
								 	echo '<option value="' . $row['idtipo_documento'] . '">' . $row['documento'] . '</option>';
								}
								?>
							</select>
							</div>
              
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="dni" class="form-label">Número de Documento de Identidad</label>
								<input type="text" class="form-control" id="dni" name="dni">
							</div>
							</div>
              <div class="row g-3">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <label for="apellidos" class="form-label">Apellidos</label>
                  <input type="text" class="form-control" id="apellidos" name="apellidos">
                </div>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <label for="nombres" class="form-label">Nombres</label>
                  <input type="text" class="form-control" id="nombres" name="nombres">
                </div>
						</div>
						<div class="row g-3">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="email" class="form-label">Email</label>
								<input type="email" class="form-control" id="email" name="email">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="telefono" class="form-label">Número telefónico</label>
								<input type="text" class="form-control" id="telefono" name="telefono">
							</div>
						</div>
						<div class="row g-3">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="password" class="form-label">Password</label>
								<input type="password" class="form-control" id="password" name="password">
							</div>
						</div>
						
					</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="btnCancelarCliente"><i class="far fa-window-close"></i> Cancelar</button>
				<button type="button" class="btn btn-success" id="btnGuardarCliente"><i class="far fa-save"></i> Guardar Cliente</button>
				<button type="button" class="btn btn-success" id="btnGuardarClienteGif" style="display:none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="24px"> Guardando</button>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH ."/scripts.php"); ?>
<script type="text/javascript" src="js/index.js"></script>
<?php include(SHARED_PATH ."/footer.php"); ?>