<?
include('vars.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);
$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

$sql= "select * from comunicacions where removed='N' and email = '".$_REQUEST['email']."' and code = '".$_REQUEST['code']."'";
$result= mysqli_query($con,$sql);
$num= mysqli_num_rows ($result);
if( $num != 1 )
{
    header("Location: comunicacions_view_login.php");
    exit();
}
$row=@mysqli_fetch_assoc($result);

if($row['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else if($row['lang']=='ca'){
	include('lang_ca.php');
	$lang = 'ca';
}else{
	include('lang_es.php');
	$lang = 'es';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=TXT_COMUNICACIO?></title>
<style type="text/css">
<!--
body {
	background-color: #ECEDF1;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
-->
</style>

<script type="text/javascript">

function delete_comunicacions(formObj) {

    if(confirm("<?=TXT_RETIRAR_COMUNICACIO?>"))
              {
                      return true;
              }
              else {
                      return false;
             }

}
</script>

</head>

<body>

<table width="75%"  border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">
  <tr>
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1">Num.: <?=$row['id']?></h2></td>
  </tr>
  <!--<tr>
    <td >
    <a href="comunicacions_remove.php?id=<?=$row['id']?>&email=<?=$row['email']?>"  onclick='return delete_comunicacions(this);'>Retirar comunicació</a>
    </td>
  </tr>-->
  <tr>
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1"><?=TXT_TITOL_COMUNICACIO?>: <?=$row['titol']?></h2></td>
  </tr>
<tr>
    <td>
    <strong><?=TXT_NOM_COGNOMS?>: </strong>
	 <br />
    <p>
    	<?=$row['autor']?>
    </p>
    </td>
  </tr>
     <tr>
    <td>
    <strong><?=TXT_CENTRE_TREBALL?>: </strong>
	 <br />
    <p>
    	<?=$row['centre_principal']?>
    </p>
    </td>
  </tr>
    <tr>
    <td>
    <strong><?=TXT_COMUNICACIO_CORREU_ELECTRONIC?>: </strong>
	 <br />
    <p>
    	<?=$row['email']?>
    </p></td>
  </tr>
    <tr>
    <td>
    <strong><?=TXT_AUTORES?>: </strong>
	 <br />
    <p>
    	<?=$row['autors']?>
    </p>
    </td>
  </tr>

  <tr>
    <td>
    <strong><?=TXT_CENTRE_TREBALL?>: </strong>
	 <br />
    <p>
    	<?=$row['centre']?>
    </p>
    </td>
  </tr>

	<tr>
    <td>
    <strong><?=TXT_PARAULES_CLAU?>: </strong>
	 <br />
    <p>
    	<?=TXT_PRIMER_OPCIO?>: <br/><?=$paraules_clau[$row['paraules_clau1']][$lang]?>
		<br/>
		<br/>
    	<?=TXT_SEGONA_OPCIO?>: <br/><?=$paraules_clau2[$row['paraules_clau2']][$lang]?>
    </p>
	</td>
  </tr>

    <tr>
    <td>
    <strong><?=TXT_PREFERENCIA?>: </strong>
	 <br />
    <p>
    	<?=$comunicacio[$row['comunicacio']][$lang]?>
    </p></td>
  </tr>

      <tr>
    <td>
    <strong><?=TXT_PREFERENCIA_LANG?>: </strong>
	 <br />
    <p>
    	<?=$comunicacio_lang[$row['comunicacio_lang']]?>
    </p></td>
  </tr>

  <tr>
    <td>
    <strong><?= TXT_RESUM ?>:</strong>
	 <br />
    <p>
    	<?=$row['resum']?>
    </p>
    </td>
  </tr>

   <!--<tr>
    <td>
    <strong>Estat:</strong>
	 <br />
    <p>
    	<?= $row['estat']?>
    </p>
    </td>
  </tr>-->

</table>

<br>

</body>
</html>
