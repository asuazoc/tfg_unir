<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



if ($_SERVER['REQUEST_METHOD']=='GET'){
	$id=$_GET['id'];
	$user=$_SESSION['user'];
	$sql="select * from comunicacions where id=$id";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Comunicaciones</title>

<script type='text/javascript' src='js/domready.js'></script>

<style type="text/css">
	body {
		background-color: #ECEDF1;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>

</head>

<body>
<form name="frm" action="" method="post" onsubmit="return validateForm()">
	<table width="75%"  border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">
	  <tr>
	    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1">Resumen de la comunicación num. <?=$row['id']?> </h2></td>
	  </tr>
	  <tr>
	    <td><strong><br>
	    Título:</strong> <?=htmlspecialchars($row['titol'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Autor firmante:</strong> <?=htmlspecialchars($row['autor'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Centro firmante:</strong> <?=htmlspecialchars($row['centre_principal'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Otros autores:</strong> <?=htmlspecialchars($row['autors'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Centros otros autores:</strong> <?=htmlspecialchars($row['centre'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Email:</strong> <?=htmlspecialchars($row['email'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Preferencia:</strong> <?=htmlspecialchars($comunicacio[$row['comunicacio']]['es'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Opción 1:</strong> <?=htmlspecialchars($paraules_clau[$row['paraules_clau1']]['es'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Opción 2:</strong> <?=htmlspecialchars($paraules_clau2[$row['paraules_clau2']]['es'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Autorización:</strong> <?=htmlspecialchars($siNo[$row['publicacio']]['es'])?></td>
	  </tr>
	  <tr>
	  	<td><strong><br>
	    Idioma:</strong> <?=htmlspecialchars($row['comunicacio_lang'])?></td>
	  </tr>
	  <tr>
	    <td><strong><br>
	    Resumen:</strong><br><?=nl2br(htmlspecialchars($row['resum']))?><br>
	    <br></td>
	  </tr>
	</table>

</form>
</body>
</html>
