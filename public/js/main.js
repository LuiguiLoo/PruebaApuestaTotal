// INICIO DEL DOCUMENT READY
$(document).ready(function() {

	// INICIO FORMATOS INPUT
	$('.money').mask('00,000.00', {reverse: true});
	// FIN FORMATOS INPUT

	// INICIO SELECT TIPO DEPOSITO CHANGE
	$("#idtipo_deposito").change(function () {
		$("#idtipo_deposito option:selected").each(function () {
			idtipo_deposito = $(this).val();
			if (idtipo_deposito == 1) {
				$("#divBancos").show();
			} else if (idtipo_deposito == 2) {
				$("#divBancos").hide();
			}
		});
	});
	// FIN SELECT TIPO DEPOSITO CHANGE

	// INICIO ASIGNAR FORMATO A INPUT
	$("#sTipoDocuIdentidad").change();
	// FIN ASIGNAR FORMATO A INPUT


	// INICIO CONSULTAR CLIENTE
	$("#btnConsultar").click(function () {
		let id_cliente_tmp = 0;
		let nNumDocuIdentidad = $.trim($('#nNumDocuIdentidad').val());
		
		$("#btnConsutar").hide();
		$("#btnConsutarGif").show();
		let datos = $("#frmConsultar").serialize();
		if(nNumDocuIdentidad!=''){
			$.ajax({
				url: '../private/consultas/buscarCliente.php',  
				type: 'POST',
				data:  datos,
				cache: false,
				dataType:'json',
				success: function(data){
					if (data.estado == 'ok') {
						id_cliente_tmp = data.idcliente;
						$('#idcliente').val(data.idcliente);
						$('#idtipo_documento').val(data.idtipo_documento);
						$('#dni').val(data.dni);
						$('#apellidos').val(data.apellidos);
						$('#nombres').val(data.nombres);
						$('#email').val(data.email);
						$('#telefono').val(data.telefono);
						$('#frmDatosCliente select').attr('readonly', 'readonly');
						$('#frmDatosCliente input').attr('readonly', 'readonly');
						buscarDepositosCliente(id_cliente_tmp,'no');						
						$("#rowVentanaDesposito").show();
					} else {
						id_cliente_tmp = 0;
						$('#idcliente').val(data.idcliente);
						alertify.error(data.msg);
						$("#rowVentanaDesposito").hide();
					}
					$("#btnConsutar").show();
					$("#btnConsutarGif").hide();
				},
				error: function() {
					$('#idcliente').val(data.idcliente);
					id_cliente_tmp = 0;
					alert('¡Hubo algún error al realizar la llamada AJAX!');
					$("#btnConsutar").show();
					$("#btnConsutarGif").hide();
				}
			});
		}else{
			$("#rowVentanaDesposito").hide();
		}
		
	});
	// FIN CONSULTAR CLIENTE

	// INICIO CANCELAR DEPOSITO
	$("#btnCancelarDeposito").click(function () {
		$('#modalAgregarDeposito').modal('hide');
		$('#divBancos').hide();
		$("#frmAgregarDeposito")[0].reset()	
	});
	// FIN GUARDAR DEPOSITO


	// INICIO VER MODAL AGREGAR DEPOSITO
	$("#btnModalAgregarDeposito").click(function () { 
		$("#frmAgregarDeposito")[0].reset()	
		$('#divBancos').hide();
		$('#modalAgregarDeposito').modal('show');		
		let idcliente = $("#idcliente").val();
    	let datos = { 'idcliente' : idcliente};
		$.ajax({
			url: '../private/consultas/nombreCliente.php',  
			type: 'POST',
			data:  datos,
			cache: false,
			dataType:'json',
			success: function(data){
				if (data.estado == 'ok') {
					$("#nombre_cliente").val(data.nombre);
					$("#codigo_cliente").val(data.codigo_cliente);
				} else {
					alertify.error(data.msg);
				}
			},
		    error: function() {
		        alert('¡Hubo algún error al realizar la llamada AJAX!');
		    }
		});
		$('#idtipo_deposito').focus();
	});
	// FIN VER MODAL AGREGAR DEPOSITO


	// INICIO ACTUALIZAR TABLA DE DEPOSITOS
	$("#btnActualizarTablaDeposito").click(function () { 
		idcliente = $('#idcliente').val();
		buscarDepositosCliente(idcliente,'si');
	});
	// FIN ACTUALIZAR TABLA DE DEPOSITOS

});
// FIN DEL DOCUMENT READY


function asignarFormatoInput(numDigitos, posee_numeros, posee_letras, claseFormat, inputFormat){
let digitos = '';
if (numDigitos > 1 & numDigitos < 50){
	$(claseFormat).val('');

	for (let i = 0; i < numDigitos; i++) {
	   digitos = digitos + '0';
	}

	if (posee_numeros == 1 & posee_letras == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[A-Za-z0-9]/}}});
	} else if (posee_numeros == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[0-9]/}}});
	} else if (posee_letras == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[A-Za-z]/}}});
	}

	$(claseFormat).focus();
}
}
buscarDepositosCliente($("#idcliente").val(),'no',0);
function buscarDepositosCliente(idcliente, notificar,busqueda=0){
	
	let idtipo_usuario = $("#idtipo_usuario").val() || '';
	let numerovoucher = $("#numerovoucher").val() || '';
	let nNumDocuIdentidad = $("#nNumDocuIdentidad").val() || '';
	let estado_bus = $("#estado_bus").val() || '';
	/* if (numerovoucher =='' && busqueda==1){
		alertify.error('Ingrese algún digito');
		$("#numerovoucher").focus();
		return false;
	} */
	if(idtipo_usuario==1){
		ubicacion = 'buscarDepositosClienteAdmin';
	}else{
		ubicacion = 'buscarDepositosCliente';
	}
	$('#tblDepositos').html('<div class="text-center"><img src="dist/img/loader-icon.gif" alt="Buscando" width="25%"></div>');
	let datos = { 'idcliente' : idcliente, 'numerovoucher':numerovoucher, 'nNumDocuIdentidad':nNumDocuIdentidad, 'estado_bus':estado_bus};
	$.ajax({
		url: '../private/consultas/'+ubicacion+'.php',  
		type: 'POST',
		data:  datos,
		cache: false,
		dataType:'json',
		success: function(data){
			if (data.estado == 'ok') {
				$('#tblDepositos').html(data.tabla);
				$('#lblSaldo').text('Montol total es: ' + data.saldo);
				$('#lblSaldoActivo').text('Montol total de Deposito Activo es: ' + data.saldoactivo);
				$('#lblSaldopendiente').text('Montol total de Deposito Pendiente es: ' + data.saldopendiente);
				if (notificar == 'si') {
					alertify.success('La tabla de depósitos se actualizo correctamente');
				}
				$("#btnConsutarGif").hide();
			} else {
				alertify.error(data.msg);
			}
		},
	    error: function() {
	        alert('¡Hubo algún error al realizar la llamada AJAX!');
	    }
	});
}


function MostrarDatos(valor=0){
	$('#mostrarDatosCliente').css('display','block');
	$('#btnGuardarDeposito').css('display','block');
	$("#idplataforma").val(valor);
}

function editardeposito(id=0,accion=''){
		$('#modalAgregarDeposito').modal('show');
		$("#btnGuardarDeposito").click(function () {
			accion = 'guardar';
		});
	
	if(accion=='editar'){
		let iddeposito = $("#iddeposito").val();
		id = iddeposito;
	}else if (accion=='visualizar'){
		$("#iddeposito").val(id);
	}

	let datos = $("#frmAgregarDeposito").serialize() + '&iddeposito=' + id + '&accion=' + accion;
	$.ajax({
		url: '../private/consultas/guardarDeposito.php',  
		type: 'POST',
		data:  datos,
		cache: false,
		dataType:'json',
		success: function(data){
			if(data.accionb == 'visualizar'){
				$('#nombre_cliente').val(data.apellidos + ' ' + data.nombres);
				$('#id_banco').val(data.id_banco);
				let idtipo_deposito = data.idtipo_deposito;
				$('#idtipo_deposito').val(idtipo_deposito);
				$('#nMontoAdepositar').val(data.monto);
				$('#idplayer').val(data.idplayer);
				$('#nrovoucher').val(data.nrovoucher);
				$('#estado').val(data.estado);

				if (idtipo_deposito == 1) {
					$("#divBancos").show();
				} else if (idtipo_deposito == 2) {
					$("#divBancos").hide();
				}
			}else{
				if (data.estado == 'ok') {
					alertify.success(data.msg);
					$("#btnCancelarDeposito").click();
					buscarDepositosCliente($("#idcliente").val(),'si');
				} else {
					alertify.error(data.msg);
				}
				$("#btnGuardarDeposito").show();
				$("#btnGuardarDepositoGif").hide();
			}
		},
		error: function() {
			alert('¡Hubo algún error al realizar la llamada AJAX!');
			$("#btnGuardarDeposito").show();
			$("#btnGuardarDepositoGif").hide();
		}
	});
}
