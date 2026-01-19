<?php
try{
  include('../vars.inc.php');
  require('fpdf/fpdf.php');

  error_reporting(E_ALL);
  ini_set('display_errors', 0);

  if(!ENVIO_MAILS_ACTIVO){
  	$resposta = [
		'success' => 0,
		'msg'     => "ENVIAMENT FORA DE SERVEI",
		'error'   => ''
	    ];
  	header('Content-type: application/json');
  	echo json_encode($resposta);
  	die();
  }

  include('login.php');
  $l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

  if (!$l->hasSession()){  //si existeix el login de l'usuari es pot continuar
  	header("Location: admin_in.php?page=lst_inscripcions.php");
  }

  if($_SESSION['rol']!='admin'){
  	header("Location: control_assistencia.php");
  }

  $con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
  $con->set_charset("utf8");
  $count=0;

  $filtreIDs = "";
  if(isset($_POST['id_inici'])&&($_POST['id_inici']!='')){
  	$filtreIDs .= " AND id>= ".$_POST['id_inici'];
  }
  if(isset($_POST['id_fi'])&&($_POST['id_fi']!='')){
  	$filtreIDs .= " AND id<= ".$_POST['id_fi'];
  }
  if(isset($_POST['enviat'])&&($_POST['enviat']!='')){
  	$filtreIDs .= " AND enviado_qr_asistencia = '".$_POST['enviat']."' ";
  }

  $limit = $_POST['limit'];
  $offset = $_POST['offset'];

  //and estat='OK'
  $sql = "SELECT * FROM inscripcions where ( incidencia='' OR incidencia =  'N' OR incidencia IS NULL ) ".$filtreIDs." ORDER BY id LIMIT ".$limit." OFFSET ".$offset." ";

  $res=mysqli_query($con,$sql);
  $total=mysqli_num_rows($res);
  while($row=mysqli_fetch_assoc($res)){

      $qr= URL_QR.sha1(PREFIX_EVENT).'_'.base64_encode($row['id']).'&.png&chld=H|1';

      $mail = '<h3>Accés i acreditació '.$titol_congres.'.</h3>
A continuació trobarà el QR que li servirà per recollir la seva acreditació a la seva arribada a la seu del '.$titol_congres.'.<br/><br/>
Este QR és personal i intransferible. Li demanem que el mostri a la seva arribada per recollir la seva documentació i acreditar la seva assistència.<br/><br/>
Qualsevol dubte o aclariment, pot contactar amb la secretaría tècnica: '.$correu_congres.'<br/><br/>
<img src="'.$qr.'"/>';

      $to = ($row['email2']!='')?$row['email2']:$row['email'];
      if($to!=''){
        $pdf = new FPDF('L','mm',array(100,100));
        $pdf->AddPage();
        $pdf->Image($qr, 0, 0, 100, 0, 'PNG');
        $pdf->Output('tmp/qr_assist.pdf', 'F');
        //exit();

        if(sendMail($to,$correu_congres_inscripcions,$titol_congres_mail,$mail,0,0,'tmp/qr_assist.pdf')) {
          $res2=mysqli_query($con,"UPDATE inscripcions SET enviado_qr_asistencia='S' WHERE id=".$row['id']." ");
          //Something to write to txt log
          $count++;
          $log  = "OK - ID:".$row['id'].' - '.$to." - ".date("Y-m-d H:i:s")." - ".$count.PHP_EOL;
        }else{
          $log  = "OK - ID:".$row['id'].' - '.$to." - ".date("Y-m-d H:i:s").PHP_EOL;
        }
      }else{
        $log  = "NO_MAIL - ID:".$row['id'].' - '.$to." - ".date("Y-m-d H:i:s").PHP_EOL;
      }
      file_put_contents('mail.log', $log, FILE_APPEND);
  }

  $resposta = [
       'success' => 1,
       'msg'     => "Missatge/s enviat/s: ".$count."/".$total,
       'enviats'   => $count,
       'error'   => ""
   ];

   $con->close();

 } catch (Exception $e) {
   $resposta = [
        'success' => 0,
        'msg'     => "Missatges enviat: ".$count."/".$total,
        'enviats'   => $count,
        'error'   => $e->getMessage()
    ];
 }

// Resposta AJAX.
// -----------------------------------------------------------------------------
header('Content-type: application/json');
echo json_encode($resposta);
?>
