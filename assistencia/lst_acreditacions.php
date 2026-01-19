<?php
//exit();
include('../vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);

/*use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;*/
include('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=lst_inscripcions.php");
}

if($_SESSION['rol']!='admin'){
	header("Location: control_assistencia.php");
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

	<script type="text/javascript">
		<?php //include('js/script_lst_inscripcions.js'); ?>
	</script>
</head>

<?
if (isset($_GET['estat'])) {
	$aEstat = $_GET['estat'];
} else {
	$aEstat = 'OK';
}
//$rol = $_SESSION['rol'];

$con = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName) or die ("Error en la conexión a la base de datos: ".mysqli_connect_error());
$con->set_charset("utf8");

$sql                = "SELECT * FROM inscripcions ORDER BY id"; //WHERE ESTAT = '".$aEstat."'
$resultat           = mysqli_query($con, $sql);
$totalResultats     = mysqli_num_rows($resultat);
//$con->close();
?>

<body>
	<!-- <div class="container"> -->
	<div class="col-md-12">
	<?php include('header.php');?>
	<div>
		<div>
		<!-- Selector Estat inscripcions -->
		<h3 style="margin-bottom: 42px;">Acreditacions</h3>
    <div class="col-md-9">
        <div class="input-group mb-3">
          <span class="input-group-text">IDs entre</span>
          <input type="text" id="id_inici" name="id_inici" class="form-control">
          <span class="input-group-text">fins</span>
          <input type="text" id="id_fi" name="id_fi" class="form-control">
          <button class="btn btn-outline-secondary" type="button" id="generarAcreditacions">Genera acreditacions</button>
          <button class="btn btn-outline-secondary" type="button" id="generarAcreditacionsInd">Genera acreditacions (individuals)</button>
          <button class="btn btn-outline-secondary" type="button" id="enviarMailsQR" <?=(ENVIO_MAILS_ACTIVO)?"":"disabled";?>>Envia emails amb QR</button>
        </div>
				<div id="resultatSend" class="alert alert-success" role="alert"></div>

    </div>
		<div class="col-md-4">
			<div class="spinner-border" role="status" id="loading" style="display:none">
				<span class="sr-only">Loading...</span>
			</div>
		</div>

		<div class="col-md-12">
		<table id="taulaInscrits" class="table table-responsive table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>ID</th>
					<th>Nom</th>
					<th>Primer cognom</th>
					<th>Segon cognom</th>
					<th>NIF</th>
					<th>Email</th>
          <th>Tipus</th>
          <th>Estat</th>
          <th>Mail QR</th>
          <th>Acreditació</th>
				</tr>
			</thead>
			<?php
			  if ($resultat) {?>
				<tbody class="scrollingContent" style="font-size:90%">
					<?$resultats= false;
					$i=1;
					while ($inscripcio = mysqli_fetch_array($resultat)) {
					    $resultats= true;?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?= $inscripcio['id']; ?></td>
							<?php $nom = $inscripcio['nom'];
							if (!mb_detect_encoding($nom, 'UTF-8', true)) {
								$nom = utf8_encode($nom);
							}?>
							<td><?= $nom?></td>
							<?php $cg1 = $inscripcio['cg1'];
							if (!mb_detect_encoding($cg1, 'UTF-8', true)) {
								$cg1 = utf8_encode($cg1);
							}?>
							<td><?= $cg1?></td>
							<?php $cg2 = $inscripcio['cg2'];
							if (!mb_detect_encoding($cg2, 'UTF-8', true)) {
								$cg2 = utf8_encode($cg2);
							}?>
							<td><?= $cg2?></td>
							<td><?= $inscripcio['nif'] ?></td>
							<td><?= (isset($inscripcio['email1']))?$inscripcio['email1']:((isset($inscripcio['email2']))?$inscripcio['email2']:$inscripcio['email']) ?></td>
							<td><?= $inscripcio['tipo_acreditacion'] ?></td>
							<td><?= $inscripcio['estat'] ?></td>
							<td><?= $inscripcio['enviado_qr_asistencia'] ?>&#160;<button class="btn btn-outline-secondary" type="button" onclick="enviaMailQR(<?= $inscripcio['id']; ?>,<?= $inscripcio['id']; ?>,'')" <?=(ENVIO_MAILS_ACTIVO)?"":"disabled";?>>Envia</button></td>
              <td><button class="btn btn-outline-secondary" type="button" onclick="generarAcreditacio(<?= $inscripcio['id']; ?>)">Genera</button></td>
						</tr>
						<?$i++;
					}
					if($resultats==false){?>
						<tr><td colspan="13">No hi ha inscripcions amb aquest estat</td></tr>
					<?}?>
				</tbody>
			<?}?>
		</table>
		</div>
	</div><!-- /.container -->

	<!-- MODALS
	--------------------------------------------------------------------------->
	<div class="modal fade" id="gecModal" tabindex="-1" aria-labelledby="gecModalLabel" aria-hidden="true"> <!-- role="dialog"  -->
		<div class="modal-dialog"> <!-- role="document" -->
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title col-11 text-left" id="gecModalLabel">Generar i Enviar Certificats</h5>
					<!-- <button type="button" class="btn-close col-1" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				<?php if (isset($totalAssistents)){ ?>
					<?php if ($totalAssistents < 2): ?>
						<p><strong>Voleu generar i enviar el certificat d'assistència?</strong></p>
						<p>Hi ha un total d'<strong><span id="gec-restants"><?= $totalAssistents; ?></span></strong> certificat pendent per ser generat i enviat.</p>
					<?php else: ?>
						<p><strong>Voleu generar i enviar els certificats d'assistència?</strong></p>
						<p>Hi ha un total de <strong><span id="gec-restants"><?= $totalAssistents; ?></span></strong> certificats pendents per ser generats i enviats.</p>
					<?php endif; ?>
				<?php } ?>
				</div>
				<div class="modal-footer">
					<button id="gec-tancar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
					<button id="gec-endavant" type="button" class="btn btn-primary" onclick="generarEnviarCertificats(<?= $idMin?>,<?= $idMax?>)">Generar i Enviar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="confirmCanviEstatModal" aria-hidden="true" aria-labelledby="confirmCanviEstatModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmCanviEstatModalLabel">Canvi Estat Inscripció</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
           </div>
           <div class="modal-footer">
              <button id="confirmCanviEstat-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button id="confirmCanviEstat-si" type="button" class="btn btn-primary">Si</button>
           </div>
         </div>
      </div>
    </div>

    <div class="modal fade" id="confirmEnviarCertificatModal" aria-hidden="true" aria-labelledby="confirmEnviarCertificatModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmEnviarCertificatModallLabel">Enviar certificat</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
		   </div>
           <div class="modal-footer">
              <button id="confirmEnviarCertificat-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button id="confirmEnviarCertificat-si" type="button" class="btn btn-primary">Si</button>
           </div>
         </div>
      </div>
    </div>

 <div class="modal fade" id="confirmTipusCorreuQRModal" aria-hidden="true" aria-labelledby="confirmTipusCorreuQRModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmTipusCorreuQRModalLabel">Tipus enviament QR</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
           	<input type="radio" class="tipus_correu" required name="tipus_correu" id="inicial" value="inicial">
           	<label for="inicial">Correu Inicial</label><br>
          	<input type="radio" class="tipus_correu" required name="tipus_correu" id="recordatori" value="recordatori">
          	<label for="recordatori">Correu Recordatori</label><br>
           </div>
           <div class="modal-footer">
              <button id="confirmTipusCorreuQR-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
              <button id="confirmTipusCorreuQR-si" type="button" class="btn btn-primary">Acceptar</button>
           </div>
         </div>
      </div>
    </div>

<div class="modal fade" id="confirmTipusCorreuQRMassiuModal" aria-hidden="true" aria-labelledby="confirmTipusCorreuQRMassiuModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmTipusCorreuQRMassiuModalLabel">Tipus enviament QR</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
           	<input type="radio" class="tipus_correu_massiu" required name="tipus_correu_massiu" id="inicial" value="inicial">
           	<label for="inicial">Correu Inicial</label><br>
          	<input type="radio" class="tipus_correu_massiu" required name="tipus_correu_massiu" id="recordatori" value="recordatori">
          	<label for="recordatori">Correu Recordatori</label><br>
		   </div>
           <div class="modal-footer">
              <button id="confirmTipusCorreuQRMassiu-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
              <button id="confirmTipusCorreuQRMassiu-si" type="button" class="btn btn-primary">Acceptar</button>
           </div>
         </div>
      </div>
    </div>

 <div class="modal fade" id="confirmEnviarQRModal" aria-hidden="true" aria-labelledby="confirmEnviarQRModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmEnviarQRModallLabel">Enviar QR</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
		   </div>
           <div class="modal-footer">
              <button id="confirmEnviarQR-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button id="confirmEnviarQR-si" type="button" class="btn btn-primary">Si</button>
           </div>
         </div>
      </div>
    </div>

    <div class="modal fade" id="confirmEnviarQRMassiuModal" tabindex="-1" aria-labelledby="confirmEnviarQRMassiuModalLabel" aria-hidden="true"> <!-- role="dialog"  -->
		<div class="modal-dialog"> <!-- role="document" -->
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title col-11 text-left" id="confirmEnviarQRMassiuModalLabel">Enviar QR</h5>
					<!-- <button type="button" class="btn-close col-1" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<!--
					<button id="qrMassiu-tancar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
					<button id="qrMassiu-endavant" type="button" class="btn btn-primary" onclick="EnviarQRs();">Enviar</button>
					 -->
					<button id="confirmEnviarQRMassiu-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              		<button id="confirmEnviarQRMassiu-si" type="button" class="btn btn-primary">Si</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade " id="confirmPeriodeAssistenciaModal" aria-hidden="true" aria-labelledby="confirmPeriodeAssistenciaModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="confirmPeriodeAssistenciaModalLabel">Confirmar assistència</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <label class="tema_fosc"><b>Nom assistent: </b></label>
               <label id="nomInscrit"></label><br>
           <?php if ($num_verifs>1) {?>
           	<div class="form-check form-switch switchsPeriodes col-12" style="vertical-align: middle">
               <table style="width:100%;">
           <?php foreach ($periodes_verifs as $key => $periode){?>
                		<tr style="vertical-align: middle; height:50px">
                           <td style="width:5%">
                           		<input class="form-check-input periode" type="checkbox" role="switch" id="periode_<?php echo $key;?>">
                           </td>
                           <td style="width:15%">
                           	 	<label class="form-check-label" for="periode_<?php echo $key;?>"><b><?php echo $periode["nom"];?></b></label>
                           </td>
                           <td style="width:30%">
                           		<label><?php echo date("d/m/y H:i",$periode["inici"])." - ".date("H:i",$periode["fi"]);?></label>
                           </td>
                           <td id="llegendaRecomanada_<?php echo $key;?>" style="width:20%">
                           <table style="width:100%">
               					<tr style="vertical-align: middle; height:30px">
               		   				<td>
                       					<svg width="15" height="15">
          									<rect width="10" height="10" style="fill:#ffe066;stroke:rgb(0,0,0)" />
        								</svg>
                       					<label><i>Recomanada</i></label>
                       				</td>
                   			</table>
                           </td>
               			</tr>
                <?php }?>
           <?php }?>
           		</table>
           	</div>
			</div>
           <div class="modal-footer">
              <button id="confirmPeriode-no" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
              <button id="confirmPeriode-si" type="button" class="btn btn-primary">Acceptar</button>
           </div>
           </div>
         </div>
      </div>

    <div class="modal fade" id="mostraMissatgeModal" aria-hidden="true" aria-labelledby="mostraMissatgeModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-header">
             <h1 class="modal-title fs-5" id="mostraMissatgeModallLabel">Atenció</h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
           <table>
               <tr>
                   <td>
                   		<i class="fa-solid fa-triangle-exclamation fa-2xl iconaModificar"></i>
                   </td>
                   <td>
                   		<label class="textMissatgeModal"></label>
                   </td>
               <tr>
           </table>
		   </div>
           <div class="modal-footer">
              <button type="button" class="btn boto_tema_fosc" data-bs-dismiss="modal">Acceptar</button>
           </div>
         </div>
      </div>
    </div>

  </div>
</div>
<?php
/*function obtenirPctAssistencia($idInscripcio){
    global $con;
    global $num_verifs;
		$sql                = "SELECT * FROM assistencia WHERE HA_ASSISTIT = 'S' AND IDINSCRIPCIO='".$idInscripcio."'";
    $resultat           = mysqli_query($con, $sql);
    $totalAssist     = mysqli_num_rows($resultat);
    return (($totalAssist*100)/$num_verifs);
}*/
?>


<script type="application/javascript">
			var limit=10;
			var offset=0;
			var total=0;

			$('#resultatSend').hide();

			$(document).ready(function () {
			$('#taulaInscrits').DataTable({
				lengthMenu: [ [25, 50, 100, -1], [25, 50, 100, "Tots"] ],
				language: {
				processing    : "Processant...",
				search        : "Cercar:",
				lengthMenu    : "Mostra _MENU_ registres",
				info          : "Mostrant de _START_ a _END_ de _TOTAL_ registres",
				infoEmpty     : "Mostrant de 0 a 0 de 0 registres",
				infoFiltered  : "(filtrat de _MAX_ total registres)",
				infoPostFix   : "",
				loadingRecords: "Carregant...",
				zeroRecords   : "No s'han trobat registres",
				emptyTable    : "No s'han trobat registres",
				paginate: {
					first   : "Primer",
					previous: "Anterior",
					next    : "Següent",
					last    : "Últim"
				},
				aria: {
					sortAscending : ": activa per ordenar la columna ascendentment",
					sortDescending: ": activa per ordenar la columna descendentment"
				}
			}
			});
		});

		function marcarCanvi(id_periode,id_inscripcio) {

				if (id_inscripcio != 0) {
					//const BTN_ENVIAR = document.getElementById(`eqr-${id}`);
					let   request    = new XMLHttpRequest();
					let   formData   = new FormData();
					/*BTN_ENVIAR.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
					BTN_ENVIAR.title     = 'Enviant...';
					BTN_ENVIAR.disabled  = true;*/

					formData.append('id_periode', id_periode);
					formData.append('id_inscripcio', id_inscripcio);
					var action = "0";
					if(($('#check_'+id_inscripcio+'_'+id_periode).is(':checked'))){
							var action = "1";
					}
					formData.append('action', action);
					request.open('POST', `${BASE_URL}/confirmar_assistencia.php`, true);

					request.onload = function() {
							if (this.status >= 200 && this.status <= 500) {
								//alert(this.responseText);
								let respostaAjax = JSON.parse(this.responseText);
								if (respostaAjax.success) {
									alert("Canvi registrat correctament.");
								} else {
									alert("Error en la generació i enviament del QR");
								}
							} else {
								alert("La connexió s'ha establert correctament però s'ha tornat un error.");
						 }
					};
					request.send(formData);
				}
			}


			function enviaMailQR(id_inici,id_fi,enviat) {

				//const BTN_ENVIAR = document.getElementById(`eqr-${id}`);
				let   request    = new XMLHttpRequest();
				let   formData   = new FormData();

				formData.append('id_inici', id_inici);
				formData.append('id_fi', id_fi);
				formData.append('enviat', enviat);
				formData.append('limit', limit);
				formData.append('offset', offset);
				request.open('POST', `${BASE_URL}/enviar_mail_qr.php`, true);

				request.onload = function() {
						if (this.status >= 200 && this.status <= 500) {
							//alert(this.responseText);
							let respostaAjax = JSON.parse(this.responseText);
							if (respostaAjax.success) {
								if(respostaAjax.enviats!=0){
									total = total+respostaAjax.enviats;
									offset = offset+limit;
									$('#resultatSend').show();
									$('#resultatSend').html("Enviament en curs: Enviats "+total);
									enviaMailQR(id_inici,id_fi,enviat);
								}else{
									$('#resultatSend').html("Missatges enviats: "+total);
			 					  	$('#enviarMailsQR').removeAttr('disabled');
			 					  	$('#loading').hide();
									alert("Missatges enviats");
									offset=0;
								}
							} else {
								//alert("Error en la generació i enviament del QR");
								alert(respostaAjax.msg);
								$('#enviarMailsQR').removeAttr('disabled');
								$('#loading').hide();
								offset=0;
							}
						} else {
							alert("La connexió s'ha establert correctament però s'ha tornat un error.");
					 }
				};
				request.send(formData);
			}


      $('#generarAcreditacions').on('click', function(event) {
        window.open("genera_acreditacions.php?id_inici="+$('#id_inici').val()+"&id_fi="+$('#id_fi').val());
      });

      $('#generarAcreditacionsInd').on('click', function(event) {
        window.open("genera_acreditacions_individuals.php?repeats=2&id_inici="+$('#id_inici').val()+"&id_fi="+$('#id_fi').val());
      });

      $('#enviarMailsQR').on('click', function(event) {
				if(confirm("Segur que vols enviar els mails amb el QR d'assistència a les inscripcions pendents?")){
					$('#enviarMailsQR').attr("disabled","disabled");
					$('#loading').show();
					offset=0;
					total=0;
					enviaMailQR($('#id_inici').val(),$('#id_fi').val(),'N');
				}
      });

      function generarAcreditacio(id){
        window.open("genera_acreditacions_individuals.php?id_inici="+id+"&id_fi="+id);
			}


	</script>
</body>
</html>
