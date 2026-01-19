<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

$id=$_GET['id'];
$sql="select * from abstracts where id=$id";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Abstracts</title>
<style type="text/css">
<!--
body {
	background-color: #ECEDF1;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
-->
</style></head>

<body>

<table width="75%"  border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">
  <tr>
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1">Resum de l'abstract num. <?=$_GET['num']?> </h2></td>
  </tr>
  <tr>
    <td> 
			<br>
			<strong>Paraules clau:</strong> <?=$row['paraules_clau']?></td>
  </tr>
  <tr>
    <td><strong><br>
    Titol:</strong> <?=$row['titol']?></td>
  </tr>
  <tr>
    <td><strong><br>
    Preferencia:</strong> <?=$row['comunicacio']?></td>
  </tr>
  <tr>
    <td><strong><br>
    Resum:</strong><br><br><a href="../upload/abstracts/<?=$row['resum']?>"><?=$row['resum']?></a><br>
    <br></td>
  </tr>
</table>
</body>
</html>
