<?php
include('../vars.inc.php');
include('control.php');

error_reporting(E_ALL);
ini_set('display_errors', 0);

$count = 0;
$aResultat = array("error"=>0);
$limit = $_GET['limit'];
$offset = $_GET['offset'];
try {
	$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName);
	$sql = "SELECT * FROM inscripcions where certificat_assist='S' AND PENDENT=0 ORDER BY id LIMIT ".$limit." OFFSET ".$offset."";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
		$mail = "Apreciado/a Sr./Sra ".$row['nom']." ".$row['cg1'].",<br/><br/>
Ya está disponible la descarga de su certificado de asistencia a las ".$titol_congres.".<br/><br/>
Enlace: <a href=\"".$adreca_tpv."/documents\" targer=\"_blank\">Área privada</a><br/>
Usuario: ".$row['usuari']."<br/>
Contraseña: ".$row['password']."<br/><br/>
Reciba un cordial saludo<br/><br/>
Secretaría técnica";
		$to= $row['email2'];
		$assumpte= 'Descarga certificado de asistencia '.$titol_congres_mail;
		if(sendMail($to,$correu_congres_inscripcions,$assumpte,$mail,0,0)){
			$count++;
			$log  = "OK - ID:".$row['id'].' - '.$to." - ".date("Y-m-d H:i:s").PHP_EOL;
		}else{
			$log  = "KO - ID:".$row['id'].' - '.$to." - ".date("Y-m-d H:i:s").PHP_EOL;
		}
		file_put_contents('mail.log', $log, FILE_APPEND);
	}
} catch (Exception $e) {
	$aResultat['error'] = 1;
	$aResultat['txterror'] = $e->getMessage();
}
$aResultat['total'] = $count;
echo json_encode($aResultat);
?>
