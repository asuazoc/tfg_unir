<?error_reporting(E_ALL);
ini_set('display_errors', 0);
//include(dirname(__FILE__) . '/lang_es_en.php');
date_default_timezone_set('Europe/Madrid');

/* Improve PHP configuration to prevent issues */
@ini_set('display_errors', 'off');
@ini_set('upload_max_filesize', '10M');
@ini_set('default_charset', 'utf-8');

/* Correct Apache charset */
header('Content-Type: text/html; charset=utf-8');

//configuracio basica

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors',1);

//crec que aquí no serveix per a res
//"SET NAMES UTF8"

//configuracio BD
$DBHost="mysql.HOSTNAME.com";
$DBUser="USER";
$DBPass="PASS";
$DBName="tfgunir25";

////////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////
function canvia_normal($fecha){
    if (empty($fecha))
	return "";
    //preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
    $mifecha = explode('-',$fecha);
    $lafecha=$mifecha[2]."/".$mifecha[1]."/".$mifecha[0];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function  canvia_mysql($fecha){
    if (empty($fecha))
  return "";
    //ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $mifecha = explode('/',$fecha);
    $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
    return $lafecha;
}


function truncate ($num, $digits = 2) {
  //provide the real number, and the number of
  //digits right of the decimal you want to keep.
  $shift = pow(10, $digits);
  return ((floor($num * $shift)) / $shift);
}

function cercaNumFacturaValid(){
  global $DBHost,$DBUser,$DBPass,$DBName;
  /*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
  */
  $con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
  $i=1;
  $flag=1;
  while($flag){
    $sql="select 1 trobat from inscripcions where numero_factura=$i";
    $result = $con->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if (!isset($row['trobat'])){
      $flag=0;
      return $i;
    }
    $i++;
  }

}

function sendMail($to,$from,$subject,$message,$pdf=0,$num=0,$file_estudiant=0,$pdfEtica=0,$extra_file=0){
  include_once("class.phpmailer.php");
  include_once("class.smtp.php");
  //require 'PHPMailer.php';
  //require 'SMTP.php';


  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;

  //Nova configuració correu
  $mail->Host = "smtp.HOSTNAME.com";
  $mail->Username = "admin@tfgunir.HOSTNAME.com";
  $mail->Password = "MAIL_PASS";

  /*$mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false
      )
  );*/

  $mail->SMTPDebug  = 0;

  $mail->From = "admin@tfgunir.HOSTNAME.com";

  $mail->FromName = "Jornada UNIR";

  $mail->Subject = utf8_decode($subject);
  $mail->AltBody = utf8_decode($subject);
  $mail->MsgHTML(utf8_decode($message));

  if($pdf){
    $pdf->Output('pdfs/'.$num.'Aut.pdf', 'F');
    $mail->AddAttachment('pdfs/'.$num.'Aut.pdf');
  }

  if($file_estudiant){
    $mail->AddAttachment($file_estudiant);
  }

  if($extra_file){
    $mail->AddAttachment($extra_file);
  }

  if($pdfEtica){
    $pdfEtica->Output('pdfs/'.$num.'Eti.pdf', 'F');
    $mail->AddAttachment('pdfs/'.$num.'Eti.pdf');
  }

  $tTo = explode(',',$to);
  foreach($tTo as $aTo){
    $mail->AddAddress($aTo);
  }

  $tFrom = explode(',',$from);
  foreach($tFrom as $aFrom){
    $mail->AddReplyTo($aFrom);
  }

  $mail->IsHTML(true);
  if($mail->Send()) {
    return 1;
  }else{
    echo "<H1>Mailer Error: " . $mail->ErrorInfo.'</H1>';
    return 0;
  }
}


$titol_congres="Jornadas de Informática UNIR";
$titol_correu=$titol_congres;
$titol_congres_mail=$titol_congres;


$correu_congres="adriasuazo@HOSTNAME.com";
$correu_congres_comunicacions="adriasuazo@HOSTNAME.com";
$correu_congres_secretaria="adriasuazo@HOSTNAME.com";

//Número màxim de comunicacions per NIF
$maxComunicacions = 3;

//Banc
$banc="BANCO SABADELL";
$ref_ccc="JORNADA UNIR";
$ccc="0081-0105-11-0001234567";
$iban="ES0900810105110001234567";
$swift_code="BSABESBBXXX";


$web_congres="#";
$adreca_admin_web="https://tfgunir.HOSTNAME.com/backend_gestio";
$adreca_tpv="https://tfgunir.HOSTNAME.com/backend_gestio";


$missatge_ok=" #";
$missatge_ko=" #";

$a_categoria['A']="Assistente";
$a_categoria['P']="Ponent Jornada";
$a_categoria['M']="Moderador Jornada";
$a_categoria['C']="Comité Cientific/organitzador";
$a_categoria['E']="Expositor Casa Comercial";

//dades facturacio
$codi_facturacio="FUNIR26";
$titol_factura="Jornadas de Informática UNIR";
$dates_del_congres="Logroño. 20 al 22 de marzo de 2026.";
$dates_congres['es']="Logroño. 20 al 22 de marzo de 2026.";

//tipus inscipcio
$a_inscripcio['GN']['es']="General";
$a_inscripcio['ES']['es']="Estudiantes";


//preu incripcio
$inscripcio['GN'][1]=350;
$inscripcio['GN'][2]=400;
$inscripcio['ES'][1]=100;
$inscripcio['ES'][2]=150;

$maxSopar = 110;
$preu_sopar_acomp = 60;

// Matriu de noms Hotel
$a_hotel['HSC']="Sercotel Calle Mayor ****";
$a_hotel['HEF']="Eurostars Fuerte Ruavieja ****";

//matriu noms d'habitacions d'hotel
$a_habitacio['DUI']="Habitación doble de uso individual / Double room for single use";
$a_habitacio['DOB']="Habitación doble / Double room";

$txt_habitacio['DUI']['es']="Habitación doble de uso individual";
$txt_habitacio['DOB']['es']="Habitación doble";
$txt_habitacio['DUI']['ca']="Habitació doble d'us individual";
$txt_habitacio['DOB']['ca']="Habitació doble";
$txt_habitacio['DUI']['en']="Double room for single use";
$txt_habitacio['DOB']['en']="Double room";

//Preu allotjament
$allotjament['HSC']['DUI']=148.50;
$allotjament['HSC']['DOB']=159.50;
$allotjament['HEF']['DUI']=198.50;
$allotjament['HEF']['DOB']=215.50;

//Num reserves Reserves
$r_hotel['HPE']['17/06/2026']=10;
$r_hotel['HPE']['18/06/2026']=20;
$r_hotel['HPE']['19/06/2026']=20;

$r_hotel['HGV']['17/06/2026']=5;
$r_hotel['HGV']['18/06/2026']=15;
$r_hotel['HGV']['19/06/2026']=15;


//data de tall
//int mktime  ([ int $hour  [, int $minute  [, int $second  [, int $month  [, int $day  [, int $year  [, int $is_dst  ]]]]]]] )

$datatall_inscripcions=mktime(0,0,0,4,22,2026);  //no n'hi ha
$datatall_allotjament=mktime(0,0,0,6,23,2026); //no n'hi ha

$data_final_comunicacions=mktime(0,0,0,2,10,2026);

$data_final_allotjament=mktime(0,0,0,6,13,2026);
$data_final_inscripcions=mktime(0,0,0,3,22,2026); //no n'hi ha

//Marca la data de fien que els avaluadors poden posar notes
$data_final_avaluacio=mktime(23,59,59,3,3,2026);
$data_final_revisio=mktime(23,59,59,3,15,2021); //obert fins que ens avisen
$data_final_revisio2=mktime(23,59,59,4,10,2015);

$comunicacio_activa=true;
$comunicacio=array();
$comunicacio['igual']=array('es'=>'Indiferente');
$comunicacio['comunicacio']=array('es'=>'Comunicación oral');
$comunicacio['poster']=array('es'=>'Póster');
$comunicacio['rechazada']=array('es'=>'Rechazada');

$siNo['S']=array('es'=>'Si','ca'=>'Sí','en'=>'Yes');
$siNo['N']=array('es'=>'No','ca'=>'No','en'=>'No');
$siNo['Si']=array('es'=>'Si','ca'=>'Sí','en'=>'Yes');
$siNo['No']=array('es'=>'No','ca'=>'No','en'=>'No');

$comunicacio_eval=array();
$comunicacio_eval['igual']='Igual';
$comunicacio_eval['comunicacio_larga']='Comunicación larga';
$comunicacio_eval['poster']='Póster';
$comunicacio_eval['rechazada']='Rechazada';

$comunicacio_lang=array();
$comunicacio_lang['ES']='Castellano / Spanish';
$comunicacio_lang['EN']='Inglés/ English';
$comunicacio_lang['IN']='Indiferente/Indifferent';

$comunicacio_lang2=array();
$comunicacio_lang2['ES']['es']='Castellano';
$comunicacio_lang2['EN']['es']='Inglés';
$comunicacio_lang2['IN']['es']='Indiferente.';


$comunicacio_tips = array();
$comunicacio_tips['ES']['es']='';
$comunicacio_tips['EN']['es']='';
$comunicacio_tips['IN']['es']='';

$paraules_clau=array("1"=>array('es'=>"Calidad y Auditoría de Sistemas de Información"),
"2"=>array('es'=>"Deontología y Legislación Informática"),
"3"=>array('es'=>"Fundamentos de la Empresa"),
"4"=>array('es'=>"Informática Gráfica y Visualización"),
"5"=>array('es'=>"Integración de Sistemas"),
"6"=>array('es'=>"Procesos en Ingeniería del Software"),
"7"=>array('es'=>"Trabajo Fin de Grado")
);

/*CONTROL ASSISTENCIA*/
define("CARPETA_WEB", "/backend_gestio/assistencia");
define("PREFIX_EVENT", "unir26");
define("SESSIO_CONTROL", "unir26");

define("ENVIO_MAILS_ACTIVO", false); //CANVIAR EL COS DEL MISSATGE ABANS D'ACTIVAR
define("REGISTRO_ASISTENCIA_ACTIVO", true);

$num_periodes = 4; // especifica el número de vegades que s'escanejarà el QR durant la jornada

$periodes_assist['7'] = array('nom'=>'Entrada dia 05/01/2026','inici'=>mktime(14, 30, 0, 1, 5, 2026), 'fi'=>mktime(17, 0, 0, 1, 5, 2026), null);
$periodes_assist['1'] = array('nom'=>'Entrada dia 20/03/2026','inici'=>mktime(8, 30, 0, 3, 20, 2026), 'fi'=>mktime(11, 0, 0, 3, 20, 2026), null);
$periodes_assist['2'] = array('nom'=>'Salida dia 20/03/2026','inici'=>mktime(19, 0, 0, 3, 20, 2026), 'fi'=>mktime(20, 0, 0, 3, 20, 2026), null);
$periodes_assist['3'] = array('nom'=>'Entrada dia 21/03/2026','inici'=>mktime(8, 30, 0, 3, 21, 2026), 'fi'=>mktime(9, 30, 0, 3, 21, 2026), null);
$periodes_assist['4'] = array('nom'=>'Salida dia 21/03/2026','inici'=>mktime(19, 0, 0, 3, 21, 2026), 'fi'=>mktime(20, 0, 0, 3, 21, 2026), null);
$periodes_assist['5'] = array('nom'=>'Entrada dia 22/03/2026','inici'=>mktime(8, 30, 0, 3, 22, 2026), 'fi'=>mktime(9, 30, 0, 3, 22, 2026), null);
$periodes_assist['6'] = array('nom'=>'Salida dia 22/03/2026','inici'=>mktime(19, 0, 0, 3, 22, 2026), 'fi'=>mktime(20, 0, 0, 3, 22, 2026), null);
//$periodes_assist = array();

$tipo_acreditacion['ASISTENTE'] = 'acreditacio_ASSISTENT.png'; //'acreditacion_ASISTENTE.png';
$tipo_acreditacion['MODERADOR'] = 'acreditacion_MODERADOR.png';
$tipo_acreditacion['PONENTE'] = 'acreditacion_PONENTE.png';
$tipo_acreditacion['COMITE'] = 'acreditacion_COMITE.png';

//URL GENERAR imatge QR
//DEPRECATED define("URL_QR", "https://chart.googleapis.com/chart?chs=500x500&cht=qr&.png&chld=H|1&chl=");
//define("URL_QR", "https://qrcode.tec-it.com/API/QRCode?data=");
define("URL_QR", "https://quickchart.io/qr?ecLevel=H&size=500&text=");

//contra el cache
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');?>
