<?php
date_default_timezone_set("Europe/Madrid");

include('../vars.inc.php');
require('pdf/fpdf.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName, $DBUser,$DBPass);


error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);


class PDF extends FPDF
{


function addTitle($text){
	$this->SetFont('Arial','B',15);
    // Title
    $this->MultiCell(0,7,$text,1,'C');
    // Line break
    $this->Ln(5);
}

function addAuthors($author,$authors){
	$this->SetFont('Arial','I',10);
    // Title
    $this->MultiCell(0,5,$author.','.$authors,0,'L');
    // Line break
    $this->Ln(4);
}

function addCentre($centre){
    $this->SetFont('Arial','I',10);
    // Title
    $this->MultiCell(0,5,$centre,0,'L');
    // Line break
    $this->Ln(5);
}

function subTitle($text){
	$this->SetFont('Arial','B',12);
    // Title
    $this->Cell(0,5,$text);
    // Line break
    $this->Ln(8);
}

function addText($text){
	$this->SetFont('Arial','',10);
    // Title
    $this->MultiCell(0,7,$text);
    // Line break
    $this->Ln(5);
}


function addNum($sort){
	$this->SetFont('Arial','B',14);
    // Move to the right
    $this->Cell(0,10,"$sort");
    $this->Ln(10);
}

function addId($id){
    $this->SetFont('Arial','B',9);
    // Move to the right
    $this->Cell(0,10,"ID: $id");
    $this->Ln(10);
}

function Footer()
{

    $this->SetY(-20);
    //PosiciÃ³n: a 1,5 cm del final
    $this->Cell(180,0.5,'',0,0,'L',1);
    $this->Ln();
    $this->SetFont('Arial','',8);
    $this->Cell(0,10,utf8_decode("pàgina:").' '.$this->PageNo().'/{nb}',0,0,'C');
}


}

if(isset($_GET['tematica'])){
    $sql="select * from comunicacions where removed='N' order by comunicacio";
}else{
    $sql="select * from comunicacions where removed='N' order by if(sort = '',1,0),sort";
}
//$res=mysqli_query($con,$sql);

$pdf=new PDF("P","mm","A4");
//while ($row=mysqli_fetch_assoc($res)) {
foreach ($con->query($sql) as $row){
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->addNum($row['sort']);
    $pdf->addTitle(utf8_decode(str_replace('’','\'',$row['titol'])));
    $pdf->addId($row['id']);
    $pdf->subTitle("Autors:");
	$pdf->addAuthors(utf8_decode(str_replace('’','\'',$row['autor'])),utf8_decode(str_replace('’','\'',$row['autors'])));
    $pdf->addCentre(utf8_decode(str_replace('’','\'',$row['centre'])));
    $pdf->addCentre(utf8_decode('Pref: '.str_replace('’','\'',$row['comunicacio'])));
	$pdf->subTitle("Resum:");
	$pdf->addText(utf8_decode(str_replace(array('’','≥'),array('\'','>='),$row['resum'])));
}

$pdf->Output();
