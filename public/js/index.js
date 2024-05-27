// INICIO DEL DOCUMENT READY
$(document).ready(function() {

	// INICIO INICIAR SESION
	$("#btnIniciarSesion").click(function () {
		var usuario = $('#usuario').val().trim();
		var contrasena = $('#contrasena').val().trim();
		if(usuario == ''){ alertify.error('Debe de ingresar el usuario'); $("#usuario").focus();} else
		if(contrasena == ''){ alertify.error('Debe de ingresar la contraseña'); $("#contrasena").focus();} else
		{
			$("#btnIniciarSesion").hide();
	    	$("#btnIniciarSesionGif").show();
	    	var datos = $("#frmIniciarSesion").serialize();
			$.ajax({
				url: '../private/consultas/login.php',  
				type: 'POST',
				data:  datos,
				cache: false,
				dataType:'json',
				success: function(data){
					if (data.estado == 'ok') {
						if (data.tipo == 1) {
							window.location.replace("main.php");
						}else if (data.tipo == 2) {
							window.location.replace("maincliente.php");
						}else{
							alertify.error('Error!!!');
						}
						
					} else {
						alertify.error(data.msg);
					}
					$("#btnIniciarSesion").show();
	    			$("#btnIniciarSesionGif").hide();
				},
			    error: function() {
			        alert('¡Hubo algún error al realizar la llamada AJAX!');
			        $("#btnIniciarSesion").show();
	    			$("#btnIniciarSesionGif").hide();
			    }
			});
		}
		
	});
	// FIN INICIAR SESION

	// INICIO USABILIDAD
	$('#contrasena').keypress(function(e){
		if(e.which == 13){
			event.preventDefault();
			$("#btnIniciarSesion").click();
		}
	});
	// FIN USABILIDAD

	$("#btnCancelarCliente").click(function () {
		$('#modalAgregarCliente').modal('hide');
		$("#frmDatosCliente")[0].reset()	
	});

});
// FIN DEL DOCUMENT READY



function CrearUsuario(){
	$('#modalAgregarCliente').modal('show');
	
	$("#btnGuardarCliente").click(function () {
	var datoscliente = $("#frmDatosCliente").serialize();
		$.ajax({
			url: '../private/consultas/guadarcliente.php',  
			type: 'POST',
			data:  datoscliente,
			cache: false,
			dataType:'json',
			success: function(data){
				if (data.estado == 'ok') {
					window.location.replace("maincliente.php");
				} else {
					alertify.error(data.msg);
				}
			},
			error: function() {
				alert('¡Hubo algún error al realizar la llamada AJAX!');
				$("#btnGuardarDeposito").show();
				$("#btnGuardarDepositoGif").hide();
			}
		});
	});
}
