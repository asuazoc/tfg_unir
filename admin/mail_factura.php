<?
include_once('../vars.inc.php');
ob_start();
?>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" >
	</head>
	<body>
	<h2><?=$titol_congres?></h2>
	<h3>
	<!--<p>
	<br>
	Benvolgut/da sr./a,
	<br>
	Li adjuntem  la factura en aquest correu.
	<br>
	</p>
	============================================================
	<p>
	<br>-->
	Apreciado/a sr./a  /  Dear sir. / madam,
	<br>
	Le adjuntamos la factura en este correo. / Attached is the bill in this email.
	<br>
	</p>
	</h3>
	</body>
	</html>
<?
$message=ob_get_contents();
ob_end_clean();
?>