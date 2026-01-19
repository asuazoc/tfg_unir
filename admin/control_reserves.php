<?
include('../vars.inc.php');
include('control.php');

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

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
 
if($row['dataentrada']!='' && $row['datasortida']!=''){		
	$nits=CalculNits($row['dataentrada'],$row['datasortida']);
}else{
	$nits=array();
}

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




<?
//bucle hotels
foreach($a_hotel as $hotel_key=>$hotel_value){
?>
	
<table id="pagerTable" cellspacing="1" class="tablesorter">
			<thead>
				<tr>
				<th colspan="29">(<?= $hotel_value ?>) <?= $desc ?></th>
				</tr>
			</thead>
			<tbody>
			<tr>
	<th>Dia</th>
	<th>Total Reserva</th>
	<th>Reserves</th>
	<th>Disponibilitat</th>
</tr>

<?

for($i=0; $i<(count($nits)-1);$i++){
	
    $sql="SELECT '".$nits[$i]."' dia, hotel, count( * ) num
	 FROM inscripcions
	 WHERE dataentrada <= '".$nits[$i]."'
	 AND datasortida >= '".$nits[$i+1]."'
	 and hotel='".$hotel_key."'
	 and nits!=0
	 GROUP BY dia, hotel";
	 
	 	
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    

    $sqlDisponibles="SELECT places
	 FROM hotel_habitacio_periodes
	 WHERE data_inici = '".$nits[$i]."' and hotel='".$hotel_key."'";
	 
	 	
    $resultDisponibles = mysqli_query($con,$sqlDisponibles);
    $rowDisponibles = mysqli_fetch_assoc($resultDisponibles);

if (empty($rowDisponibles)){
	$rowDisponibles['places'] = 0;
}

if (!empty($row)){
	$row['dia']=canvia_normal($row['dia']);
?>
<tr>
	<td><?=$row['dia']?> <?=$row['dia']?></td>
	<td><?= $rowDisponibles['places'];//.' # '.$r_hotel[$hotel_key][$row['dia']]?></td>
	<td><?=$row['num']?></td>
	<td><?= ($r_hotel[$hotel_key][$row['dia']]) - ($row['num']) ?> </td>
</tr>
<?
}

}
?>

		</tbody>
		  </table>

		
			<hr />
			<br />
	
<?
}
?>
			
			
		</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
