<?php
include('../vars.inc.php');
if(!REGISTRO_ASISTENCIA_ACTIVO){
    $resposta = [
        'success' => 0,
        'msg'     => "FUERA DE SERVICIO",
        'nif'     => "",
        'nomCognoms'=> "",
        'error'   => ""
    ];
    header('Content-type: application/json');
    echo json_encode($resposta);
    die();
}
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once('login.php');
$l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
  $usuariRegistre = 'obert';
}else{
  $usuariRegistre = $_SESSION['login'];
}

$periodes = $periodes_assist;

// Dades formdata
// -----------------------------------------------------------------------------

// Actualització del registre $idInscripcio
// -----------------------------------------------------------------------------

//print_r($_POST); exit();
$idInscripcio = null;
if (isset($_POST['textQR'])){
    $textQR = $_POST['textQR'];
    $hashEsdev = sha1(PREFIX_EVENT);
    $action = 1;
    if (str_starts_with($textQR, $hashEsdev)== true) {
        $idInscripcio = base64_decode(str_replace($hashEsdev.'_', "", $textQR));
        $idPeriodes = getIdPeriodeActual();

        $idPeriode = 0;
        $periodeObert = false;
        if(isset($_POST['idPeriod'])&&(count($idPeriodes)!=0)){ //SI HI HA COINCIDÈNCIA DE PERIODE/S i HI HA idPeriod entra per continuar amb la VALIDACIÓ
          foreach($idPeriodes as $idPer){
    		    if($periodes_assist[$idPer]['idPeriodeObert']==$_POST['idPeriod']){
    		        $periodeObert = true;
                $idPeriode = $idPer;
    		    }
    	    }
        }else if(count($idPeriodes)==1){ //SI HI HA MÉS D'UNA COINCIDÈNCIA DE PERIODES no fa el registre per NO PODER-LO IDENTIFICAR
    		    if($periodes_assist[$idPeriodes[0]]['idPeriodeObert']==null){
    		        $periodeObert = true;
                $idPeriode = $idPeriodes[0];
    		    }
        }else{ //SI NO HI HA COINCIDÈNCIA DE PERIODES O NO HI HA idPeriod NO FA EL REGISTRE
          $periodeObert = false;
        }
    } else {
        // Aquest QR no es correspon amb els generats per a aquest esdeveniment
        $resposta = [
            'success' => 0,
            'msg'     => "Este codigo QR NO peertenece a este evento",
            'nif'     => "EVENTO INCORRECTO",
            'nomCognoms'=> "",
            'error'   => "Este codigo QR NO peertenece a este evento"
        ];
    }
}else if (isset($_POST['id_inscripcio'])){
    $idInscripcio = $_POST['id_inscripcio'];
    $idPeriode = $_POST['id_periode'];
    $action = $_POST['action'];
    $periodeObert = true;
}

if($idInscripcio){
    $con = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName) or die ("Error en la conexión a la base de datos: ".mysqli_connect_error());
    //$con->set_charset("utf8");

    $sql = "SELECT * FROM inscripcions WHERE id='".$idInscripcio."'";
    $resultatInscripcions = mysqli_query($con, $sql);
    if ($resultatInscripcions) {
        $inscripcio = mysqli_fetch_array($resultatInscripcions);

        if (($idPeriode>0)&&($periodeObert)){
          $sql = "SELECT * FROM assistencia WHERE id_inscripcio='".$idInscripcio."' and id_periode=".$idPeriode;
          if ($resultatAssistencia = mysqli_query($con, $sql)) {

              if($assistencia = mysqli_fetch_array($resultatAssistencia)){
                  if($action==1){
                      if($assistencia['assistencia']==1){
                        $aMissatge = "La asistencia de la inscripción de este QR ya ha sido confirmada con anterioridad.";
                        $success = 2;
                      }else{
                        $aSql = "UPDATE assistencia SET hora_modificacio='".date('Y-m-d H:i:s')."',usuari_modificacio='".$usuariRegistre."',assistencia=1 WHERE id_periode=".$idPeriode." AND id_inscripcio=".$idInscripcio;
                        if(!mysqli_query($con, $aSql)){
                            $aMissatge = "NO se ha podido registrar la asistencia en el periodo ".$periodes[$idPeriode]['nom'];
                            $success = 0;
                        }else{
                            $aMissatge = "Se ha registrat la asistencia correctamente en el periodo ".$periodes[$idPeriode]['nom'];
                            $success = 1;
                        }
                      }
                  }else{
                    $aSql = "UPDATE assistencia SET hora_modificacio='".date('Y-m-d H:i:s')."',usuari_modificacio='".$usuariRegistre."',assistencia=0 WHERE id_periode=".$idPeriode." AND id_inscripcio=".$idInscripcio;
                    if(!mysqli_query($con, $aSql)){
                        $aMissatge = "NO se ha podido registrar la asistencia en el periodo ".$periodes[$idPeriode]['nom'];
                        $success = 0;
                    }else{
                        $aMissatge = "Se ha registrat la asistencia correctamente en el periodo ".$periodes[$idPeriode]['nom'];
                        $success = 1;
                    }
                  }
              }else{
                  $aSql = "INSERT INTO assistencia (id_inscripcio,hora_registre,usuari_registre,id_periode)
                           VALUES ('".$idInscripcio."','".date('Y-m-d H:i:s')."','".$usuariRegistre."',".$idPeriode.")";
                  if(!mysqli_query($con, $aSql)){
                      $aMissatge = "NO se ha podido registrar la asistencia en el periodo ".$periodes[$idPeriode]['nom'];
                      $success = 0;
                  }else{
                      $aMissatge = "Se ha registrado la asistencia correctamente en el periodo ".$periodes[$idPeriode]['nom'];
                      $success = 1;
                  }
              }

          }
          $resposta = [
              'success' => $success,
              'msg'     => $aMissatge,
              'nif'     => (isset($_POST['idPeriod']))?'':$inscripcio['nif'],
              'nomCognoms'=> (isset($_POST['idPeriod']))?'':$inscripcio['nom']. ' ' .$inscripcio['cg1']. ' ' .$inscripcio['cg1'],
              'error'   => mysqli_error($con)
           ];
       }else{
           $resposta = [
                'success' => 0,
                'msg'     => "NO se pueden hacer verificaciones de asistencia FUERA DE LOS PERIODOS establecidos por la organización.",
                'nif'     => (isset($_POST['idPeriod']))?'':$inscripcio['nif'],
                'nomCognoms'=> (isset($_POST['idPeriod']))?'':$inscripcio['nom']. ' ' .$inscripcio['cg1']. ' ' .$inscripcio['cg1'],
                'error'   => "NO se pueden hacer verificaciones de asistencia FUERA DE LOS PERIODOS establecidos por la organización."
            ];
       }
    }else{
        $resposta = [
            'success' => 0,
            'msg'     => "No se ha encontrado la inscripción en este evento",
            'nif'     => "INSCRIPCIÓN INCORRECTA",
            'nomCognoms'=> "",
            'error'   => "No se ha encontrado la inscripción en este evento"
         ];
    }
    $con->close();

}else{
    $resposta = [
        'success' => 0,
        'msg'     => "Se tiene que especificar un número de inscripción válido",
        'nif'     => "INSCRIPCIÓN INCORRECTA",
        'nomCognoms'=> "",
        'error'   => "Se tiene que especificar un número de inscripción válido"
    ];
}


// Resposta AJAX.
// -----------------------------------------------------------------------------
header('Content-type: application/json');
echo json_encode($resposta);

function getIdPeriodeActual(){
    global $periodes;
    $numPeriode = array();
    $dataActual = time();
    foreach ($periodes as $key => $periode){
        if (($dataActual >= $periode["inici"]) && ($dataActual <= $periode["fi"])){
            $numPeriode[] = $key;
        }
    }
    return $numPeriode;
}

function comprovaRegistreDinsDatesPeriode($dataRegistre){
    global $periodes;
    $numPeriode = obtenirNumPeriode();
    $dinsPeriode = false;
    $dru = strtotime($dataRegistre); // convertir a format unix
    if (($dru >= $periodes[$numPeriode]["inici"]) && ($dru <= $periodes[$numPeriode]["fi"])){
        $dinsPeriode = true;
    }
    return $dinsPeriode;
}

function comprovaAraDinsDatesPeriode($numPeriodeComprovacio){
    global $periodes;
    $numPeriode = obtenirNumPeriode();
    if ($numPeriode == $numPeriodeComprovacio) {
        return true;
    } else {
        return false;
    }

}
