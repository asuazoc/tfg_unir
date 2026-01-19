<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php'); 
ini_set('display_errors', 1);
?>
		</div></div> <!-- End #sidebar -->
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript>
<!-- Show a notification if the user has disabled javascript --> <div
class="notification error png_bg"> <div> Javascript is disabled or is
not supported by your browser. Please <a href="http://browsehappy.com/"
title="Upgrade to a better browser">upgrade</a> your browser or <a
href="http://www.google.com/support/bin/answer.py?answer=23852"
title="Enable Javascript in your browser">enable</a> Javascript to
navigate the interface properly. </div> </div> </noscript>
		
<h2>TPV</h2>
			<p id="page-intro">Pago TPV</p>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">TPV</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Taula</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
<h1>TPV VIRTUAL</h1>
<h2>Banc Sabadell</h2>
<form id="f1" action="tpv_post.php" method="POST">
  Nombre y apellidos del Socio/a: <br>
  <input type=text  id="nombre_pago" name="nombre_pago" width="60" value="">
  <br>
  Referencia Pago: <br>
  <input type=text  id="id_pago" name="id_pago" width="10" readonly value="<?=time()?>">
  <br>
  Importe:<br>
  <input type=text id="importe_pago" name="importe_pago" width="10"> 
  <br>
  <input type="submit" value="Enviar"> 
</form>


</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
