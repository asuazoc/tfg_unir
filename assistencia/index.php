<?php
include('../vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);

include('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=control_assistencia.php");
}else{
  header("Location: control_assistencia.php");
}
?>
