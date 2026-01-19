<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php');


//envio mail


$nombre_pago=$_POST['nombre_pago'];
$id_pago=$_POST['id_pago'];
$importe_pago=$_POST['importe_pago'];


$mail_text="";
$mail_text.="Nombre: ".$nombre_pago."<br>";
$mail_text.="Referencia Pago: ".$id_pago."<br>";
$mail_text.="Importe: ".$importe_pago."<br><br>";
$mail_text.="Datos de comprobación, estos no indican la relización del pago.<br>";


//$headers ="From: $titol_correu<$correu_congres>\n";
$headers ="X-Sender:<$correu_congres>\n";
$headers .="X-Mailer: PHP\n"; //mailer $headers .="X-Priority: 1\n"; //1 UrgentMessage, 3 Normal
$headers .="Return-Path:<$correu_congres>\n";
$headers .="Content-Type: text/html; charset=utf-8\n"; //para enviarlo en formato HTML

$err=mail($correu_congres,"TPV UNIR",$mail_text,$headers); 
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
<h2>Verificación</h2>
<form id="f1" action="https://sis.sermepa.es/sis/realizarPago" method="POST">
  Nombre y apellidos del asistente: <br>
  <input type=text  id="Ds_Merchant_ProductDescription" name="Ds_Merchant_ProductDescription" width="60" value="<?=$nombre_pago?>" readonly>
  <br>
  Referencia (min 5): <br>
  <input type=text  id="Ds_Merchant_Order" name="Ds_Merchant_Order" width="10" value="<?=$id_pago?>" readonly>
  <br>
  Importe (Ex:10.10€):<br>
  <input type=text id="Ds_Merchant_Amount" name="Ds_Merchant_Amount" width="10" value="<?=$importe_pago?>" readonly>
  <br>
  <input type="Hidden" name="Ds_Merchant_Currency" id="Ds_Merchant_Currency" value="978">
  <input type="Hidden" name="Ds_Merchant_MerchantCode" id="Ds_Merchant_MerchantCode" value="327061800">
  <input type="Hidden" name="Ds_Merchant_MerchantName" id="Ds_Merchant_MerchantName"  value="ASOCIACION ECONOMIA SALUD">
  <input type="Hidden" name="Ds_Merchant_ConsumerLanguage" id="Ds_Merchant_ConsumerLanguage" value="1">
  <input type="Hidden" name="Ds_Merchant_Terminal" id="Ds_Merchant_Terminal" value="1"></p>
  <input type="Hidden" name="Ds_Merchant_MerchantSignature" id="Ds_Merchant_MerchantSignature" value="">
  <input type="Hidden" name="DS_Merchant_TransactionType" id="Ds_Merchant_TransactionType" value="0">

  <a href="#" onclick="javascript:calcular();">PAGAR</a>
</form>


</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<SCRIPT LANGUAGE="JavaScript" SRC="sha1.js"></SCRIPT>
<script>

function normalizar(precio) {
	var precio2="";
	if (precio=="") {
		alert("No S'ha posat cap import");
		return false;
	} else {
		precio=precio.replace(",",".");
		if (isNaN(precio)) {
			alert("Import no vàlid");
			return false;
		} else {
			if (precio.indexOf(".") == -1){
					precio2 = precio + "00";
		   }  else if (precio.indexOf(".") != -1){
					decimales = precio.substring(1+precio.indexOf("."),precio.length);
					precio2 = precio.substring(0,precio.indexOf(".")) + (decimales.length < 2 ? (decimales.length==0 ? "00":decimales + "0") : decimales.substring(0,2) );
		   }
		 }
	}
	return precio2;
}


function calcular()
{
	var form = document.getElementById("f1");
	var amount = document.getElementById("Ds_Merchant_Amount");
	var fuc= document.getElementById("Ds_Merchant_MerchantCode");
	var moneda= document.getElementById("Ds_Merchant_Currency");
	var order= document.getElementById("Ds_Merchant_Order");
	var signature= document.getElementById("Ds_Merchant_MerchantSignature");
	var tt= document.getElementById("Ds_Merchant_TransactionType");
	var precio = normalizar(amount.value);
	var secret="asdgq234gtwegaw3gq23";

	if (precio!=false) {
		var price_converted = new Number(precio);
		amount.value=price_converted;
		var x = amount.value + order.value + fuc.value + moneda.value + tt.value + secret;
		signature.value=hash(x);
		form.submit();
	} else {
		amount.value="";
		amount.focus();
	}
}

</script>

<? include('footer.php') ?>
