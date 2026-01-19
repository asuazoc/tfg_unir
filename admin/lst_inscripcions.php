<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php');

$estat_factura_noms=array();
$estat_factura_noms['N']='No';
$estat_factura_noms['P']='Pendent';
$estat_factura_noms['F']='Facturat';

function getValidationLink($id){
	return '<a href="validar_inscripcio.php?id='.$id.'" rel="modal">V</a>';
}

?>

<div id="messages" style="display: none;"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" "modal"  -->

				<h3>Llegenda:</h3>

				<p>
					<strong>M</strong>  (modificar) <br />
					<strong>E</strong>  (eliminiar)  <br />
					<strong>C</strong> (imprimir confirmaci&oacute;) <br />
					<strong>EC</strong>  (enviar confirmaci&oacute;) <br />
					<strong>F</strong> (Factura)  <br />
					<strong>EF</strong> (Enviar Factura) <br />
					<strong>J</strong> (Justificant)  <br />
					<strong>EJ</strong> (Enviar Justificant)  <br />
					<strong>V</strong> (validar)  <br />
				</p>

			</div> <!-- End #messages -->

		</div></div> <!-- End #sidebar -->

		<div id="main-content"> <!-- Main Content Section with everything -->

			<noscript>
<!-- Show a notification if the user has disabled javascript --> <div
class="notification error png_bg"> <div> Javascript is disabled or is
not supported by your browser. Please <a href="http://browsehappy.com/"
title="Upgrade to a better browser">upgrade</a> your browser or <a
href="http://www.google.com/support/bin/answer.py?answer=23852"
title="Enable Javascript in your browser">enable</a> Javascript to
navigate the interface properly. </div> </div> </noscript>

<h2>Inscripciones</h2>
			<p id="page-intro">Listado de inscripciones</p>

			<ul class="shortcut-buttons-set">

				<li><a class="shortcut-button" href="adm_inscripcions.php?accio=N"><span>
					<img src="images/pencil_48.png" alt="icon"><br>
					Añadir nueva
				</span></a></li>

				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="images/comment_48.png" alt="icon"><br>
					Ver leyenda
				</span></a></li>

			</ul><!-- End .shortcut-buttons-set -->

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Table</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recuerda:</b> Puedes utilizar las cabeceras de la tabla para ordenar los datos de forma ascendent o descendent.
</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->



<table id="pagerTable" cellspacing="1" class="tablesorter">
	<thead>
		<tr>
<th></th>
<th>ID</th>
<th>Tipo inscripción</th>
<th>Apellidos</th>
<th>Nombre</th>
<th>Nif</th>
<th>e-mail</th>
<th>Trabajo</th>
<th>Localidad</th>
<th>Ordenante</th>
<th>Cena</th>
<th>Acomp. cena</th>
<th>Restricciones alim.</th>
<th>imp. cena</th>
<th>pagado cena</th>
<th>hotel</th>
<th>hab</th>
<th>in</th>
<th>out</th>
<th>noches</th>
<th>imp. hotel</th>
<th>pagado hotel</th>
<th>imp. inscripci&oacute;n</th>
<th>pagado inscripci&oacute;n</th>
<th>importe total </th>
<th>total pagado</th>
<th>metodo pago</th>
<th>id pago</th>
<th>factura</th>
<th>Estado</th>
<th>Estado factura</th>
<th>Data/hora desa</th>
<th>Acciones</th>
		</tr>
	</thead>
<tbody>

<?$count=1;
//$res=mysqli_query($con,"SELECT * FROM inscripcions where ( incidencia='' OR incidencia =  'N' OR incidencia IS NULL ) ORDER BY cg1, cg2, nom");
//while($row=mysqli_fetch_assoc($res)){
$sql="SELECT * FROM inscripcions where ( incidencia='' OR incidencia =  'N' OR incidencia IS NULL ) and vip='N' ORDER BY cg1, cg2, nom";
foreach ($con->query($sql) as $row){
?>
     <tr>
      <td><?=$count;?></td>
      <td><?=$row['id'];?></td>
      <td>
      	<?=$a_inscripcio[$row['id_inscripcio']]['es'];?>
      	<?if($row['doc_estudiant']){?>
      		&#160;<a href="../upload_estudiant/<?=$row['doc_estudiant']?>" target="_blank">file</a>
      	<?}?>
      </td>
      <td><?=$row['cg1'].' '.$row['cg2']?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['nif_facturacio'];?></td>
      <td><?=$row['email'];?></td>
      <td><?=$row['lloctreball'];?></td>
      <td><?=$row['localitat'];?></td>
      <td><?=$row['nom_facturacio'];?></td>
      <td><?=$row['sopar'];?></td>
      <td><?=$row['acomp_sopar'];?></td>
      <td><?=$row['restriccio_alimenticia'].' '.$row['restriccio_alimenticia_text'];?></td>
      <td><?=number_format($row['total_sopar'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['pagat_sopar'] ?? 0, 2, ',', '.');?></td>
      <td><?=$row['hotel'];?></td>
      <td><?=$row['habitacio'];?></td>
      <td><?=canvia_normal($row['dataentrada']);?></td>
      <td><?=canvia_normal($row['datasortida']);?></td>
      <td><?=$row['nits'];?></td>
      <td><?=number_format($row['total_allotjament'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['pagat_allotjament'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['total_inscripcio'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['pagat_inscripcio'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['total'] ?? 0, 2, ',', '.');?></td>
      <td><?=number_format($row['total_pagat'] ?? 0, 2, ',', '.');?></td>
      <td><?=$row['metode_pagament'];?></td>
      <td><?=$row['id_pagament'];?></td>
      <td><?=$row['numero_factura'];?></td>
      <td><?=$row['estat'];?></td>
      <td><?=$row['estat_factura'];?></td>
      <td><?=$row['data_registre']?></td>
      <td>
      <a href="adm_inscripcions.php?accio=M&id=<?=$row['id']?>">M</a> |
		<?if (empty($row['numero_factura'])){?>
	  		<a onclick="return confirm('Estàs segur d\'eliminar la inscripció <?=$row['id'];?>?')" href="adm_inscripcions.php?accio=E&id=<?=$row['id']?>">E</a> |
		<? } ?>
		<a href="mail_justificant.php?accio=I&id=<?=$row['id']?>" target="_blank">EJ</a> | <a href="mail_justificant.php?id=<?=$row['id']?>" target="_blank">J</a> |
	  	<? if ($row['estat']=="OK"){ ?>
	  		<a href="mail_inscripcio.php?accio=I&id=<?=$row['id']?>" target="_blank">C</a> |
	  		<a href="mail_inscripcio.php?accio=C&id=<?=$row['id']?>" target="_blank">EC</a>  |
		   	<?if (!empty($row['numero_factura'])){?>
	    		<a href="factura.php?id=<?=$row['id'];?>" target="_blank">F</a> |
	    		<a href="factura.php?id=<?=$row['id'];?>&accio=S" target="_blank">EF</a> |
	  			<? } ?>
	  	<? } ?>

		<?= getValidationLink($row['id']);  ?>

	  </td>
      </tr>
<?$count++;
}
?>
			</tbody>
		  </table>

</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
