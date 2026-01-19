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
?>

<div id="messages" style="display: none;"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				
				<h3>Llegenda:</h3>
			 
				<p>
					<strong>M</strong>  (modificar) <br />
					<strong>E</strong>  (eliminiar)  <br />
					<strong>C</strong> (imprimir confirmaci&oacute;) <br />				
					<strong>EC</strong>  (enviar confirmaci&oacute;) <br />
					<strong>F</strong> (Factura)  <br />
					<strong>EF</strong> (Enviar Factura) <br />
					<strong>J</strong> (Enviar Justificant)  <br />
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
		
<h2>Inscripcions</h2>
			<p id="page-intro">Llistat d'inscripcions</p>
			
			<ul class="shortcut-buttons-set">
				
				<!--<li><a class="shortcut-button" href="adm_inscripcions.php?accio=N"><span>
					<img src="images/pencil_48.png" alt="icon"><br>
					Afegir Nova
				</span></a></li>-->
				
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="images/comment_48.png" alt="icon"><br>
					Veure llegenda
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Content box</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Table</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
		
			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recorda:</b> Pots utilitzar les capçaleres de la taula per ordenar les dades de forma ascendent o descendent.
</div>
			</div>
			

					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
							<!-- Page Head -->
			
<table id="pagerTable" cellspacing="1" class="tablesorter">
	<thead>
		<tr>
<th></th>
<th>ID</th>				
<th>Cat.</th>
<th>Cognoms</th>
<th>Nom</th>
<th>Treball</th>
<th>Ordenant</th>
<th>hotel</th>
<th>hab</th>
<th>in</th>
<th>out</th>
<th>nits</th>
<th>imp. hotel</th>
<th>pagat hotel</th>
<th>imp. inscripci&oacute;</th>
<th>pagat inscripci&oacute;</th>
<th>import total </th>
<th>total pagat</th>
<th>factura</th>
<th>Estat</th>
<th>Estat factura</th>
<th>Accions</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
<th></th>
<th>ID</th>				
<th>Cat.</th>
<th>Cognoms</th>
<th>Nom</th>
<th>Treball</th>
<th>Ordenant</th>
<th>Hotel</th>
<th>hab</th>
<th>in</th>
<th>out</th>
<th>nits</th>
<th>imp. hotel</th>
<th>pagat hotel</th>
<th>imp. inscripci&oacute;</th>
<th>pagat inscripci&oacute;</th>
<th>import total </th>
<th>total pagat</th>
<th>factura</th>
<th>Estat</th>
<th>Estat factura</th>
<th>Accions</th>

		</tr>
	</tfoot>


<tbody>

<?$count=1;
$res= "SELECT * FROM inscripcions where incidencia='S' ORDER BY cg1,cg2, nom";
foreach ($con->query($res) as $row){
?>
     <tr>
      <td><?=$count;?></td>     
      <td><?=$row['id'];?></td>
      <td><?=$row['categoria'];?></td>
      <td><?=$row['cg1'];?> <?=$row['cg2'];?></td>
      <td><?=$row['nom'];?></td>
            <td><?=$row['lloctreball'];?></td>
      <td><?=$row['nom_facturacio'];?></td>
      <td><?=$row['hotel'];?></td>
      <td><?=$row['habitacio'];?></td>
      <td><?=canvia_normal($row['dataentrada']);?></td>
      <td><?=canvia_normal($row['datasortida']);?></td>
      <td><?=$row['nits'];?></td>
      <td><?=$row['total_allotjament'];?></td>
      <td><?=$row['pagat_allotjament'];?></td>
       <td><?=$row['total_inscripcio'];?></td>
      <td><?=$row['pagat_inscripcio'];?></td>
      <td><?=$row['total'];?></td>
      <td><?=$row['total_pagat'];?></td>
      <td><?=$row['numero_factura'];?></td>
      <td><?=$row['estat'];?></td>
      <td><?=$estat_factura_noms[$row['estat_factura']];?></td>
      <td><a href="adm_inscripcions.php?accio=M&id=<?=$row['id']?>">M</a> | 
	<?if (empty($row['numero_factura'])){?>
	  <a onclick="return confirm('Estàs segur d\'eliminar la inscripció de <?=$row['cg1'];?> <?=$row['cg2'];?>, <?=$row['nom'];?> ?')" href="adm_inscripcions.php?accio=E&id=<?=$row['id']?>">E</a> | 
	<? } ?>
		<a href="mail_justificant.php?accio=I&id=<?=$row['id']?>" target="_blank">J</a> | 
	  <? if ($row['estat']=="OK"){ ?>
	  <a href="mail_inscripcio.php?accio=I&id=<?=$row['id']?>" target="_blank">C</a> | 
	  <a href="mail_inscripcio.php?accio=C&id=<?=$row['id']?>" target="_blank">EC</a>  | 
	    <?if (!empty($row['numero_factura'])){?>
	    	<a href="factura.php?id=<?=$row['id'];?>" target="_blank">F</a> |
	    	<a href="factura.php?id=<?=$row['id'];?>&accio=S" target="_blank">EF</a>
	    <? } ?>
	  <? } ?>
	  </td>
      </tr>
<?$count++;
}
?>
			</tbody>
		  </table>

<!--		
	<div id="pager" class="pager">
	<form>
		<img src="js/table/addons/pager/icons/first.png" class="first"/>
		<img src="js/table/addons/pager/icons/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="js/table/addons/pager/icons/next.png" class="next"/>
		<img src="js/table/addons/pager/icons/last.png" class="last"/>
		<select class="pagesize">
			<option value="10">10</option>
			<option selected="selected" value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
		</select>
	</form>
	</div>
-->
</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
