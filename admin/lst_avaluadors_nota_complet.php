<?
include('../vars.inc.php');
include('control.php');
ini_set('display_errors', 0);

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php');

function explode_trim($str, $delimiter = ',') {
    if ( is_string($delimiter) ) {
        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str));
        return explode($delimiter, $str);
    }
    return $str;
}


$user=$_SESSION['user'];

$tipus=array('investigacio'=>"Treball d'investigació clínica o experimental",
			  'cas'=>"Cas clínic");

?>
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

<h2>Notes Comunicació/Avaluadors</h2>
			<p id="page-intro">Notes agrupades per comunicació</p>

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Comunicacions</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Taula</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recuerde:</b> Puede utilizar las cabeceras de la tabla para ordenar de forma ascendente o descendente
</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->
<?$res_usuaris="SELECT usuari,comunicacions_visibles,comunicacions_revisio FROM users where comunicacions_visibles!='' ORDER BY usuari";
$result = $con->query($res_usuaris);
$rows = $result->rowCount();
?>
<table id="pagerTable" cellspacing="1" class="tablesorter">
   <thead>

 		<tr>
 		<th>Ordre</th>
        <th>ID</th>
        <th>Titulo</th>

        <th>Autor  signant</th>
		<th>Centro  firmante</th>
		<th>Tel</th>
		<th>Email</th>
		<th>NIF</th>
		<th>Autores</th>
		<th>Centros</th>

		<th>Preferencia</th>
		<th>Opción 1</th>
		<th>Opción 2</th>
		<th>Autorización</th>
		<th>Autorit. NIF</th>
		<th>Idioma</th>
		<th>Estado</th>
<?
foreach ($con->query($res_usuaris) as $row_usuaris){?>
        <th colspan="2"><?=$row_usuaris['usuari']?></th>
<?}?>
			<th>Nota media</th>
			<th>Acciones</th>
      </tr>
    </thead>
    <tbody>
<?
$c=0;
$sql="SELECT
c.id,
c.titol,
c.autor,
c.centre_principal,
c.autors,
c.centre,
c.tel,
c.email,
c.nif,
c.comunicacio,
c.paraules_clau1,
c.paraules_clau2,
c.publicacio,
c.autorizacio_dni,
c.comunicacio_lang,
c.estat,
count(*) evaluaciones,
avg(notatotal) media
FROM `comunicacions_nota` as cn,
comunicacions as c where
cn.id=c.id
and c.removed='N'
group by c.id,
c.titol,
c.autor,
c.centre_principal,
c.autors,
c.centre,
c.tel,
c.email,
c.nif,
c.comunicacio,
c.paraules_clau1,
c.paraules_clau2,
c.publicacio,
c.autorizacio_dni,
c.comunicacio_lang,
c.estat
order by c.id";
foreach ($con->query($sql) as $row){
$c++;?>
                <tr>
                  <th><?=$c?></th>
                  <td><?=$row['id']?></td>
                  <td><?=$row['titol']?></td>

                  <td><?=$row['autor']?></td>
			      <td><?=$row['centre_principal']?></td>
			      <td><?=$row['tel']?></td>
			      <td><?=$row['email']?></td>
			      <td><?=$row['nif']?></td>
			      <td><?=$row['autors']?></td>
			      <td><?=$row['centre']?></td>

			      <td><?=$row['comunicacio']?></td>
			      <td><?=$paraules_clau[$row['paraules_clau1']]['es']?></td>
				  <td><?=$paraules_clau2[$row['paraules_clau2']]['es']?></td>
				  <td><?=$row['publicacio']?></td>
				  <td><?=$row['autorizacio_dni']?></td>
				  <td><?=$row['comunicacio_lang']?></td>
			      <td><?=$row['estat']?></td>
							<?
							$sql_usuaris="SELECT usuari,comunicacions_visibles,comunicacions_revisio FROM users where comunicacions_visibles!='' ORDER BY usuari";
							$notes=0;
							$sum_notes=0;
							foreach ($con->query($sql_usuaris) as $row_usuaris2){
								$tComunicacionV = explode(',',$row_usuaris2['comunicacions_visibles']);
								$tComunicacionR = explode(',',$row_usuaris2['comunicacions_revisio']);
								$aSql = "SELECT notatotal, revisio, recomanacio FROM comunicacions_nota WHERE id =".$row['id']." AND user='".$row_usuaris2['usuari']."' ";
								$result = $con->query($aSql);
							    if($row_nota = $result->fetch(PDO::FETCH_ASSOC)){?>
							         <td><?=number_format($row_nota['notatotal'], 2, ',', '')?>
									<?/*if($row_nota[1]=='S'){?>
									&#160;(R)
									<?}else if($row_nota[1]=='S2'){?>
									&#160;(R2)
									<?}*/?>
								 </td>
								 <td><?=$comunicacio_eval[$row_nota['recomanacio']]?></td>
							         <?$notes++;
							         $sum_notes = $sum_notes + $row_nota['notatotal'];
								}else{?>
									<td>
										<?php if(in_array($row['id'], $tComunicacionV)){?>
											<span style="color:red">Pendiente evaluar</span>
										<?}else if(in_array($row['id'], $tComunicacionR)){?>
											<span style="color:red">Pendiente evaluar</span>
										<?}/*else if(in_array($row['id'], $tComunicacionR2)){?>
											<span style="color:red">Pendiente evaluar</span>
										<?}*/?>
									</td>
									<td></td>
								<?}
							}?>
						<td><?=($notes!=0)?number_format(($sum_notes/$notes), 2, ',', ''):'';?></td>
						<td><a href="comunicacions_privat_show.php?accio=P&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Veure</a>
                </tr>
<?
}?>
              </tbody>
            </table>
        </div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
