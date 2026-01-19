<?
include('vars.inc.php');
include('lang_es.php');
$lang = 'es';

$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
if(($data>$data_final_comunicacions)&&($_POST['openkey']!='fGtrGtSS')){
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

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$autor=str_replace("'","''",($_POST['autor']));

//duplicated nif check
$nif=str_replace("'","''",($_POST['nif']));
$sql_duplicates="select count(*) num from comunicacions where nif='".$nif."' and removed='N'";
$result = $con->query($sql_duplicates);
$row = $result->fetch(PDO::FETCH_ASSOC);
if (!empty($row) && $row['num']>=$maxComunicacions){
	echo "<html><head><title>".TXT_COMUNICACIO."</title></head><body>Incidencia al guardar: No se permite más de ".$maxComunicacions." comunicaciones por usuario. <br> Issue on save: Not allowed more than ".$maxComunicacions." abstracts by user.</body></html>";
	die();
}

$centre=str_replace("'","''",($_POST['centre']));
$autors=str_replace("'","''",($_POST['autors']));
$centre_principal=str_replace("'","''",($_POST['centre_principal']));
$telparticular=str_replace("'","''",($_POST['telparticular']));


$email=str_replace("'","''",($_POST['email']));
$titol=str_replace("'","''",($_POST['titol']));
$comunicacio=str_replace("'","''",($_POST['comunicacio']));
$paraules_clau1=str_replace("'","''",($_POST['paraules_clau1']));
$comunicacio_lang=str_replace("'","''",($_POST['comunicacio_lang']));
$resum=str_replace("'","''",($_POST['resum']));

$autorizacio_dni=str_replace("'","''",($_POST['autorizacio_dni']));
$publicacio=str_replace("'","''",($_POST['publicacio']));

$sql="INSERT INTO comunicacions SET id=NULL,
			autor='$autor',
			nif='$nif',
			autors='$autors',
			centre='$centre',
			centre_principal='$centre_principal',
			email='$email',
			titol='$titol',
			resum='$resum',
			paraules_clau1='$paraules_clau1',
			comunicacio_lang='$comunicacio_lang',
			comunicacio='$comunicacio',
			telparticular='$telparticular',
			lang='$lang',
			estat='Pendet valoració',
			data_creacio='".date('Y-m-d H:i:s')."'";

$result = $con->prepare($sql);
$result->execute();
//$id=mysqli_insert_id($con);
$last_id=$con->lastInsertId();

//create seq code
$code=$last_id.num2alph($last_id,3);

$update="update comunicacions SET code='".$code."' where id=".$last_id;
$result = $con->query($update);



//carrega la carpeta dels templates
$qte = new QTE('templates/'.$lang.'/');

//carrega un template i l'acocia a un nom
$qte->file('comunicacions_page','mail_password.htm');

$qte->variable('txt_comunicacions_resultat',''); //TXT_COMUNICACIONS_RESULTAT);
$qte->variable('txt_comunicacions_id',$last_id);
$qte->variable('txt_comunicacions_mail',$email);
$qte->variable('txt_comunicacions_code',$code);
$qte->variable('titol_congres',$titol_congres);
$qte->variable('correu_congres_comunicacions',$correu_congres_comunicacions);
$qte->variable('adreca_admin_web',$adreca_admin_web);

if ($publicacio=="S"){
	$qte->variable('txt_no_publicacio',"");
}
else{
	$qte->variable('txt_no_publicacio',TXT_NO_AUTORIZO);
}


$correu=$qte->parse('comunicacions_page',"return");

$txt_correu= $correu;

sendMail($email.','.$correu_congres_comunicacions,$correu_congres_comunicacions,$titol_congres_mail,$txt_correu,0,$last_id,0);

echo "<html><head><title>".TXT_COMUNICACIO."</title></head><body>$correu</body></html>";
?>
