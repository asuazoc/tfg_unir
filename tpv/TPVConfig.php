<?php
//TPV

//Numeración: 4548 8120 4940 0004
//Caducidad 03/26
//Código CVV2: 123
//CIP: 123456
$tpv_config=array(
        'url_tpvv'     		=> 'https://sis-t.redsys.es:25443/sis/realizarPago',
        'urlMerchant'  		=> '/TPVResponse.php',
        'secret'        	=> 'sq7HjrUOBfKmC576ILgskD5srU870gJ7',
        'code'      		=> '327234688',
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
