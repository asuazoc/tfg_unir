<?
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

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
		

			<p id="page-intro">Assistents Sopar</p>
			

			
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
				<th colspan="9">Assitens al sopar</th>
				</tr>
			</thead>
			<tbody>
			<tr>
<th>num</th>
<th>ID (inscripció/extres)</th>
<th>categoria</th>
<th>1r cognom</th>
<th>2n cognom</th>
<th>nom</th>
<th>nif</th>
<th>email</th>
<th>sopar?</th>
<th>Estat</th>

</tr><?
$res=mysqli_query($con,"SELECT * FROM inscripcions
where  sopar ='Si'
ORDER BY cg1,cg2, nom ");
$i=0;
while($row=mysqli_fetch_assoc($res)){
$i++;
?>
     <tr>
      <td><?=$i;?></td>
      <td>I-<?=$row['id'];?></td>
      <td><?=$row['categoria'];?></td>
      <td><?=$row['cg1'];?></td>
      <td><?=$row['cg2'];?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['nif'];?></td>
      <td><?=$row['email'];?></td>
      <td><?=$row['sopar'];?></td>
      <td><?=$row['estat'];?></td>
      
      </tr>
<?}
$res=mysqli_query($con,"SELECT * FROM visita
ORDER BY surname,name "); //where  sopar ='S'
while($row=mysqli_fetch_assoc($res)){
$i++;
?>
     <tr>
      <td><?=$i;?></td>
      <td>E-<?=$row['id'];?></td>
      <td></td>
      <td><?=$row['surname'];?></td>
      <td></td>
      <td><?=$row['name'];?></td>
      <td><?=$row['nif'];?></td>
      <td><?=$row['email'];?></td>
      <td><?=$row['sopar'];?></td>
      <td></td>
      
      </tr>
<?}?>

				</tbody>
		  </table>

		
</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
