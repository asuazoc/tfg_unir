<?php
//TPV

//Numeración: 4548 8120 4940 0004
//Caducidad 03/26
//Código CVV2: 123
//CIP: 123456
$tpv_config=array(
        'url_tpvv'     		=> 'https://sis-t.redsys.es:21234/sis/realizarPago',
        'urlMerchant'  		=> '/TPVResponse.php',
        'secret'        	=> 'sq7HjrUOXXXXXXXXXD5srU870gJ7',
        'code'      		=> '327XXXXX88',
        'name'              => 'TPV DE PRUEBAS',
        'terminal'          => '1',
        'currency'          => '978',
        'transactionType'   => '0',
        'consumerLanguage' 	=> '1',
        'merchantUrlOK' 	=> '1',
        'merchantUrlKO' 	=> '1',
        'merchantData' 		=> '1'
);

$tpv_prefix=20;
?>
