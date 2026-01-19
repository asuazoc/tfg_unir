<?php
include('../vars.inc.php');
ini_set("display_errors", 0);
date_default_timezone_set("Europe/Madrid");
/*mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);

mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);
mysql_set_charset('utf8');*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$id = $_POST['sid'];
$real_id  = base64_decode($id);
$opcio_contingut = $_POST['opcio_contingut'];
$opcio_temes = $_POST['opcio_temes'];
$opcio_duracio = $_POST['opcio_duracio'];
$opcio_metodologia = $_POST['opcio_metodologia'];
$opcio_condicions = $_POST['opcio_condicions'];
$opcio_ponents = $_POST['opcio_ponents'];
$opcio_claretat = $_POST['opcio_claretat'];
$opcio_motivacio = $_POST['opcio_motivacio'];
$opcio_horari = $_POST['opcio_horari'];
$opcio_util = $_POST['opcio_util'];
$opcio_organizacio = $_POST['opcio_organizacio'];
$aportacions = str_replace("'","''",($_POST['aportacions']));
/*
$opcio_taller_contingut = $_POST['opcio_taller_contingut'];
$opcio_taller_temes = $_POST['opcio_taller_temes'];
$opcio_taller_duracio = $_POST['opcio_taller_duracio'];
$opcio_taller_metodologia = $_POST['opcio_taller_metodologia'];
$opcio_taller_condicions = $_POST['opcio_taller_condicions'];
$opcio_taller_ponents = $_POST['opcio_taller_ponents'];
$opcio_taller_claretat = $_POST['opcio_taller_claretat'];
$opcio_taller_motivacio = $_POST['opcio_taller_motivacio'];
$opcio_taller_horari = $_POST['opcio_taller_horari'];
$opcio_taller_util = $_POST['opcio_taller_util'];
$opcio_taller_organizacio = $_POST['opcio_taller_organizacio'];
$aportacions_taller = str_replace("'","''",($_POST['aportacions_taller']));
*/
$sql  = "INSERT INTO enquesta (id,id_inscripcion,opcio_contingut,opcio_temes,opcio_duracio,opcio_metodologia,opcio_condicions,opcio_ponents,opcio_claretat,opcio_motivacio,opcio_horari,opcio_util,opcio_organizacio,aportacions) 
VALUES ($real_id,$opcio_contingut,$opcio_temes,$opcio_duracio,$opcio_metodologia,$opcio_condicions,$opcio_ponents,$opcio_claretat,$opcio_motivacio,$opcio_horari,$opcio_util,$opcio_organizacio,'".$aportacions."')";

/*,
opcio_taller_contingut,opcio_taller_temes,opcio_taller_duracio,opcio_taller_metodologia,opcio_taller_condicions,opcio_taller_ponents,opcio_taller_claretat,opcio_taller_motivacio,opcio_taller_horari,opcio_taller_util,opcio_taller_organizacio,aportacions_taller
,
$opcio_taller_contingut,$opcio_taller_temes,$opcio_taller_duracio,$opcio_taller_metodologia,$opcio_taller_condicions,$opcio_taller_ponents,$opcio_taller_claretat,$opcio_taller_motivacio,$opcio_taller_horari,$opcio_taller_util,$opcio_taller_organizacio,'".$aportacions_taller."'*/


//echo $sql; exit();

$result = $con->prepare($sql);
$result->execute();

$page = $_POST['page'];
header("Location: ".base64_decode($page)."");
?>
