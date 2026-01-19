<?
include('vars.inc.php');
if($_GET['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else{
	include('lang_es.php');
	$lang = 'es';
}
include('classes/qte.class.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



$email=$_REQUEST['email'];
$id=$_REQUEST['id'];

$sql= "select * from comunicacions where email = '".$email."' and id = '".$id."'";
$result= mysqli_query($con,$sql);
$num= mysqli_num_rows ($result);
if( $num != 1 )
{
    exit("La comunicació no existeix");   
}
$row=@mysqli_fetch_assoc($result);
		
//carrega la carpeta dels templates
$qte = new QTE('templates/ca_es/');

//carrega un template i l'acocia a un nom
$qte->file('comunicacions_page','comunications_remove.htm');

$qte->variable('txt_comunicacions_congres',$titol_congres);
$qte->variable('txt_comunicacions_mail',$email);
$qte->variable('txt_comunicacions_title',$row['titol']);
$qte->variable('txt_comunicacions_id',$id);
$qte->variable('titol_congres',$titol_congres);
$qte->variable('correu_congres_comunicacions',$correu_congres_comunicacions);
$qte->variable('tel_secretaria_tecnica',$tel_secretaria_tecnica);
$correu=$qte->parse('comunicacions_page',"return");

$txt_correu= $correu;


$headers ="From:$titol_correu <$correu_congres_comunicacions>\n"; 
$headers .="X-Sender:<$correu_congres_comunicacions>\n"; 
$headers .="X-Mailer: PHP\n"; //mailer $headers .="X-Priority: 1\n"; //1 UrgentMessage, 3 Normal 
$headers .="Return-Path:<$correu_congres_comunicacions>\n"; 
$headers .="Content-Type: text/html; charset=utf-8\n"; //para enviarlo en formato HTML 
mail($email.','.$correu_congres_comunicacions,$titol_congres_mail,$txt_correu,$headers); 


//NO FA EL delete the comunication, SINOÓ QUE CANVIA L'ESTAT REMOVED A 'S'
//$sql_remove= "delete from comunicacions where email = '".$email."' and id = '".$id."'";
$sql_remove= "UPDATE comunicacions SET removed='S' where email = '".$email."' and id = '".$id."'";
mysqli_query($con,$sql_remove);

echo "<html><head><title>".TXT_COMUNICACIONS_RESULTAT."</title></head><body>$correu</body></html>";

?>