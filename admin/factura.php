<?
include('../vars.inc.php');

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors',0);

include('../lang_es.php');
if (!isset($_GET['auto'])) {
	include('control_doble.php');
}
require('pdf/fpdf.php');
define('EURO',chr(128));
include('mail_factura.php');


$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");


$accio=$_GET['accio'] ?? 0;
$id=$_GET['id'];
if($accio=='D'){
	$id=base64_decode($id);
}


function sendFacturaMail($to,$from,$subject,$message,$pdf,$numFactura){
	$result = sendMail($to,$from,$subject,$message,$pdf,$numFactura);
	return $result;
}


class PDF extends FPDF
{


function Footer()
{

    $this->SetY(-20);
    //Posición: a 1,5 cm del final
    $this->Cell(180,0.5,'',0,0,'L',1);
    $this->Ln();
    $this->SetFont('Arial','',8);
    $this->Cell(0,10,utf8_decode("pàgina:").' '.$this->PageNo().'/{nb}',0,0,'C');
}




function DadesEmpresa($nom,$adr,$ciutat,$nif,$data){



    $this->Ln(14);
    //$this->Image("logo_factura.jpg", 10, 15);
    $this->SetFont('Arial','',10);
 	 $this->Cell(0,5,utf8_decode($nom),0,0,'L');
	 $this->Ln();
	 $this->Cell(0,5,utf8_decode($adr),0,0,'L');
	 $this->Ln();
	 $this->Cell(0,5,utf8_decode($ciutat),0,0,'L');
	 $this->Ln();
	 $this->Cell(0,5,$nif,0,0,'L');
    $this->Ln();
    $this->Cell(0,5,TXT_DATA_FACTURA.': '.$data,0,0,'L');
	 $this->Ln();
}

function DadesClient($nom,$adr,$ciutat,$nif,$cp,$provincia,$tel){
    $this->Ln(4);
    $this->SetFont('Arial','B',10);
 	 $this->Cell(0,5,utf8_decode(TXT_DADES_CLIENT),0,0,'L');
	 $this->Ln();
    $this->Cell(180,0.5,'',0,0,'L',1);
	 $this->Ln();
    $this->Ln();
	 $this->SetFont('Arial','',10);
	 $this->Cell(80,5,utf8_decode(TXT_RAO_SOCIAL).":",0,0,'L');
	 $this->Cell(0,5,$nom,0,0,'L');
	 $this->Ln();
 	 $this->Cell(80,5,TXT_NIF.":",0,0,'L');
	 $this->Cell(0,5,$nif,0,0,'L');
	 $this->Ln();
 	 $this->Cell(80,5,utf8_decode(TXT_ADRECA_FISCAL).":",0,0,'L');
	 $this->Cell(0,5,$adr,0,0,'L');
	 $this->Ln();
 	 $this->Cell(80,5,utf8_decode(TXT_LOCALITAT).":",0,0,'L');
	 $this->Cell(0,5,$ciutat,0,0,'L');
	 $this->Ln();
 	 $this->Cell(80,5,utf8_decode(TXT_CP).":",0,0,'L');
	 $this->Cell(0,5,$cp,0,0,'L');
	 $this->Ln();
	 $this->Cell(80,5,utf8_decode(TXT_PROVINCIA).":",0,0,'L');
	 $this->Cell(0,5,$provincia,0,0,'L');
	 $this->Ln();
 	 $this->Cell(80,5,utf8_decode(TXT_TEL_PARTICULAR).":",0,0,'L');
	 $this->Cell(0,5,$tel,0,0,'L');
	 $this->Ln();
}



function DadesInscripcio($nom,$tipus,$valor){
    $this->Ln();
    $this->SetFont('Arial','B',10);
    $this->Cell(40,5,utf8_decode(TXT_INSCRIPCIO).":",0,0,'L',0);
    $this->Cell(140,5,$valor.' '.EURO,0,0,'R',0);
    $this->Ln();
    $this->Cell(180,0.5,'',0,0,'L',1);
    $this->Ln();
    $this->SetFont('Arial','',10);
    $this->Cell(0,5,$nom,0,0,'L',0);
    $this->Ln();
    $this->Cell(0,5,utf8_decode($tipus),0,0,'L',0);
    $this->Ln();
}

function DadesAcompanyant($valor){
    $this->Ln();
    $this->SetFont('Arial','B',10);
    $this->Cell(40,5,utf8_decode("Acompañante a la cena de la Jornada el 17 de mayo:"),0,0,'L',0);
    $this->Cell(140,5,$valor.' '.EURO,0,0,'R',0);
    $this->Ln();
    $this->Cell(180,0.5,'',0,0,'L',1);
    $this->Ln();
}


function DadesAllotjament($hotel,$habitacio,$entrada,$sortida,$nits,$valor){
    $this->Ln();
    $this->SetFont('Arial','B',10);
 	 $this->Cell(40,5,utf8_decode(TXT_ALLOTJAMENT).":",0,0,'L',0);
    $this->Cell(140,5,$valor.' '.EURO,0,0,'R',0);
	 $this->Ln();
    $this->Cell(180,0.5,'',0,0,'L',1);
    $this->Ln();
    $this->SetFont('Arial','',10);

	 $this->Cell(0,5,utf8_decode($hotel),0,0,'L');
	 $this->Ln();

	 $this->Cell(60,5,utf8_decode(TXT_DATA_ENTRADA).":",0,0,'L');
	 $this->Cell(0,5,$entrada,0,0,'L');
	 $this->Ln();
	  	 $this->Cell(60,5,utf8_decode(TXT_DATA_SORTIDA).":",0,0,'L');
	 $this->Cell(0,5,$sortida,0,0,'L');
	 $this->Ln();
	  	 $this->Cell(60,5,utf8_decode(TXT_NITS).":",0,0,'L');
	 $this->Cell(0,5,$nits,0,0,'L');
	 $this->Ln();
	  	 $this->Cell(60,5,utf8_decode(TXT_TIPUS_HABITACIO).":",0,0,'L');
	 $this->Cell(0,5,utf8_decode($habitacio),0,0,'L');
	 $this->Ln();

}

function NumFactura($num){
    $this->Ln();
    $this->SetFont('Arial','B',12);
 	 $this->Cell(0,5,"FACTURA   ".$num,0,0,'L');
	 $this->Ln();
}


function InfoFactura($info){
	 $this->Ln();
    $this->SetFont('Arial','B',10);
 	 $this->MultiCell(0,5,utf8_decode($info));
	 $this->Ln();

}


function InfoConceptes(){
	 $this->Ln();
    $this->SetFont('Arial','B',10);
 	 $this->MultiCell(0,5,utf8_decode(TXT_CONCEPTES).":");
	 $this->Ln();

}

function Costos($subtotal,$iva,$total){
	 $this->Ln(20);
    $this->SetFont('Arial','B',10);
    $this->Cell(140);
 	 $this->Cell(20,5,'SUBTOTAL',0,0,'L');
 	 $this->Cell(20,5,$subtotal.' '.EURO,0,0,'R');
	 $this->Ln();
	 $this->Cell(140);
	 $this->Cell(20,5,'21% IVA',0,0,'L');
	 $this->Cell(20,5,$iva.' '.EURO,0,0,'R');
	 $this->Ln();
	 $this->Cell(140);
	 $this->Cell(20,5,'TOTAL',0,0,'L');
	 $this->Cell(20,5,$total.' '.EURO,0,0,'R');
	 $this->Ln();

}



}


$sql='select * from inscripcions where id='.$id;
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);


$nomEmpresa="UNIR";
$adrEmpresa="Av. de la Paz, 137";
$ciutatEmpresa="26006 Logroño, La Rioja";
$nifEmpresa="G-12345678";
$data_factura=canvia_normal($row['data_factura']);

$nomClient=utf8_decode($row['nom_facturacio']) ;
$adrClient=utf8_decode($row['adresa_facturacio']);
$ciutatClient=utf8_decode($row['localitat_facturacio']);
$nifClient=$row['nif_facturacio'];
$cpClient=$row['cp_facturacio'];
$provinciaClient=utf8_decode($row['provincia_facturacio']);
$telClient=$row['tel_facturacio'];


$numFactura=$codi_facturacio."-".$row['numero_factura'];

$info=$titol_factura."\n".$dates_congres[$row['lang']];

//$nomInscripcio=$row['tractament'].' '.$row['nom'].' '.$row['cognoms'];
$nomInscripcio=utf8_decode($row['nom'].' '.$row['cg1'].' '.$row['cg2']);
$tipusInscripcio=$a_inscripcio[$row['id_inscripcio']][$row['lang']];

$valorInscripcio= truncate(($row['total_inscripcio'])/1.21);

$hotel=$a_hotel[$row['hotel']];
$habitacio=$a_habitacio[$row['habitacio']];
$entrada=canvia_normal($row['dataentrada']);
$sortida=canvia_normal($row['datasortida']);
$nits=$row['nits'];
$valor=truncate($row['total_allotjament']/1.21);
$subtotal=(float)truncate( ($row['total_inscripcio']+$row['total_allotjament']+$row['total_sopar'])/1.21);
$total=(float)truncate($row['total_inscripcio']+$row['total_allotjament']+$row['total_sopar']);
$pos = strrpos($total, '.');
if ($pos === false) { // note: three equal signs
   $total.='.00';
}
$iva=(($row['total_inscripcio']+$row['total_allotjament']+$row['total_sopar'])-$subtotal);

$pdf=new PDF("P","mm","A4");
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->DadesEmpresa($nomEmpresa,$adrEmpresa,$ciutatEmpresa,$nifEmpresa,$data_factura);
$pdf->DadesClient($nomClient,$adrClient,$ciutatClient,$nifClient,$cpClient,$provinciaClient,$telClient);
$pdf->NumFactura($numFactura);
$pdf->InfoFactura($info);
$pdf->InfoConceptes();
$pdf->DadesInscripcio($nomInscripcio,$tipusInscripcio,$valorInscripcio);
if ($row['acomp_sopar']=='Si'){
	$pdf->DadesAcompanyant(number_format(($row['total_sopar']/1.21), 2, '.', ' '));
}
if ($nits>0){
	$pdf->DadesAllotjament($hotel,$habitacio,$entrada,$sortida,$nits,$valor);
}

$pdf->Costos($subtotal,$iva,$total);

$pdf->Ln();
$pdf->Ln();
if ($row['acomp_sopar']=='No'){
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
}
if ($nits==0){
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
}
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(180,5,utf8_decode(TXT_PEU_FACTURA),1,'L');
$pdf->Ln();

//ob_end_clean();

if ($accio=='S'){
	$to=$row['email'].','.$correu_congres;
	$from=$correu_congres;
	$subject=$titol_correu;
	sendFacturaMail($to,$from,$subject,$message,$pdf,$numFactura);
	echo "<h1>Informació Enviada Correctament</h1>";
} else{
	$pdf->Output();
}
?>
