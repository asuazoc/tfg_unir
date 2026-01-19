<?
include('../vars.inc.php');
require('pdf/fpdf.php');
$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



$id=$_GET['id'];
$sql="select * from comunicacions_sessio where id=".$id;
$result=mysqli_query($con,$sql);
if (mysqli_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

$row=mysqli_fetch_assoc($result);

if($row['lang']=='en'){
	include('../lang_en.php');
	$lang = 'en';
}else{
	include('../lang_es.php');
	$lang = 'es';
}

$autor=$row['nom_contacte'];
$titol=$row['titol'];
$autorizacio_dni=$row['autorizacio_dni'];

//generation pdf

define('EURO',chr(128));
class PDF extends FPDF
	{


		function DadesEmpresa($nom,$adr,$ciutat,$nif){
		    $this->Ln(14);
		    $this->Image("logo_factura.jpg", 10, 15);
		    $this->SetFont('Arial','',10);
		    $this->Cell(0,5,utf8_decode($nom),0,0,'L');
		    $this->Ln();
		    $this->Cell(0,5,utf8_decode($adr),0,0,'L');
		    $this->Ln();
		    $this->Cell(0,5,utf8_decode($ciutat),0,0,'L');
		    $this->Ln();
		    $this->Cell(0,5,$nif,0,0,'L');
		    $this->Ln();
		}


		function DadesClient($id,$nom,$titol,$nif){
			$this->Ln(20);
			$this->SetFont('Arial','',14);
			$this->Cell(0,12,utf8_decode(TXT_AUTORIZO_TITLE),0,1,'C');
			$this->Ln(15);

			$this->SetFont('Arial','B',10);
			$this->Cell(40,10,utf8_decode(TXT_IDENTIFICADOR).":",0,0);
			$this->SetFont('Arial','',10);
			$this->Cell(0,10,utf8_decode($id),0,1);

			$this->SetFont('Arial','B',10);
			/*$this->Cell(40,10,utf8_decode(TXT_AUTORES).":",0,0);
			$this->SetFont('Arial','',10);*/
			$this->Cell(0,10,utf8_decode($nom),0,1);

			$this->SetFont('Arial','B',10);
			$this->Cell(80,10,utf8_decode(TXT_TITOL_COMUNICACIO).":",0,0);
			$this->Ln();
			$this->SetFont('Arial','',10);
			$this->MultiCell(0,8,utf8_decode($titol),0,1);

			$this->SetFont('Arial','B',10);
			$this->Cell(40,10,'DNI: ',0,0);
			$this->SetFont('Arial','',10);
			$this->Cell(0,10,utf8_decode($nif),0,1);
			$this->MultiCell(0,8,utf8_decode(TXT_AUTORIZO_PDF),0,1);

		}
	}

$pdf = new PDF();
$pdf->AddPage();
$nomEmpresa="ASOCIACIÓN DE ECONOMIA DE LA SALUD";
$adrEmpresa="C/ Bonaire, 7";
$ciutatEmpresa="08301 Mataró";
$nifEmpresa="G-58470246";
$pdf->DadesEmpresa($nomEmpresa,$adrEmpresa,$ciutatEmpresa,$nifEmpresa);
$pdf->DadesClient($id,$autor,$titol,$autorizacio_dni);
$pdf->Output();
?>
