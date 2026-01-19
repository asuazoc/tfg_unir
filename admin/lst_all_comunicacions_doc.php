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


$sql="select * from comunicacions where removed='N' order by if(sort = '',1,0),sort";
//$res=mysqli_query($con,$sql);

//$pdf=new PDF("P","mm","A4");
//while ($row=mysqli_fetch_assoc($res)) {

header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Report.docx");

foreach ($con->query($sql) as $row){
	//$pdf->AliasNbPages();
	//$pdf->AddPage();

    $pdf .= "<b>".$row['sort']."</b><br/><br/>"; //$pdf->addNum($row['sort']);
    
    $pdf .= "<b>".(str_replace('’','\'',$row['titol']))."</b><br/><br/>"; //$pdf->addTitle(utf8_decode(str_replace('’','\'',$row['titol'])));

    $pdf .= "<b>"."ID: ".$row['id']."</b><br/><br/>"; //$pdf->addId($row['id']);

    $pdf .= "<b>Autors: </b>"; //$pdf->subTitle("Autors:");

	$pdf .= (str_replace('’','\'',$row['autor'])).', '.(str_replace('’','\'',$row['autors']))."<br/><br/>"; //$pdf->addAuthors(utf8_decode(str_replace('’','\'',$row['autor'])),utf8_decode(str_replace('’','\'',$row['autors'])));
    
    $pdf .= (str_replace('’','\'',$row['centre']))."<br/><br/>"; //$pdf->addCentre(utf8_decode(str_replace('’','\'',$row['centre'])));
	
    $pdf .= "<b>Resum: </b>"; //$pdf->subTitle("Resum:");
	
    $pdf .= (str_replace(array('’','≥'),array('\'','>='),$row['resum']))."<br/><hr/><br/><br/><br/>"; //$pdf->addText(utf8_decode(str_replace(array('’','≥'),array('\'','>='),$row['resum'])));
    
}

echo $pdf;
//$pdf->Output();
