<?php
//exit();
include('../vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);

/*use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;*/
include('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
	header("Location: admin_in.php?page=lst_inscripcions.php");
}

if($_SESSION['rol']!='admin'){
	header("Location: control_assistencia.php");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=assistencia.xls");

if (isset($_GET['estat'])) {
	$aEstat = $_GET['estat'];
} else {
	$aEstat = 'OK';
}

$con = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName) or die ("Error en la conexión a la base de datos: ".mysqli_connect_error());
$con->set_charset("utf8");

$sql                = "SELECT * FROM inscripcions WHERE ESTAT = '".$aEstat."' ORDER BY cg1 ASC, cg2 ASC, nom ASC";
$resultat           = mysqli_query($con, $sql);
$totalResultats     = mysqli_num_rows($resultat);

$capcalera = array('','ID','Nom','Primer cognom','Segon cognom','NIF','Email','Tipus');
foreach ($periodes_assist as $key => $value) {
    $capcalera[] = $value['nom'];
}

echo implode("\t", $capcalera) . "\n";

if ($resultat) {
  $resultats= false;
  $i=1;
  while ($inscripcio = mysqli_fetch_array($resultat)) {
      $resultats= true;
      $nom = $inscripcio['nom'];
      if (!mb_detect_encoding($nom, 'UTF-8', true)) {
        $nom = utf8_encode($nom);
      }
      $cg1 = $inscripcio['cg1'];
      if (!mb_detect_encoding($cg1, 'UTF-8', true)) {
        $cg1 = utf8_encode($cg1);
      }
      $cg2 = $inscripcio['cg2'];
      if (!mb_detect_encoding($cg2, 'UTF-8', true)) {
        $cg2 = utf8_encode($cg2);
      }

      $fila = array($i, $inscripcio['id'], $nom, $cg1, $cg2, $inscripcio['nif'], $inscripcio['email'], $inscripcio['tipo_acreditacion']);

      foreach ($periodes_assist as $key => $value) {
        $sqlPeriode      = "SELECT * FROM assistencia WHERE id_inscripcio = '".$inscripcio['id']."' and id_periode = '".$key."' and assistencia=1";
        $resultatPeriode = mysqli_query($con, $sqlPeriode);
        $periodeResultat = mysqli_num_rows($resultatPeriode);

        $fila[] = ($periodeResultat>0)?'X' :'';
      }
      $i++;
      echo implode("\t", $fila) . "\n";
  }
}else{
  echo "No hi ha resultats\n";
}

$con->close();
?>
