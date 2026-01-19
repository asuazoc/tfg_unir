<?
include('../vars.inc.php');
include('classes/qte.class.php');
ini_set('display_errors',0);

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$id=$_GET['id'];

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
$qte->file('justificant_page','page_justificant_inscripcio.htm');
$qte->file('justificant_mail','mail_justificant_inscripcio.htm');


$qte->variable('titol_congres',$titol_congres);
$qte->variable('dates_del_congres',$dates_del_congres);
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
if(($row['id_inscripcio']=='ES')||($row['id_inscripcio']=='EN')){
	$qte->variable('TXT_CONFIRMACIO_ESTUDIANTE',TXT_CONFIRMACIO_ESTUDIANTE);
}else{
	$qte->variable('TXT_CONFIRMACIO_ESTUDIANTE','');
}


$forma_pagament='<h3>'.TXT_FORMA_PAGAMENT_TITOL.'</h3>
        <p>
          '.TXT_FORMA_PAGAMENT.'<br /><br />
          <b>'.TXT_NUM_COMPTE.'</b> '.$ccc.'<br />
          <b>'.TXT_IBAN.'</b> '.$iban.'<br />
          <b>'.TXT_SWIFT_CODE.'</b> '.$swift_code.'<br />
          <br />
          '.TXT_FORMA_PAGAMENT2.'
          <br />
          <br />
          '.TXT_FIRMA.'
          <br />
          '.$correu_congres.'
          <br />
          <br />
        </p>';
$forma_pagament='';

$qte->variable('forma_pagament',$forma_pagament);

$politica_cancelacions = '<h2>'.TXT_POLITICA_CANCELACIONS_TITOL.'</h2>'.TXT_POLITICA_CANCELACIONS;
$qte->variable('politica_cancelacions',$politica_cancelacions);

$excepcions = '<h2>'.TXT_EXCEPCIONS_TITOL.'</h2>'.TXT_EXCEPCIONS;
$qte->variable('excepcions',$excepcions);

//banc
$qte->variable('ccc',$ccc);
$qte->variable('banc',$banc);
$qte->variable('ref_ccc',$ref_ccc);

//Usuari i contrasenya
$txt_info_usuari_password = TXT_INFO_USUARI_PASSWORD1.$row['usuari'].TXT_INFO_USUARI_PASSWORD2.$row['password'].TXT_INFO_USUARI_PASSWORD3;
$txt_info_usuari_password = '';
$qte->variable('txt_info_usuari_password',$txt_info_usuari_password);

//Agafa el resultat
//sense el return trau el resultat directe
$qte->parse('justificant_page');

if($_GET['accio']=='I'){
	$mail=$qte->parse('justificant_mail',"return");
	$headers ="From: <$correu_congres>\n";
	$headers .="X-Sender:<$correu_congres>\n";
	$headers .="X-Mailer: PHP\n"; //mailer $headers .="X-Priority: 1\n"; //1 UrgentMessage, 3 Normal
	$headers .="Return-Path:<$correu_congres>\n";
	$headers .="Content-Type: text/html; charset=utf-8\n"; //para enviarlo en formato HTML

	//$err=mail($row['email'].','.$correu_congres_inscripcions,$titol_congres_mail,$mail,$headers);
	$to=$row['email'].','.$correu_congres;
	$err=sendMail($to,$correu_congres,$titol_congres_mail,$mail);
	if (!$err)
		header("Location: $missatge_ko");
}
?>
