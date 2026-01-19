<?php
include '../vars.inc.php';
include "TPVConfig.php";
include "SermepaPaymentGateway.php";

ini_set('error_log', "errors.log");
error_log("Access\n");
if($_GET['lang']=='en'){
  $lang = 'en';
}else{
  $lang = 'es';
}

//only post is allowed
if (!empty($_POST)) {

	$signature = $_POST["Ds_Signature"];
	$params = $_POST["Ds_MerchantParameters"];

	$spw = new SermepaPaymentGateway($tpv_config);
	$orderData = $spw->getResponse($params);
	$isValid = $spw->isValidMessage($params, $signature);

	// Calcul del SHA1
	if ($isValid) {
		$response = $orderData["Ds_Response"];
		$response = intval($response);
		if ($spw->isValidResponse($response)) {
			$order = intval($orderData["Ds_MerchantData"]);
			$order_tpv = $orderData["Ds_Order"];
			$total = $orderData["Ds_Amount"];
			$code = $orderData["Ds_MerchantCode"];
			$currency = $orderData["Ds_Currency"];
			$total = number_format($total / 100, 2);

			error_log("Order:" . $order . " Order TPV:" . $order_tpv . " Total:" . $total . " Responce: " . $response . " Status: Order \n");

			//db update
			$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");;

			$sql = "select * from inscripcions where id=$order";
			$res = mysqli_query($con,$sql);
			$row = mysqli_fetch_assoc($res);

			$cg1 = $row['cg1'];
			$cg2 = $row['cg2'];
			$nom = $row['nom'];
			$numero_factura = $row['numero_factura'];
			$nif_facturacio = $row['nif_facturacio'];
			$data_factura = $row['data_factura'];
			$estat_factura = $row['estat_factura'];
			$total_allotjament = $row['total_allotjament'];
			$pagat_allotjament = $row['pagat_allotjament'];
			$total_inscripcio = $row['total_inscripcio'];
			$pagat_inscripcio = $row['pagat_inscripcio'];
			$total = $row['total'];
			$total_pagat = $row['total_pagat'];

			if (empty($numero_factura)) {
				$numero_factura = 0;
			}

			//mirem quin numero de factura toca
			if ($nif_facturacio != "" && $estat_factura != "F" && $numero_factura == 0 && $total != 0 && $total_inscripcio != 0) {

				//emplenem tots els camps de forma automatica!!
				$numero_factura = cercaNumFacturaValid();
				$data_factura = date('Y-m-d');
				$estat_factura = "F";
				$pagat_allotjament = $total_allotjament;
				$pagat_inscripcio = $total_inscripcio;
				$total_pagat = $total;

				$sql = "UPDATE inscripcions SET
	            pagat_allotjament='$pagat_allotjament',
	            pagat_inscripcio='$pagat_inscripcio',
	            total_pagat='$total_pagat',
	            estat_factura='$estat_factura',
	            numero_factura='$numero_factura',
	            data_factura='$data_factura',
                metode_pagament='VISA',
                id_pagament='$order_tpv',
	            estat='OK'
	            where id=" . $order;
				$res = mysqli_query($con,$sql);
				error_log("Order:" . $order . " Query: ". $sql . "\n");

				//send mail
				$chMail = curl_init();
				curl_setopt($chMail, CURLOPT_URL, $adreca_tpv . "/admin/mail_inscripcio.php?accio=C&id=$order&auto=1&lang=$lang");
				curl_setopt($chMail, CURLOPT_HEADER, 0);
				curl_exec($chMail);
				curl_close($chMail);
				error_log("Order:" . $order . " Call to: ". $adreca_tpv . "/admin/mail_inscripcio.php?accio=C&id=$order&auto=1&lang=$lang\n");

				//send invoice

				$chInvoice = curl_init();
				curl_setopt($chInvoice, CURLOPT_URL, $adreca_tpv . "/admin/factura.php?id=$order&accio=S&auto=1&lang=$lang");
				curl_setopt($chInvoice, CURLOPT_HEADER, 0);
				curl_exec($chInvoice);
				curl_close($chInvoice);
				error_log("Order:" . $order . " Call to: ". $adreca_tpv . "/admin/factura.php?id=$order&accio=S&auto=1&lang=$lang\n");

			} else {
				error_log("Error in validation" . $order);
			}

		} else {
			error_log("Order:" . $order . " Order TPV:" . $order_tpv . " Total:" . $total . " Responce: " . $response . " Status: Fail\n");
		}

	} else {
		error_log("Order:" . $order . " Total:" . $total . " Responce: " . $response . " Status: Signature mistmach\n");
		error_log("\tPOST VALUES:\n");
		foreach ($_POST as $key => $value) {
			error_log("\tKey:" . $key . " Value:" . $value . "\n");
		}
	}
} else {
	error_log("No request post\n");
	header("Status: 404 Not Found");
}
?>
