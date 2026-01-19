<?
include('../vars.inc.php');
include('control.php');
$lang = 'es';

ini_set('display_errors',0);
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php');
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

	<h2><?=$titol_congres?></h2>
	<p id="page-intro"><b><?=TXT_DOCUMENTACIONS?></b></p>
	<!--<p id="page-intro"><b><?=TXT_INTRO_DOCUMENTACIONS?></b></p>-->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-content">
			<?

			$sql = "SELECT * FROM inscripcions WHERE password='".$_SESSION['pass']."' AND usuari='".$_SESSION['user']."'";
			$result = $con->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);

			$id=base64_encode($row['id']);
			$estat = $row['estat'];
			$estat_factura = $row['estat_factura'];
			$certificat_assist = $row['certificat_assist'];
			$vip = $row['vip'];?>


			<ul style="list-style:block;">
				<li>
					<?//CONFIRMACIO?>
					<b><?=TXT_CONFIRMACIO?></b>&#160;
					<?if($estat=='OK'){?>
						<a href="../admin/mail_inscripcio.php?accio=D&id=<?=$id?>" target="_blank"><img style="vertical-align:middle" src="images/doc.jpg"/></a>
					<?}else{?>
						<?=TXT_CERTIFICAT_NO_DISPONIBLE?>
					<?}?>
				</li><li>
					<?//FACTURA?>
					<b><?=TXT_FACTURA?></b>&#160;
					<?if($estat_factura=='F'){?>
						<a href="../admin/factura.php?accio=D&id=<?=$id?>" target="_blank"><img style="vertical-align:middle" src="images/pdf.jpg"/></a>
					<?}else{?>
						<?=TXT_FACTURA_NO_DISPONIBLE?>
					<?}?>
				</li>
			</ul>
			<ul>
				<li>
					<?//CERTIFICAT?>
					<b><?=TXT_CERTIFICAT_ASSISTENCIA?></b>&#160;
					<?if($certificat_assist=='S'){?>
						<!-- <a href="../enquesta/enquesta_form.php?id=<?=$id?>&page=<?=base64_encode('../documents/certificat.php?id='.$id)?>" target="_blank"><img style="vertical-align:middle" src="images/pdf.jpg"/></a>-->
						<a href="certificat.php?id=<?=$id?>" target="_blank"><img style="vertical-align:middle" src="images/pdf.jpg"/></a>
					<?}else{?>
						<?=TXT_DATA_DISPONIBLES_CERTIFICATS?>
					<?}?>
				</li>
			</ul>
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
