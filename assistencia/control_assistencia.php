<?php
include('../vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);
include('login.php');

$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=control_assistencia.php");
}
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
		<?php include('header.php');?>
		<div>
				<h3>Control de asistencia <button id="reiniciaLector" type="button" class="btn btn-primary"><i class="fas fa-redo-alt"></i></button></h3>
				<div><center><label id="nif-nomcognoms" class="dadesQR"></label></center></div>
				<div><center><label id="result-verif" class="lecturaQRCorrecta"></label></center></div>
				<div id="video-container" class="color-marc-scanner">
					<video id="qr-video" style="width:100%"></video>
				</div>
				<br>
				<div>
				    <b>Seleccione la cámara a utilizar: </b>
				    <select id="cam-list">
					    <option value="environment" selected>Environment Facing (default)</option>
					    <option value="user">User Facing</option>
				    </select>
				</div>
		</div>
</div>

<div>
    <div hidden>
    <b>Detected QR code: </b>
    <span id="cam-qr-result">None</span>
    <br>
    <b>Last detected at: </b>
    <span id="cam-qr-result-timestamp"></span>
    </div>
</div>

</body>
</html>
<script type="module">

    import QrScanner from "../assistencia/dist/js/qr-scanner.min.js";

    let lecturaQR = "";
    const video = document.getElementById('qr-video');
    const videoContainer = document.getElementById('video-container');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camList = document.getElementById('cam-list');
    const camQrResult = document.getElementById('cam-qr-result');
    reiniciaLector();

    function setResult(label, result) {
        console.log(result.data);
        label.textContent = result.data;
		    if (result.data != '' && result.data != lecturaQR) {
		        confirmarAssistencia(result.data);
		        lecturaQR = result.data;
		        scanner.start();
		    }

        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    }


    // ####### Web Cam Scanning #######

    const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';

        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });

    scanner.start().then(() => {
        scanner.setInversionMode("both");
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label;
            camList.add(option);
        }));
    });

    // for debugging
    window.scanner = scanner;

    camList.addEventListener('change', event => {
        //scanner.setCamera(event.target.value).then(updateFlashAvailability);
        scanner.setCamera(event.target.value);
    });

    document.getElementById('reiniciaLector').addEventListener('click', () => {
        reiniciaLector();
    });

    function reiniciaLector() {
        lecturaQR = "";
        document.getElementById('nif-nomcognoms').innerHTML = "Lector Preparado";
        document.getElementById('result-verif').innerHTML = "Aproximar un QR";
        document.getElementById('result-verif').className = "lecturaQRCorrecta";
    }

</script>

<script type="application/javascript">
		/**
		 * Definir assistència de la suscriptora.
		 *
		 * Aquesta funció ens facilita marcar les assistents per tal que es puguin
		 * generar els seus certificats.
		 *
		 * @param {string}  textQR String que retorna el lector QR.
		 *
		 * @return {void}
		 */
		function confirmarAssistencia(textQR)
		{
			const LABEL_RESULT_VERIF = document.getElementById(`result-verif`);
			const LABEL_NIF_NOMCOGNOMS = document.getElementById(`nif-nomcognoms`);
			let   request    = new XMLHttpRequest();
			let   formData   = new FormData();

			formData.append('textQR', textQR);
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
					sonido.play();

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
</script>
