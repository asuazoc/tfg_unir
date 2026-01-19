<?php
include('../vars.inc.php');
require('fpdf/fpdf.php');

include('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=lst_inscripcions.php");
}

if($_SESSION['rol']!='admin'){
	header("Location: control_assistencia.php");
}

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
$con->set_charset("utf8");

$pdf = new FPDF('L','mm','A3');
$pdf->AddPage();
$x=0;
$y=5.5;
$countCols=1;
$countRows=1;

$offsetAcreditacioIndividual = 143;
$offsetNom = 60;

$filtreIDs = "";
if(isset($_GET['id_inici'])&&($_GET['id_inici']!='')){
	$filtreIDs .= " AND id>= ".$_GET['id_inici'];
}
if(isset($_GET['id_fi'])&&($_GET['id_fi']!='')){
	$filtreIDs .= " AND id<= ".$_GET['id_fi'];
}

$res=mysqli_query($con,"SELECT * FROM inscripcions where ( incidencia='' OR incidencia =  'N' OR incidencia IS NULL ) ".$filtreIDs." and estat='OK' ORDER BY cg1, cg2, nom"); // and estat='OK'
while($row=mysqli_fetch_assoc($res)){
    $pdf->SetFont('Arial','B',25);
    if($countCols>4){
        $countRows++;
        $countCols=1;
        $y+=$offsetAcreditacioIndividual;
        $x=0;
    }
    if($countRows>2){
        $countRows=1;
        $y=5.5;
        $pdf->AddPage();
    }
    $pdf->Image('imgs/'.$tipo_acreditacion[$row['tipo_acreditacion']], $x, $y, 105, 0, 'PNG');

    $pdf->Image(URL_QR.sha1(PREFIX_EVENT).'_'.base64_encode($row['id']), $x+38, $y+78, 30, 0, 'PNG');

    $pdf->SetXY($x+5,$y+$offsetNom);

    $nom = strtoupper(utf8_decode($row['nom'].' '.$row['cg1'].' '.$row['cg2']));
    (strlen($nom)>28)?$pdf->SetFont('Arial','B',18):((strlen($nom)>26)?$pdf->SetFont('Arial','B',20):'');
    $pdf->MultiCell(95, 10, utf8_decode(mb_strtoupper($row['nom'].' '.$row['cg1'].' '.$row['cg2'])), 0, 'C');

		//NÚMERO D'INSCRIPCIÓ
    /*$pdf->SetFont('Arial','',24);
    //$pdf->SetXY($x+47,$y+97);
    $pdf->SetXY($x,$y+105);
    $pdf->Cell(105,5,$row['id'],0,0,'C');*/

    $x+=105;
    $countCols++;
}

$pdf->Output();
?>
