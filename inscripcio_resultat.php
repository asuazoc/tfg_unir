<?
include('vars.inc.php');
ini_set('display_errors',0);
if($_POST['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else if($_POST['lang']=='ca'){
	include('lang_ca.php');
	$lang = 'ca';
}else{
	include('lang_es.php');
	$lang = 'es';
}
$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
if($data>$data_final_inscripcions){
	exit();
}
include('classes/qte.class.php');

function num2alph($num,$len=4) {
	($len<1)? $len=1:'';
    $result = '';
	while($num >= 1) {
	    $num = $num - 1;
	    $result = chr(($num % 26)+65).$result;
	    $num = $num / 26;
	}

	(strlen($result)<$len) ? $result=str_pad($result,$len, "0", STR_PAD_LEFT): '';
	return strtolower($result);
}

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



	//dades personals
	$tractament=str_replace("'","''",$_POST['tractament']);

	//$categoria=str_replace("'","''",$_POST['categoria']);
	$categoria='A'; //per defecte

	$cg1=str_replace("'","''",$_POST['cg1']);
	$cg2=str_replace("'","''",$_POST['cg2']);
	$nom=str_replace("'","''",$_POST['nom']);
	$nif=str_replace("'","''",$_POST['nif']);
	$adresa=str_replace("'","''",$_POST['adresa']);
	$localitat=str_replace("'","''",$_POST['localitat']);
	$cp=str_replace("'","''",$_POST['cp']);
	$provincia=str_replace("'","''",$_POST['provincia']);
	$telparticular=str_replace("'","''",$_POST['telparticular']);
	$teltreball=str_replace("'","''",$_POST['teltreball']);
	$email=str_replace("'","''",$_POST['email']);
	$email2=str_replace("'","''",$_POST['email2']);
	$lloctreball=str_replace("'","''",$_POST['lloctreball']);

	//camps facturació
	$nom_facturacio = str_replace("'","''",$_POST['nom_facturacio']);
	$nif_facturacio  = str_replace("'","''",$_POST['nif_facturacio']);
	$adresa_facturacio = str_replace("'","''",$_POST['adresa_facturacio']);
	$localitat_facturacio = str_replace("'","''",$_POST['localitat_facturacio']);
	$cp_facturacio = str_replace("'","''",$_POST['cp_facturacio']);
	$atencio_facturacio = str_replace("'","''",$_POST['atencio_facturacio']);
	$provincia_facturacio = str_replace("'","''",$_POST['provincia_facturacio']);
	$tel_facturacio = str_replace("'","''",$_POST['tel_facturacio']);
	$correu_facturacio = str_replace("'","''",$_POST['correu_facturacio']);
	$atencio_facturacio = str_replace("'","''",$_POST['atencio_facturacio']);

	//dades incripció
	$id_inscripcio=str_replace("'","''",$_POST['id_inscripcio']);
	$sopar=$_POST['sopar'];
	$acomp_sopar=$_POST['acomp_sopar'];
	if($_POST['acomp_sopar']=='Si'){
		$total_sopar=$preu_sopar_acomp;
	}else{
		$total_sopar=0;
	}

	$restriccio_alimenticia=$_POST['restriccio_alimenticia'];
	$restriccio_alimenticia_text=str_replace("'","''",$_POST['restriccio_alimenticia_text']);

	/* calculats Hotel */
	$hotel_habitacio=explode('|',$_POST['hotel_habitacio']);
	$hotel=$hotel_habitacio[0];
	$habitacio=$hotel_habitacio[1];

	/* Preus */

	$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
	/*/if($data<$datatall_allotjament)
		$tall=1;
	else
		$tall=2;*/
		$tall=1; //Només hi ha una tarifa de preus d'inscripció

	/* Calculats */
	if(isset($_POST['dataentrada']) && $_POST['dataentrada']!=''){
		$dini=explode('/',$_POST['dataentrada']);
		$dfi=explode('/',$_POST['datasortida']);
		$ini=mktime(0,0,0,$dini[1],$dini[0],$dini[2]);
		$fi=mktime(0,0,0,$dfi[1],$dfi[0],$dfi[2]);
		$nits =(($fi-$ini)/ 86400 );
		$dataentrada=canvia_mysql($_POST['dataentrada']);
		$datasortida=canvia_mysql($_POST['datasortida']);
		$total_inscripcio= $inscripcio[$id_inscripcio][$tall];
		$total_allotjament=$allotjament[$hotel][$habitacio]*$nits;
		$total=$total_inscripcio+$total_allotjament;
		//$total=$total_inscripcio;

		$nits=str_replace("'","''",$_POST['label_nits']);
	}else{
	    $nits=0;
	    $total_allotjament=0;
	    $dataentrada='';
	    $datasortida='';
	}
	$total=str_replace("'","''",$_POST['label_preu_total']);
	$total_inscripcio= str_replace("'","''",$_POST['label_inscripcio']);
	$total_allotjament= str_replace("'","''",$_POST['label_preu_allotjament']);

	$metode_pagament= str_replace("'","''",$_POST['metode_pagament']);

	$nomFitxerNou = null;

	if($_FILES['fitxerdoc']['error']==0){

		$tipusFitxer = $_FILES['fitxerdoc']['type'];
		$tamany = $_FILES['fitxerdoc']['size'];
		$partsNomFitxer = explode('.',$_FILES['fitxerdoc']['name']);
		$nomFitxerNou=time().'.'.$partsNomFitxer[(count($partsNomFitxer)-1)];
		if ($tamany > 10000000) {
		    echo TXT_FITXER_MASSA_GRAN;
		    exit();
		}else{
			if (move_uploaded_file($_FILES['fitxerdoc']['tmp_name'], "upload_estudiant/".$nomFitxerNou)){
				chmod("upload_estudiant/".$nomFitxerNou, 0777);
			}else{
				echo TXT_PROBLEMA_FITXER;
				exit();
			}
		}
	}


$sql="INSERT INTO inscripcions SET
id=NULL ,
tractament='$tractament' ,
categoria='$categoria' ,
cg1='$cg1' ,
cg2='$cg2' ,
nom='$nom' ,
nif='$nif' ,
adresa='$adresa' ,
localitat='$localitat' ,
cp='$cp' ,
provincia='$provincia' ,
telparticular='$telparticular' ,
lloctreball='$lloctreball' ,
teltreball='$teltreball' ,
email='$email' ,
email2='$email2' ,
usuari='$email' ,
id_inscripcio='$id_inscripcio' ,
sopar='$sopar' ,
acomp_sopar='$acomp_sopar' ,
total_sopar='$total_sopar' ,
restriccio_alimenticia = '$restriccio_alimenticia',
restriccio_alimenticia_text = '$restriccio_alimenticia_text',
hotel='$hotel' ,
habitacio='$habitacio' ,
dataentrada='$dataentrada' ,
datasortida='$datasortida' ,
nits='$nits' ,
total_allotjament='$total_allotjament' ,
total_inscripcio='$total_inscripcio' ,
estat='PP' ,
total='$total',
nom_facturacio='$nom_facturacio',
nif_facturacio='$nif_facturacio',
adresa_facturacio='$adresa_facturacio',
localitat_facturacio='$localitat_facturacio',
correu_facturacio='$correu_facturacio',
cp_facturacio='$cp_facturacio',
atencio_facturacio='$atencio_facturacio',
provincia_facturacio='$provincia_facturacio',
tel_facturacio='$tel_facturacio',
metode_pagament='$metode_pagament',
numero_factura='0',
doc_estudiant='$nomFitxerNou',
lang='$lang',
data_factura=null,
data_registre='".date('Y-m-d H:i:s')."'";

//echo $sql; exit();
mysqli_query($con,$sql) or die('<SPAN CLASS="titol1">ERROR al afegir el registre: '.mysql_error().'</SPAN>');
$id=mysqli_insert_id($con);

//create seq code
$password=$id.num2alph($id,3);
$update="update inscripcions SET password='".$password."' where id=".$id;
mysqli_query($con,$update);

$sql='select * from inscripcions where id='.$id;
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);

//carrega la carpeta dels templates
$qte = new QTE('templates/'.$lang.'/');

//carrega un template i l'acocia a un nom
$qte->file('justificant_mail','mail_justificant_inscripcio.htm');


$qte->variable('id_congres',$id);
$qte->variable('titol_congres',$titol_congres);
$qte->variable('dates_del_congres',$dates_del_congres);
$qte->variable('correu_congres',$correu_congres);
$qte->variable('web_congres',$web_congres);

$qte->variable('dades',$row);
$qte->variable('hotel',$a_hotel[$row['hotel']]);
$qte->variable('dataentrada',canvia_normal($row['dataentrada']));
$qte->variable('datasortida',canvia_normal($row['datasortida']));
$qte->variable('habitacio',$txt_habitacio[$row['habitacio']][$lang]);
$qte->variable('TXT_PROTECCIO_DADES',TXT_PROTECCIO_DADES);
$qte->variable('TXT_PROTECCIO_DADES_TITOL',TXT_PROTECCIO_DADES_TITOL);
$qte->variable('txt_aclariment_justificant',TXT_ACLARIMENT_JUSTIFICANT);
$qte->variable('txt_info_renfe',TXT_INFO_RENFE);
$qte->variable('tipus_inscripcio',$a_inscripcio[$row['id_inscripcio']][$lang]);

if(($row['id_inscripcio']=='ES')||($row['id_inscripcio']=='EN')){
	$qte->variable('TXT_CONFIRMACIO_ESTUDIANTE',TXT_CONFIRMACIO_ESTUDIANTE);
}else{
	$qte->variable('TXT_CONFIRMACIO_ESTUDIANTE','');
}

$forma_pagament='<h2>'.TXT_FORMA_PAGAMENT_TITOL.'</h2>';
if ($metode_pagament=="visa"){
	$forma_pagament.= "<p>".TXT_PAGAMENT2."</p>";
}
else{
	$forma_pagament.='<p>
          '.TXT_PAGAMENT1.'<br/>'.TXT_FORMA_PAGAMENT.'<br /><br />
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
}
$forma_pagament = '';

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

$mail=$qte->parse('justificant_mail',"return");

$rutaDocEstudiant = null;
if($nomFitxerNou){
	$rutaDocEstudiant = 'upload_estudiant/'.$nomFitxerNou;
}
//$pdf = 'files/TES_2020_00209.pdf';
$pdf = 'files/TES_2023_00070.pdf';

$err=sendMail($row['email'].','.$correu_congres,$correu_congres,$titol_congres_mail,$mail,0,0,$rutaDocEstudiant,0); //,$pdf); Deshabilitat PDF Renfe
header("Location: inscripcio_payment.php?id=" . $id . '&total=' . $total.'&lang='.$lang);
?>
