<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
$id=$_GET['id'];
$sql="select * from comunicacions where id=$id";
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);


$sql2="select * from autors_comunicacio where id=$id";
$i=1;
foreach ($con->query($sql2) as $row2){
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
<title>Comunicacions</title>
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
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1">Resum de la comunicaci&oacute; num. <?=$row['id']?> </h2></td>
  </tr>
  <tr>
    <td>   
			<br>
			<strong>Paraules clau:</strong> <?=$paraules_clau[$row['paraules_clau1']]['es']?>,<?=$paraules_clau2[$row['paraules_clau2']]['es']?>
	</td>
  </tr>
  <tr>
    <td><strong><br><?=htmlspecialchars($row['titol'])?></strong> </td>
  </tr>

  <tr>
    <td>
	<p>
	<strong>Autor principal:</strong> <?=htmlspecialchars($row['autor'])?><br/>
	<strong>Centre autor principal:</strong> <?=htmlspecialchars($row['centre_principal'])?>
	</p>
	<p>
	<strong>Altres autors:</strong> <?=htmlspecialchars($row['autors'])?><br/>
	<strong>Centres altres autors:</strong> <?=htmlspecialchars($row['centre'])?>
	</p>	
	</td>
  </tr>

  <tr>
    <td><strong><br>
    Resum:</strong><br><?=nl2br(htmlspecialchars($row['resum']))?><br>
    <br></td>
  </tr>


  <?php /*
   <!--tr>
    <td>
    <strong>Estat:</strong>
	 <br />    
    <p>
    	<?= $row['estat']?>
    </p>
    </td>
  </tr-->

  <!--tr>
    <td>
    <strong>Notes:</strong>
    </td>
  </tr-->
*/?>

<?
//$res_notes=mysqli_query($con,"select user,nota from `comunicacions_nota` where id = '$id'");
//while($row_notes=mysqli_fetch_assoc($res_notes)){
/*?>
  <!--tr>
    <td>
    <strong><?=$row_notes['user']?>:</strong> <?=$row_notes['nota']?>
    </td>
  </tr-->
<?
 //}
*/?>
</table>
</body>
</html>
