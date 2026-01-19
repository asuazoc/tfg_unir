<?
include('../vars.inc.php');
if (!isset($_GET['auto'])) {
	include('control_doble.php');
}
include('classes/qte.class.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$accio=$_GET['accio'];
$id=$_GET['id'];
if($accio=='D'){
	$id=base64_decode($id);
	$accio='I';
}


$sql='select * from inscripcions where id='.$id;
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

if($row['lang']=='en'){
	include('../lang_en.php');
}else if($row['lang']=='ca'){
	include('../lang_ca.php');
}else{
	include('../lang_es.php');
}

//carrega la carpeta dels templates

$qte = new QTE('../templates/'.$row['lang'].'/');

//carrega un template i l'acocia a un nom

//mail_comfirmacio_inscripcio

$qte->file('comfirmacio_page','page_comfirmacio_inscripcio.htm');
$qte->file('comfirmacio_mail','mail_comfirmacio_inscripcio.htm');


$qte->variable('titol_congres',$titol_congres);
$qte->variable('dates_del_congres',$dates_del_congres);
$qte->variable('ccc',$ccc);
$qte->variable('correu_congres',$correu_congres);
$qte->variable('web_congres',$web_congres);

$lang=$row['lang'];

$qte->variable('dades',$row);

$qte->variable('hotel',$a_hotel[$row['hotel']]);
$qte->variable('dataentrada',canvia_normal($row['dataentrada']));
$qte->variable('datasortida',canvia_normal($row['datasortida']));
$qte->variable('habitacio',$txt_habitacio[$row['habitacio']][$lang]);
$qte->variable('TXT_PROTECCIO_DADES',TXT_PROTECCIO_DADES);
$qte->variable('TXT_PROTECCIO_DADES_TITOL',TXT_PROTECCIO_DADES_TITOL);
$qte->variable('txt_aclariment_justificant',TXT_ACLARIMENT_JUSTIFICANT);
$qte->variable('tipus_inscripcio',$a_inscripcio[$row['id_inscripcio']][$row['lang']]);

if ($accio=='I'){
	$qte->parse('comfirmacio_page');
}
elseif($accio=='C') {
	$mail=$qte->parse('comfirmacio_mail',"return");
	$headers ="From: $titol_correu<$correu_congres>\n";
	$headers .="X-Sender:<$correu_congres>\n";
	$headers .="X-Mailer: PHP\n"; //mailer $headers .="X-Priority: 1\n"; //1 UrgentMessage, 3 Normal
	$headers .="Return-Path:<$correu_congres>\n";
	$headers .="Content-Type: text/html; charset=utf-8\n"; //para enviarlo en formato HTML
	$to=$row['email'].','.$correu_congres;
	$err=sendMail($to,$correu_congres,$titol_congres_mail,$mail);
	if ($err)
		$txt= "El correu s'ha enviat correctament<br>";
	else
		$txt= "Hi ha un problema al servidor de correu no s'ha enviat el correu.<br>";
	echo $txt;
}
?>
