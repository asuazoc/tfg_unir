<?php
include('../vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*include('login.php');

$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=control_assistencia.php");
}*/
?>
<!DOCTYPE html>
<html lang="ca">

<head>
	<?php include('head_html_comu.php'); ?>
	<script src="<?=CARPETA_WEB;?>/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Datatables -->
	<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>
	<div>
		<?php //include('header.php');?>
		<div>
				<h3>Confirma assistència<br/><?=$titol_congres?></h3>
				<div class="container">
					<strong>Introdueix el número d'inscripció (ID). Pots trobar-lo a la teva acreditació.</strong>
  				<div class="row align-items-start">
						<div class="mb-6 col-auto">
							<div class="input-group">
							  <input type="hidden" id="idPeriod" value="<?=(isset($_GET['p']))?$_GET['p']:''?>"/>
							  <input type="text" class="form-control" id="idInscripcio" placeholder="Número d'inscripció">
							  <button class="btn btn-outline-secondary" type="button" id="valida">Valida</button>
							</div>
						</div>
  				</div>
  				<div><center><label id="nif-nomcognoms" class="dadesQR"></label></center></div>
  				<div><center><label id="result-verif" class="lecturaQRCorrecta"></label></center></div>
		</div>
	</div>
</div>

</body>
</html>

<script type="application/javascript">
		function confirmarAssistencia(textQR)
		{
			const LABEL_RESULT_VERIF = document.getElementById(`result-verif`);
			const LABEL_NIF_NOMCOGNOMS = document.getElementById(`nif-nomcognoms`);
			let   request    = new XMLHttpRequest();
			let   formData   = new FormData();

			formData.append('textQR', textQR);
			var idPeriod = $('#idPeriod').val(); //btoa($('#idPeriod').val());
			formData.append('idPeriod', idPeriod);
			request.open('POST',`${BASE_URL}/confirmar_assistencia.php`,true);
			request.onload = function() {
				if (this.status >= 200 && this.status <= 500) {
					let respostaAjax = JSON.parse(this.responseText);

					LABEL_NIF_NOMCOGNOMS.innerHTML = respostaAjax.nif + " " + respostaAjax.nomCognoms;
					LABEL_RESULT_VERIF.innerHTML = respostaAjax.msg;

					if (respostaAjax.success==1) {
						LABEL_RESULT_VERIF.className = "lecturaQRCorrecta";
						var sonido = new Audio(`${BASE_URL}/sound/lecturaqrOK.oga`);
					} else if (respostaAjax.success==2) {
						LABEL_RESULT_VERIF.className = "lecturaQRNeutra";
						var sonido = new Audio(`${BASE_URL}/sound/lecturaqrKO.ogg`);
					} else {
						LABEL_RESULT_VERIF.className = "lecturaQRIncorrecta";
						var sonido = new Audio(`${BASE_URL}/sound/lecturaqrKO.ogg`);
					}

					$('#valida').removeAttr('disabled');
					$('#loading').hide();

				} else {
					console.group("Error en l'actualització de l'assistència");
					console.warn("La connexió s'ha establert correctament però s'ha tornat un error.");
					console.log(JSON.parse(this.responseText));
					console.groupEnd();
				}
			};

			request.onerror = function() {
				console.group('Error de connexió');
				console.error("No s'ha pogut establir una connexió amb el servidor.");
				console.groupEnd();
			};

			request.send(formData);
		}

		$('#valida').on('click', function(event) {
			$('#valida').attr("disabled","disabled");
			$('#loading').show();
			confirmarAssistencia('<?=sha1(PREFIX_EVENT).'_'?>'+btoa($('#idInscripcio').val()));
		});
</script>
