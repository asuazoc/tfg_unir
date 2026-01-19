<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php'); 
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
		
<h2>Resum Inscripcions</h2>
			<p id="page-intro">Resum inscripcions</p>
			

			
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
					
		
		
					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
							<!-- Page Head -->

<table id="pagerTable" cellspacing="1" class="tablesorter">
 <thead>
  <tr>
	      <th colspan="3">Tipus de Inscipcions</th>
 
         <th colspan="3">Imports</th>

   </tr>
  </thead>  
<? 

$sql    = 'SELECT categoria FROM inscripcions GROUP BY categoria';
/*$resultcat = mysqli_query($con,$sql);
while($rowcat=mysqli_fetch_assoc($resultcat)){*/
foreach ($con->query($sql) as $rowcat){
?>
  
         
			<tbody>
			<tr>
	<th width="30%">Categoria</th>
	<th width="20%">Tipus inscipció</th>
	<th width="20%">Quota</th>

	<th width="10%">Inscrits</th>
	<th width="10%">Import</th>
	<th width="10%">Pagat</th>

</tr>

<?
$sql    = "SELECT categoria, id_inscripcio , total_inscripcio , count( * ) num_inscrits, sum(total_inscripcio) import, sum(pagat_inscripcio) pendent
				FROM inscripcions
				where categoria='".$rowcat['categoria']."'
				GROUP BY categoria, `id_inscripcio` , total_inscripcio";
//$result = mysqli_query($con,$sql);

$c1=0;
$c2=0;
$c3=0;

//while($row=mysqli_fetch_assoc($result)){
foreach ($con->query($sql) as $row){

$g1+=$row['num_inscrits'];
$g2+=$row['import'];
$g3+=$row['pendent'];

$c1+=$row['num_inscrits'];
$c2+=$row['import'];
$c3+=$row['pendent'];


?>
<tr>
	<td><?=$a_categoria[$row['categoria']]?></td>
	<td><?=$a_inscripcio[$row['id_inscripcio']]['es']?></td>
	<td>(<?=$row['total_inscripcio']?>)</td>
	
	<td align="right"><?=$row['num_inscrits']?></td>
	<td align="right"><?=number_format ( $row['import'],2,',','.')?> &euro; </td>
	<td align="right"><?=number_format ($row['pendent'],2,',','.')?> &euro;</td>
	</tr>
<?
}
?>

<tr>
	<td><b>Total</b></td>
	<td></td>
	<td></td>
	<td align="right"><b><?=$c1?></b></td>
	<td align="right"><b><?=number_format ($c2,2,',','.')?> &euro;</b></td>
	<td align="right"><b><?=number_format ($c3,2,',','.')?> &euro;</b></td>
</tr>





<?
}
?>

		
<!-- Total inscipcions-->		

 <thead>
  <tr>
	      <th colspan="6">Totals inscipcions</th>
   </tr>
  </thead>    

<tr>
	<th colspan="3"><b>Totals</b></th>
	<th align="right"><b><?=$g1?></b></th>
	<th align="right"><b><?=number_format ($g2,2,',','.')?> &euro;</b></th>
	<th align="right"><b><?=number_format ($g3,2,',','.')?> &euro;</b></th>
</tr>


</tbody>
</table>		
		
			

<br>
<hr>
<br>	

<h1>CONTROL ALLOTJAMENTS</h1>

<table id="pagerTable" cellspacing="1" class="tablesorter">
 <thead>
  <tr>
	      <th colspan="2">Hotels</th>
 
         <th colspan="3">Imports</th>

   </tr>
  </thead>  

			<tbody>
			<tr>
	<th width="30%">Hotel</th>
	<th width="20%">Habitaci&oacute;</th>
	<th width="10%">Nits</th>
	<th width="10%">Import</th>
	<th width="10%">Pagat</th>

</tr>

<?
$sql    = "SELECT `hotel`,`habitacio`, sum( `nits` ) nits, sum(`total_allotjament`) import, sum(`pagat_allotjament`) pendent
				FROM inscripcions
				where hotel <>''
				GROUP BY `hotel`,`habitacio`";
				
//$result = mysqli_query($con,$sql);

$c1=0;
$c2=0;
$c3=0;

//while($row=mysqli_fetch_assoc($result)){
foreach ($con->query($sql) as $row){

$h1+=$row['nits'];
$h2+=$row['import'];
$h3+=$row['pendent'];

$c1+=$row['nits'];
$c2+=$row['import'];
$c3+=$row['pendent'];


?>
<tr>
	<td><?=$a_hotel[$row['hotel']]?></td>
	<td><?=$a_habitacio[$row['habitacio']]?></td>
	<td align="right"><?=$row['nits']?></td>
	<td align="right"><?=number_format ($row['import'],2,',','.')?> &euro; </td>
	<td align="right"><?=number_format ($row['pendent'],2,',','.')?> &euro;</td>
	</tr>
<?
}
?>

<tr>
	<td><b>Total</b></td>
	<td></td>
	<td align="right"><b><?=$c1?></b></td>
	<td align="right"><b><?=number_format ($c2,2,',','.')?> &euro;</b></td>
	<td align="right"><b><?=number_format ($c3,2,',','.')?> &euro;</b></td>
</tr>

</tbody>
</table>		







<br>
<hr>
<br>	

<h1>CONTROL SOPAR</h1>

<table id="pagerTable" cellspacing="1" class="tablesorter">
 <thead>
  <tr>
	      <th colspan="1">Sopar</th>
 
         <th colspan="3">Imports</th>

   </tr>
  </thead>  

			<tbody>
			<tr>
	<th width="30%">Sopar</th>
	<th width="10%">Inscripts</th>
	<th width="10%">Import</th>
	<th width="10%">Pagat</th>

</tr>

<?
$sql    = "SELECT count(*) total FROM `inscripcions` WHERE sopar = 'Si'";
				
//$result = mysqli_query($con,$sql);

//while($row=mysqli_fetch_assoc($result)){
foreach ($con->query($sql) as $row){?>
<tr>
	<td>Sopar inscripció</td>
	<td align="right"><?=$row['total']?></td>
	<td align="right">0 &euro; </td>
	<td align="right">0 &euro;</td>
	</tr>
<?
$gent_sopar=$row['total'];
}
?>

<?
$sql    = "SELECT count(*) total,sum(total_sopar) total_sopar, sum(pagat_sopar) pagat_sopar FROM `inscripcions` WHERE acomp_sopar = 'Si'";
				
//$result = mysqli_query($con,$sql);

//while($row=mysqli_fetch_assoc($result)){
foreach ($con->query($sql) as $row){?>
<tr>
	<td>Acompanyant al sopar</td>
	<td align="right"><?=$row['total']?></td>
	<td align="right"><?=$row['total_sopar']?> &euro; </td>
	<td align="right"><?=$row['pagat_sopar']?> &euro;</td>
	</tr>
<?
$gent_sopar=$gent_sopar+$row['total'];
$total_sopar=$row['total_sopar'];
$pagat_sopar=$row['total_sopar'];
}
?>


<tr>
	<td><b>Total</b></td>
	<td align="right"><b><?=$gent_sopar?></b></td>
	<td align="right"><b><?=number_format ($total_sopar,2,',','.')?> &euro;</b></td>
	<td align="right"><b><?=number_format ($pagat_sopar,2,',','.')?> &euro;</b></td>
</tr>

</tbody>
</table>		










<br>
<hr>
<br>	

<h1>CONTROL PAGAMENTS</h1>

<table  id="pagerTable" cellspacing="1" class="tablesorter">
 <thead>
  <tr>
         <th colspan="3">Imports</th>

   </tr>
  </thead>  
         
			<tbody>
<tr>
	<th width="20%">Tipus</th>
	<th width="10%">Import</th>
	<th width="10%">Pagat</th>
</tr>

<tr>
	<td>Inscripcions</td>
	<td align="right"><?=number_format ($g2,2,',','.')?> &euro;</td>
	<td align="right"><?=number_format ($g3,2,',','.')?> &euro;</td>
</tr>

<tr>
	<td>Allotjament</td>
	<td align="right"><?=number_format ($h2,2,',','.')?> &euro;</td>
	<td align="right"><?=number_format ($h3,2,',','.')?> &euro;</td>
	
</tr>

<tr>
	<td>Sopar</td>
	<td align="right"><?=number_format ($total_sopar,2,',','.')?> &euro;</td>
	<td align="right"><?=number_format ($pagat_sopar,2,',','.')?> &euro;</td>
	
</tr>

<tr>
	<td><b>Total</b></td>
	<td align="right"><b><?=number_format (($g2 + $h2 + $total_sopar),2,',','.')?> &euro;</b></td>
	<td align="right"><b><?=number_format (($g3 + $h3 + $pagat_sopar),2,',','.')?> &euro;</b></td>
</tr>



</tbody>
</table>		

</div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
<? include('footer.php') ?>
