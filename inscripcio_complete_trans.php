<?php
include('vars.inc.php');
include('lang_es.php');
$lang = 'es';
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
        font-size:12px;
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

    <div class="cleanform">

    <div class="header">
	  	<img style="width:100%" src="templates/cabecera_es.jpg"/>
      <h1>
        <?=TXT_TITOL_FORM_INSCRIPCIO?>
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
      <fieldset>
        <legend><?=TXT_FORMA_PAGAMENT_TITOL?></legend>
        <div class="text">
        	<br />
	        <?=TXT_FORMA_PAGAMENT?>
			<br /><br />
			<?=TXT_NUM_COMPTE?> <?=$ccc?><br />
			<?=TXT_IBAN?> <?=$iban?><br />
			SWIFT: <?=$swift_code?><br /><br />
			<?=TXT_FIRMA?><br />
          	<?=$correu_congres?>
          	<br />
            <br />
        </div>
      </fieldset>


    </div>
    </div>
  </body>
</html>
