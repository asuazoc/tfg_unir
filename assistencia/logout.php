<?
/*
Connexi� a mysql
*/
require_once('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);
$l->destroySession();
header("Location: lst_inscripcions.php");
?>
