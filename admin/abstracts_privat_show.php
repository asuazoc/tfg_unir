<?
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

$id=$_GET['id'];
$sql="select * from abstracts where id=$id";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);


$sql2="select * from autors_abstract where id=$id";
$res2=mysqli_query($con,$sql2);
$i=1;

while($row2 = mysqli_fetch_row($res2)){
	if ($row['centre']==$row2[2]){
		$autors.=", ".$row2[1];
	}
	else {
		$autors.=", ".$row2[1]." ($i)";
		$centre.=", ".$row2[2]." ($i)";
	}
	$i++;
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
			<strong>Paraules clau:</strong> <?=$row['paraules_clau']?>
	</td>
  </tr>
  <tr>
    <td><strong><br><?=$row['titol']?></strong> </td>
  </tr>

  <tr>
    <td>
	<p>
	<?= $row['autor'].$autors ?>
	</p>
	<br>
<p>
	<?= $row['centre'].$centre ?>

	</p>
</td>
  </tr>

  <tr>
    <td><strong><br>
    Resum:</strong><br><br><a href="../upload/abstracts/<?=$row['resum']?>"><?=$row['resum']?></a><br>
    <br></td>
  </tr>

</table>
</body>
</html>
