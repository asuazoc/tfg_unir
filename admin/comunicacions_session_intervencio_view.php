<?
include('../vars.inc.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$sql= "select * from comunicacions_sessio where id = '".$_GET['id']."'";
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

if($row['lang']=='en'){
	include('../lang_en.php');
	$lang = 'en';
}else{
	include('../lang_es.php');
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
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1">Num.: <?=$row['id_sessio']?></h2></td>
  </tr>
<?php /*?>
  <!--<tr>
    <td >
    <a href="comunicacions_remove.php?id=<?=$row['id']?>&email=<?=$row['email']?>"  onclick='return delete_comunicacions(this);'>Retirar comunicació</a>
    </td>
  </tr>-->
<?php */?>
  <tr>
    <td ><h2 style="color:#FFFFFF;background-color:#C4C1C1"><?=TXT_TITOL?>: <?=$row['titol_sessio']?></h2></td>
  </tr>
  <tr><td><h3><?=TXT_DADES_CONTACTE?></h3>
  <tr>
	    <td>
	    	<strong><?=TXT_NOM_COGNOMS?>: </strong><?=$row['nom_contacte']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_COMUNICACIO_CORREU_ELECTRONIC?>: </strong><?=$row['email_contacte']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_COMUNICACIO_CORREU_ELECTRONIC?>: </strong><?=$row['email_contacte']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_COMUNICACIO_TEL_PARTICULAR?>: </strong><?=$row['tel_contacte']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_CENTRE_TREBALL?>: </strong><?=$row['centre_treball_contacte']?>
	    </td>
  	</tr>
  	<?php if($row['publicacio']=='S'){?>
  		<tr>
		    <td>
		    	<strong>DNI: </strong><?=$row['autorizacio_dni']?>
		    </td>
  		</tr>
  	<?php }?>
  <tr><td><hr/></td></tr>
  <tr>
    <td> 
    <strong><?=TXT_SOCIO?> 1: </strong><?=$row['coordinador1']?>
    </td>
  </tr>
     <tr>
    <td> 
    <strong><?=TXT_SOCIO?> 2: </strong><?=$row['coordinador2']?>
    </td>
  </tr>
    <tr>
    <td> 
    <strong><?=TXT_RESUM_OBJECTIUS_SESSIO?>: </strong>
	 <br />    
    <p>
    	<?=nl2br(htmlspecialchars($row['resum_objectius']))?>
    </p></td>
  </tr>
    <tr>
    <td>
    <strong><?=TXT_IDIOMA?>: </strong><?=$row['idioma']?>
    </td>
  </tr>
  <tr>
    	<td> 
    		<strong><?=TXT_PARAULES_CLAU?>: </strong>
	 		<p>
		    	<?=TXT_PRIMER_OPCIO?>: <br/><?=$paraules_clau[$row['paraules_clau1']][$lang]?>
				<br/>
		    	<?=TXT_SEGONA_OPCIO?>: <br/><?=$paraules_clau2[$row['paraules_clau2']][$lang]?>
		    </p>
		</td>
  	</tr>
  
  <tr>
    <td>
    <h3><?=TXT_INTERVENCIO?></h3>    
    </td>
  </tr>
  <tr><td><hr/></td></tr>
	<?php 
	/*$sql= "select * from comunicacions_sessio where removed='N' and email_contacte = '".$_REQUEST['email']."' and code = '".$_REQUEST['code']."' ORDER BY id_intervencio ASC";
	$resultI= mysqli_query($con,$sql);
	while($rowI=mysqli_fetch_assoc($resultI)){*/
	?>
	<tr>
	    <td>
	    	<strong>Num: </strong><?=$row['id_intervencio']?>
	    </td>
  	</tr>
	<tr>
	    <td>
	    	<strong><?=TXT_AUTORES?>: </strong><?=$row['autors']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_CENTRE_TREBALL?>: </strong><?=$row['centres_treball']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_TEL?>: </strong><?=$row['telefon']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_CORREU_ELECTRONIC?>: </strong><?=$row['email']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_TITOL?>: </strong><?=$row['titol']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_RESUM_INTERVENCIO?>: </strong>
	    	<br><?=nl2br(htmlspecialchars($row['resum_intervencio']))?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_NOM_COMENTARISTES?>: </strong><?=htmlspecialchars($row['comentaristes'])?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_CENTRE_TREBALL?>: </strong><?=$row['centres_treball_comentaristes']?>
	    </td>
  	</tr>
  	<tr>
	    <td>
	    	<strong><?=TXT_CORREU_ELECTRONIC?>: </strong><?=$row['email_comentaristes']?>
	    </td>
  	</tr>
	<tr><td><hr/></td></tr>
  	<?/*}?>
    <!--<tr>
    <td>
    <strong>Estat:</strong>
	 <br />    
    <p>
    	<?= $row['estat']?>
    </p>
    </td>
  </tr>-->
  	<?*/?>

</table>

<br>

</body>
</html>
