<?
//ob_start();
//error_reporting(E_ALL);

include('../vars.inc.php');
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors',0);

require('pdf/fpdf.php');
define('EURO',chr(128));

class PDF extends FPDF{

	function certificat($tipus,$titol,$noms,$lloctreball){

    $this->Image("images/certificat_comunicacio.png", 0, 0, 210);
    if($tipus=='poster'){
      $txt = "EL COMITÈ CIENTÍFIC CERTIFICA QUE EL PÒSTER:";
      $txt2 = "HA ESTAT PRESENTAT";
    }else if($tipus=='oral_breu'){
      $txt = "EL COMITÈ CIENTÍFIC CERTIFICA QUE LA COMUNICACIÓ ORAL BREU:";
      $txt2 = "HA ESTAT PRESENTADA";
    }else if($tipus=='oral'){
      $txt = "EL COMITÈ CIENTÍFIC CERTIFICA QUE LA COMUNICACIÓ ORAL:";
      $txt2 = "HA ESTAT PRESENTADA";
    }else{
      $txt = "";
      $txt2 = "";
    }
    /*$this->SetTextColor(24,88,154);
    $this->SetFont('Arial','B',13);
	 	$this->SetY(75);
    $this->Cell(0,5,utf8_decode($txt),0,0,'C');
		$this->Ln(10);*/

    $this->SetTextColor(148,55,52);
    $this->SetFont('Arial','B',16);
    $this->SetY(74);
    $this->SetX(25);
    $this->MultiCell(160,5,utf8_decode(str_replace('’','\'',$titol)),0,'C');

    $this->SetTextColor(148,55,52);
    $this->SetFont('Arial','B',11);
    $this->SetX(30);
    $this->MultiCell(150,5,utf8_decode($noms),0,'C');
    $this->SetX(30);
    $this->MultiCell(150,5,utf8_decode($lloctreball),0,'C');

    /*$this->SetY(112);
    $this->SetTextColor(201,153,83);
    $this->SetFont('Arial','B',13);
    $this->Cell(0,5,utf8_decode($txt2),0,0,'C');*/
	}
}


/*mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName, $DBUser,$DBPass);

$accio=null;
if(isset($_GET['accio'])){
    $accio=$_GET['accio'];
}
$id=$_GET['id'];

$sql='select * from comunicacions where id='.$id;
/*$res=mysql_query($sql);
$row=mysql_fetch_assoc($res);*/
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

$pdf=new PDF("P","mm","A4");
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->certificat($row['comunicacio'],$row['titol'],$row['autors'],$row['centre']);


//ob_end_clean();

if ($accio=='S'){
	$to=$row['email'];
	$from=$correu_congres;
	$subject=$titol_correu;
  	$message="Apreciado/a Sr./Sra ".$row['nom']." ".$row['cg1'].",<br/><br/>
Adjuntamos el certificado de la comunicación presentada a las ".$titol_congres.".<br/><br/>
Reciba un cordial saludo<br/><br/>
Secretaría técnica";
	if(sendMail($to,$from,$subject,$message,$pdf,"certificat")){
		echo "<h1>Informació Enviada Correctament</h1>";
	}else{
		echo "<h1>No s'ha pogut enviar el correu</h1>";
	}
} else{
	ob_clean();
	$pdf->Output();
  ob_end_flush();
}
?>
