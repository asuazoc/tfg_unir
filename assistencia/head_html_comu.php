<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/x-icon" href="<?=CARPETA_WEB;?>/images/identitat-web/favicon.png">

<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">

<meta name="Description" CONTENT=<?=$titol_congres;?>>
<title><?=$titol_congres;?></title>

<!-- Bootstrap core CSS -->
<!-- <script src="src/jquery-ui.min.js"></script> -->
<!--official Bootstrap CDN-->
<link href="<?=CARPETA_WEB;?>/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="<?=CARPETA_WEB;?>/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?=CARPETA_WEB;?>/dist/css/starter-template.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="<?=CARPETA_WEB;?>/assets/js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="<?=CARPETA_WEB;?>/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?=CARPETA_WEB;?>/assets/js/ie10-viewport-bug-workaround.js"></script>
<!-- <script src="js/jquery.form.js"></script> -->

<!-- NEW -->
<script src="<?=CARPETA_WEB;?>/js/jquery-1.10.2.js"></script>
<script src="<?=CARPETA_WEB;?>/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?=CARPETA_WEB;?>/development-bundle/ui/jquery.validate.min.js"></script>
<script src="<?=CARPETA_WEB;?>/development-bundle/ui/jquery.validate.js"></script>
<script src="<?=CARPETA_WEB;?>/js/jquery.form.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php /*
<script src="<?=CARPETA_WEB;?>/js/bootstrap.min.js"></script>
*/?>
<script src="<?=CARPETA_WEB;?>/js/bootstrap.js"></script>

<link href="<?=CARPETA_WEB;?>/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">

<!-- JS Global
/*------------------------------------------------------------------------------->
<script type="application/javascript">
	const BASE_URL = `${window.location.origin}<?=CARPETA_WEB;?>`;
</script>



<!-- Estils Globals
------------------------------------------------------------------------------->
<style>
  /* Capçalera logotip
  ******************************************/
  div#logo-capcalera img
  {
    display: inline-block;
  }

  div#logo-capcalera h1
  {
    display       : inline-block;
    vertical-align: middle;
    text-align    : right;
    font-weight   : bold;
  }

  div#logo-capcalera h1 small
  {
    font-size: 50%;
  }
  /* Seleccionar Text
  *****************************************/
  ::-moz-selection
  {
    color     : #ffffff;
    background: #7700b3;
  }

  ::selection
  {
    color     : #ffffff;
    background: #7700b3;
  }

  /* Taules
  *****************************************/
  table.table td.valign-cell
  {
    vertical-align: inherit;
  }

  table.table td.valign-cell-center
  {
    vertical-align: center;
  }

  table#projecte
  {
    width: 55%;
  }
  table#projecte td
  {
    text-align: right;
  }
  table#projecte td input[type="file"]
  {
    float: right;
  }

  table#organitzacio td
  {
    padding: 22px 11px 22px 11px;
  }
  table#organitzacio td img
  {
    display: inline-block;
    max-width: 100%;
  }
  table#organitzacio td img[title]
  {
    cursor: help;
  }

</style>
