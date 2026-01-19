<?php

//ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set("Europe/Madrid");

require('pdf/fpdf.php');
include('../vars.inc.php');

class PDF extends FPDF{
	private $mesos = array('1'=>'Enero','2'=>'Febrero','3'=>'Marzo','4'=>'Abril','5'=>'Mayo',
		'6'=>'Junio','7'=>'Julio','8'=>'Agosto','9'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre',
		'12'=>'Diciembre');

	function certificatCurs($nomParticipant,$data_certificats){

	    $this->Image("certificat.jpg", 0, 0, 210);
	    $this->SetFont('Arial','',15);
	 	$this->SetXY(20,50);
	    $this->Cell(0,5,'',0,0,'L');
	    //$this->Cell(0,5,'Certificamos que: ',0,0,'L');
		$this->Ln(35);
	 	$this->SetFont('Arial','B',25);
	 	$this->SetTextColor(148,55,52);
		$this->Cell(0,5,($nomParticipant),0,0,'C');
	}

	function certificatReunio($nomParticipant,$data_certificats){

	    $this->Ln(14);
	    $this->Image("cep.jpg", 10, 15);
	    $this->Image("cst.jpg", 135, 15);
	    $this->SetFont('Arial','',15);
	 	 $this->SetXY(20,80);
	    $this->Cell(0,5,'Certificamos que: ',0,0,'L');
		 $this->Ln();
	 	 $this->Ln();
	 	 $this->SetFont('Arial','B',20);
		 $this->Cell(0,5,utf8_decode($nomParticipant),0,0,'C');
		 $this->Ln();
	 	 $this->Ln();
 		 $this->Ln();
	 	 $this->Ln();
 	 	 $this->SetFont('Arial','',15);
		 $this->Cell(0,5,utf8_decode('ha asistido a la'),0,0,'C');
		 $this->Ln();
	 	 $this->Ln();
 		 $this->Ln();
	 	 $this->Ln();
 	 	 $this->SetFont('Arial','I',15);
		 $this->Cell(0,5,utf8_decode('XIII REUNIÓN DEL CLUB ESPAÑOL PANCREÁTICO'),0,0,'C');
		 $this->Ln();
		 $this->SetFont('Arial','I',14);
		 $this->Cell(0,5,utf8_decode('Colegio Oficial de Médicos de Barcelona'),0,0,'C');
		 $this->Ln();
		 $this->SetFont('Arial','I',14);
		 $this->Cell(0,5,utf8_decode('20 y 21 de septiembre de 2013'),0,0,'C');
		 $this->Ln();
	 	 $this->Ln();
 		 $this->Ln();
	 	 $this->Ln();
		 $this->SetFont('Arial','',12);
		 $this->Cell(0,5,utf8_decode('Acreditado con 1.1 créditos por el Consell Català de Formació Continuada de les'),0,0,'C');
		 $this->Ln();
		 $this->Cell(0,5,utf8_decode('Professions Sanitàries / Comisión de Formación Continuada del Sistema Nacional de Salud.'),0,0,'C');
		 $this->Ln();
		 $this->Cell(0,5,utf8_decode('(Ref. 09/08616-MD)'),0,0,'C');
		 $this->Image("ofo.jpg", 57,177);
		 $this->SetXY(20,210);
		 $this->Ln();
		 $this->SetFont('Arial','',14);
		 $this->Cell(0,5,utf8_decode('Barcelona, '.date('j',$data_certificats).' de '.$this->mesos[date('n',$data_certificats)].' de '.date('Y',$data_certificats)),0,0,'C');
		 $this->Image("signaturaReunio.jpg", 80,230);
		 $this->SetXY(20,258);
		 $this->Ln();
		 $this->SetFont('Arial','',13);
		 $this->Cell(0,5,utf8_decode('Dr. Jaume Boadas'),0,0,'C');
		 $this->Ln();
		 $this->SetFont('Arial','',12);
		 $this->Cell(0,5,utf8_decode('Coordinador de la Reunión'),0,0,'C');

	}

}


$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName, $DBUser,$DBPass);

$id = $_GET['id'];
$id = base64_decode($id);
//$tipus = $_GET['tipus'];
//if(($tipus=='R')||($tipus=='C')){
	$sql='select * from inscripcions where id='.$id;

	$res = $con->query($sql);

	$row = $res->fetch(PDO::FETCH_ASSOC);

	$pdf=new PDF("P","mm","A4");
	$pdf->AddPage();
	$pdf->AliasNbPages();

	$nomParticipant = utf8_decode($row['nom'].' '.$row['cg1'].' '.$row['cg2']);
	/*if($tipus=='R'){
		$pdf->certificatReunio($nomParticipant,$data_certificats_pdf);
		$pdf->Output();
	}else if($tipus=='C'){*/
		ob_start();
		$pdf->certificatCurs($nomParticipant,$data_certificats_pdf);
		$pdf->Output();
		ob_end_flush();
	//}

//}


?>
