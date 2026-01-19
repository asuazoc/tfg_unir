<?
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



function CalculNits($data_entrada,$data_sortida){
    //Comprobem dates

    //dividem les dates en un array
    $adata_entrada=explode('-',$data_entrada);
    $adata_sortida=explode('-',$data_sortida);

    //fem els time stamps
    $tdata_entrada=mktime(0,0,0,$adata_entrada[1],$adata_entrada[2],$adata_entrada[0]);
    $tdata_sortida=mktime(0,0,0,$adata_sortida[1],$adata_sortida[2],$adata_sortida[0]);
    
    //contem els dies
    $dies =(($tdata_sortida-$tdata_entrada)/ 86400 );
    
    //contruim una matriu en els dies
    $adies=array();
    for($i=0;$i<$dies+1;$i++){
        $adies[]=date('Y-m-d',$tdata_entrada+(86400*$i));    
    }    
    
    
    //retorns
    // OK -> array('2007-01-01','2007-02-01')
    // ER  -> array('ERR','rao')

    return $adies;
}


$sql="select min(dataentrada) dataentrada ,max(datasortida)  datasortida
		from inscripcions
		where 
		dataentrada <> '0000-00-00' and
		datasortida <> '0000-00-00'";

$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
 
		
$nits=CalculNits($row['dataentrada'],$row['datasortida']);

$disponiblitat=array();

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
				<th colspan="29">Taula factures</th>
				</tr>
			</thead>
			<tbody>
			<tr>
<th>trac</th>
<th>categoria</th>
<th>cognoms</th>
<th>nom</th>
<th>localitat</th>
<th>treball</th>
<th>sopar</th>
<th>hotel</th>
<th>hab</th>
<th>in</th>
<th>out</th>
<th>nits</th>
<th>imp. hotel</th>
<th>pagat hotel</th>
<th>import total </th>
<th>total pagat</th>
<th num. factura</th>
<th>Estat</th>
<th>Accions</th>
</tr><?
$res=mysqli_query($con,"SELECT * FROM inscripcions
where numero_factura<>0 
and estat_factura='F' 
ORDER BY cognoms, nom ");
while($row=mysqli_fetch_assoc($res)){
?>
     <tr>
      <td><?=$row['tractament'];?></td>
      <td><?=$row['categoria'];?></td>
      <td><?=$row['cognoms'];?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['localitat'];?></td>
      <td><?=$row['lloctreball'];?></td>
      <td><?=$row['sopar'];?></td>
      <td><?=$row['hotel'];?></td>
      <td><?=$row['habitacio'];?></td>
      <td><?=canvia_normal($row['dataentrada']);?></td>
      <td><?=canvia_normal($row['datasortida']);?></td>
      <td><?=$row['nits'];?></td>
      <td><?=$row['total_allotjament'];?></td>
      <td><?=$row['pagat_allotjament'];?></td>
      <td><?=$row['total'];?></td>
      <td><?=$row['total_pagat'];?></td>
      <td><?=$row['numero_factura'];?></td>
      <td><?=$row['estat'];?></td>
      <td>
      <a href="factura.php?id=<?=urlencode  ( base64_encode(base64_encode($row['id'])));?>" target="_blank">Factura</a>
	  </td>
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
