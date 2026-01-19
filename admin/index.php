<?php
session_start();
$pag="lst_inscripcions.php";
if (($_SESSION['rol']=="evaluador")){
  $pag="lst_comunicacions_avaluacio.php";
}
header("Location: ".$pag);
?>
