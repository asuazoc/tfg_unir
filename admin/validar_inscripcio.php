<?
include('../vars.inc.php');
include('control.php');
/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
$id=$_GET['id'];

//agafem les dades actuals
$sql="select * from inscripcions where id=$id";
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

$cognoms=$row['cg1'].' '.$row['cg2'];
$nom=$row['nom'];
$numero_factura=$row['numero_factura'];
$nif_facturacio=$row['nif_facturacio'];
$data_factura=$row['data_factura'];
$estat_factura=$row['estat_factura'];
$total_allotjament=$row['total_allotjament']; 
$pagat_allotjament=$row['pagat_allotjament'];
$total_inscripcio=$row['total_inscripcio']; 
$pagat_inscripcio=$row['pagat_inscripcio'];
$total_sopar=$row['total_sopar']; 
$pagat_sopar=$row['pagat_sopar'];
$total=$row['total'];
$total_pagat=$row['total_pagat'];

if (empty($numero_factura)){
		$numero_factura=0;
	}

//mirem quin numero de factura toca
//if ($nif_facturacio!=""&& $estat_factura!="F" && $numero_factura==0 && $total!=0 && $total_inscripcio!=0){
if ($nif_facturacio!=""&& $estat_factura!="F" && $numero_factura==0 && $total!=0){
	
	//emplenem tots els camps de forma automatica!!
	$numero_factura=cercaNumFacturaValid();
	$data_factura=date('Y-m-d');
	$estat_factura="F";
	$pagat_allotjament=$total_allotjament;
 	$pagat_inscripcio=$total_inscripcio; 
	$pagat_sopar=$total_sopar;
	$total_pagat=$total;
	
	//i ara a guardar-ho!!		
	$sql="UPDATE inscripcions SET 
	pagat_allotjament='$pagat_allotjament',
	pagat_inscripcio='$pagat_inscripcio', 
	total_pagat='$total_pagat',
	pagat_sopar='$pagat_sopar',
	estat_factura='$estat_factura',
	numero_factura='$numero_factura',
	data_factura='$data_factura',
	estat='OK' 
	where id=".$id;
   	$result = $con->prepare($sql);
	$result->execute();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Gestió del congres: <?=$titol_congres?></title>
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="style/reset.css" type="text/css" media="screen">
<!-- Main Stylesheet -->
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen">
<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
</head>
<body>
<div>
<?
	if ($numero_factura!=0){
?>
	<h2><?=$cognoms.', '.$nom ?></h2>
	<b>NIF Facturació: <?=$nif_facturacio?></b><br />
	<b>Factura: <?= $numero_factura?> </b><br />
	<b>Data Factura: <?= $data_factura?> </b><br />
   <h3>Acciones:</h3>
	<p>
		<a href="mail_inscripcio.php?accio=I&id=<?=$id?>" target="blank">(C) Imprimir Confirmaci&oacute;</a><br />  
		<a href="mail_inscripcio.php?accio=C&id=<?=$id?>" target="blank">(EC)Enviar Confirmaci&oacute;</a><br />
	  	<a href="factura.php?id=<?=$id;?>" target="blank">(F) Factura</a><br />
		<a href="factura.php?id=<?=$id;?>&accio=S" target="blank">(EF) Enviar Factura</a><br />
	</p>
<? } 
	else 
	{  
?>
	<h1>Error.</h1>
	<h2>Aquesta inscripció no compleix les característiques necessàries per auto validar-se.</h2>
	<?if($nif_facturacio==""){
			echo "Falta el NIF facturació<br/>";
		}if($estat_factura=="F"){
			echo "Ja te estat facturada <br/>";
		}if($total==0){
			echo "El total és 0<br/>";
		}
	?>
	
<? 
	} 

?>
<br class="clear" />
</div>
</body>
</html>
