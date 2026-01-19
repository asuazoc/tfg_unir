<?php
include('vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);
if($_GET['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else{
	include('lang_es.php');
	$lang = 'es';
}
include(dirname(__FILE__) . '/tpv/TPVConfig.php');
include(dirname(__FILE__) . '/tpv/SermepaPaymentGateway.php');

$id = intval($_GET['id']);
$total_price = $_GET['total'];

if (empty($id) || empty($total_price) ){
  die("Invalid data");
}

$tpv_order_id=$tpv_prefix.time();
$order_config=array(
                'merchantData'          => $id,
                'urlMerchant'           => $adreca_tpv.'/tpv/TPVResponse.php?lang='.$lang,
                'merchantUrlOK'         => $adreca_tpv.'/inscripcio_complete_visa.php?lang='.$lang,
                'merchantUrlKO'         => $adreca_tpv.'/inscripcio_fail.php?lang='.$lang);

    //merge tpv config and order config
$config = array_merge($tpv_config, $order_config);
$spw = new SermepaPaymentGateway($config);
$tpv_form=$spw->getForm($total_price,$tpv_order_id,false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <title>
      <?=TXT_TITOL_FORM_INSCRIPCIO_WEB?>
      <?=$titol_congres ?>
    </title>
    <meta http-equiv="content-type"
    content="text/html; charset=utf-8" />
    <meta name="author" content="Adrià"/>
    <style type="text/css">
      body{
        font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
        font-size:12px;
        background: #E7EFE7;
      }

      p, h1, form, button{
        border:0;
        margin:0;
        padding:0;
      }
      .spacer{
        clear:both;
        height:1px;
      }

      .clickable{
        cursor:pointer;
      }

      /* Styling for message associated with a validation error. */
      .cleanform  .errMsg {
      color: #CC3333 !important;
      display: block;
      border: 1px solid #CC3333;
      }


      .cleanform{
        margin:0 auto;
        width:800px;
        padding:14px;
        border:solid 2px #E2E2E2;
        background:#fff;
      }

      .cleanform div.header {
        border-bottom:solid 1px #E2E2E2;
        font-size:11px;
        margin-bottom:20px;
      }

      .cleanform div.header h1 {
        font-size:16px;
        font-weight:bold;
        margin-bottom:8px;
      }

      .cleanform div.header .description {
        color: #666666;
      }

      .cleanform p{
        font-size:11px;
        margin-bottom:20px;
      }

      .cleanform label{
        display:block;
        font-weight:bold;
        width:340px;
        float:left;
      }



      .cleanform .small{
        color:#666666;
        display:block;
        font-size:11px;
        font-weight:normal;
      }


      .cleanform .check{
        font-size:12px;
        padding:4px 2px;
        margin:2px 0 20px 10px;
      }

      .cleanform input{
        float:left;
        font-size:12px;
        padding:4px 2px;
        border:solid 1px #E2E2E2;
        width:200px;
        margin:2px 0 20px 10px;
      }


      .cleanform  legend
      {
        font-size:12px;
        font-weight:bold;
        padding: 2px 6px;
        border:none;
      }


      .cleanform  fieldset{
        border:solid 1px #E2E2E2;
        padding:10px;
      }

      .cleanform select{
        float:left;
        font-size:12px;
        padding:4px 2px;
        border:solid 1px #E2E2E2;
        width:200px;
        margin:2px 0 20px 10px;
      }

      /* Button main class */
      .cleanform input.button {

        width:125px;
        height:30px;

        color:#FFFFFF;
        font-size:11px;
        font-weight:bold;

        background-color:#f5f5f5;
        border:1px solid #dedede;
        border-top:1px solid #eee;
        border-left:1px solid #eee;

        font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
        font-size:90%;
        text-decoration:none;
        font-weight:bold;
        color:#565656;
        cursor:pointer;

        background-position: 6px;
        background-repeat:no-repeat;
        text-align:center;

        margin: 5px;
        padding: 5px;
      }

    </style>
  </head>
	<body>

    <?= $tpv_form ?>

    <div class="cleanform">

    <div class="header">
			<?php if($lang=='es'){?>
				<img style="width:100%" src="templates/cabecera_es.jpg"/>
			<?}else{?>
				<img style="width:100%" src="templates/cabecera_en.jpg"/>
			<?}?>
      <h1>
        <?=TXT_METODE_DE_PAGAMENT?>
      </h1>

      <h3>
      <?=$titol_congres?>
      </h3>
      <h3>
        <?=$dates_del_congres?>
      </h3>
      <p class="description">

      </p>

    </div>

		<div>
    <!--<h3>
		  Redireccionando a la pasarela de pago en <span id="countdown">5</span> segundos
		</h3>-->

		</div>
		<!-- JavaScript part -->
		<script type="text/javascript">

		    // Total seconds to wait
		    var seconds = 5;

		    function countdown() {
		        seconds = seconds - 1;
		        if (seconds < 0) {
		            // Chnage your redirection link here
		         	document.getElementById('tpv_sermepa').submit();
		        } else {
		            // Update remaining seconds
		            document.getElementById("countdown").innerHTML = seconds;
		            // Count down using javascript
		            window.setTimeout("countdown()", 1000);
		        }
		    }

		    // Run countdown function
		    //countdown();

		</script>

    <div>
      <fieldset>
        <legend>
          <?=TXT_SELECCIONA_METODE_DE_PAGAMENT?>
        </legend>
        <table>
        <tr>
          <td>
              <span>
                <label>
                  <?=TXT_PAGAMENT_AMB_TRANSFERENCIA?>
                </label>
              </span>
          </td>
          <td>
            <span>
              <label>
                <?=TXT_PAGAMENT_AMB_TARGETA?>
              </label>
            </span>
          </td>
        </tr>
        <tr>
          <td>
              <a href="inscripcio_complete_trans.php?lang=<?=$lang?>" id="b-trans">
                <img class="clickable" src="transfer.png" width="200px" alt="Transferencia">
              </a>
          </td>
          <td>
              <a href="javascript:document.getElementById('tpv_sermepa').submit();" id="b-visa">
                <img class="clickable" src="visa.jpg" width="200px" alt="Visa">
              </a>
          </td>
        </tr>
        <tr>
          <td>
          </td>
          <td>
            <span class="small"><?=TXT_TPV_CATALUNYA_CAIXA?></span>
          </td>
        </tr>
        </table>
    </div>
    </div>
  </body>
</html>
