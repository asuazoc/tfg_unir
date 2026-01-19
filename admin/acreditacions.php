<?
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$titol_congres?></title>
<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="css/ie6_or_less.css" />
<![endif]-->
<script type="text/javascript" src="js/common.js"></script>
</head>
<body id="type-b">
<div id="wrap">

	<div id="header">
		<div id="site-name">acreditacions</div>
		<br />
	</div>
	
	<div id="content-wrap">
	
<? include("menu.php"); ?>

		<div id="content">
		
			<div id="breadcrumb">
			<a href="#">Home</a>  / <strong>acreditacions</strong>			</div>
			<div id="footer"></div>
                        <table class="table1">
			<thead>
				<tr>
				<th colspan="20">Table acreditacions</th>
				</tr>
			</thead>
			<tbody>
			<tr>
<th>id</th>
<th>categoria</th>
<th>trac</th>
<th>cognoms</th>
<th>nom</th>
<th>treball</th>
</tr><?
$res=mysqli_query($con,'SELECT * FROM inscripcions ORDER BY id');
while($row=mysqli_fetch_assoc($res)){
?>
     <tr>
      <td><?=$row['id'];?></td>
      <td><?=$row['categoria'];?></td>
      <td><?=$row['tractament'];?></td>
      <td><?=$row['cognoms'];?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['lloctreball'];?></td>
      </tr>
<?
}
?>
			</tbody>
		  </table>

		
			<hr />
			<br />
			
			
			
			
		</div>
		
		
		
	</div>
	
</div>
</body>
</html>
