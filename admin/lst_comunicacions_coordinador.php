<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php'); 
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
					<strong>DEC</strong> (Document ètica i confidencialitat) <br />
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
		
<h2>Comunicaciones</h2>
			<p id="page-intro">Listado de comunicaciones</p>
			
			<ul class="shortcut-buttons-set" style="display:none">
				
				<li><a class="shortcut-button" href="adm_comunicacions.php?accio=N"><span>
					<img src="images/pencil_48.png" alt="icon"><br>
					Afegir Nova
				</span></a></li>
				
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
<b>Recuerde:</b> Puede utilitzar los títulos de la tabla para ordenar los datos de forma ascendente o descendente.
</div>
			</div>
			

					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
							<!-- Page Head -->
			
<table id="pagerTable" cellspacing="1" class="tablesorter">
			<thead>
<tr>
<th>Orden</th>
<th>ID</th>
<th>Título</th>
<th>Autor firmante</th>
<th>Centro firmante</th>
<th>Autores</th>
<th>Centros</th>
<th>Email</th>
<th>Preferencia</th>
<th>Opción 1</th>
<th>Opción 2</th>
<th>Autoritzación</th>
<th>Idioma</th>
<!--<th>Num. notas</th>
<th>Nota media</th>-->
<th>Acciones</th>
</tr>
			</thead>
			<tbody>
<?
$j=0;
$aSql='select * from comunicacions where removed="N" order by id';

$estats = array('Pendet valoració'=>'Pendiente valoración', 'Acceptat'=>'Aceptada', 'Descartat'=>'Descartada');
foreach ($con->query($aSql) as $row){
	$j++;
?>
     <tr>
      <th><?=$j?></th>
      <th class="sub"><?=$row['id']?></th>
      <td><?=$row['titol']?></td>
      <td><?=$row['autor']?></td>
      <td><?=$row['centre_principal']?></td>
      <td><?=$row['autors']?></td>
      <td><?=$row['centre']?></td>
      <td><?=$row['email']?></td>   
      <td><?=$row['comunicacio']?></td>
      <td><?=$paraules_clau[$row['paraules_clau1']]['es']?></td>
      <td><?=$paraules_clau2[$row['paraules_clau2']]['es']?></td>
      <td><?=$row['publicacio']?></td>
      <td><?=$row['comunicacio_lang']?></td>
    <!--  <td><?=$estats[$row['estat']]?></td> -->
    <!--
		<?
		$res2= 'SELECT count(*) total_count, sum(notatotal) total_nota FROM comunicacions_nota WHERE id='.$row['id'];
		
		$result = $con->query($res2);
		if($row2=$result->fetch(PDO::FETCH_ASSOC)){
			if($row2['total_count']!=0){
				$aNota = $row2['total_nota']/$row2['total_count'];
			}else{
				$aNota = '--';
			}	
		}
		?>
		<td><?=$row2['total_count']?></td>      
      <td><?=round($aNota, 2)?></td>-->
      
      <td><a href="comunicacions_show_coordinador.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Ver</a></td>
    </tr>
<?
}
?>
			</tbody>
			</table>
</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
