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
	$sql_nota ="select * from comunicacions_nota where id='".$row['id']."' and user='".$user."'";
	$res_note=mysqli_query($con,$sql_nota);
	$row_nota=mysqli_fetch_assoc($res_note);

} else if ($_SERVER['REQUEST_METHOD']=='POST'){
	$id=$_POST['id'];
	$user=$_POST['user'];
	$nota1=$_POST['nota1'];
	$nota2=$_POST['nota2'];
	$nota3=$_POST['nota3'];
	$nota4=$_POST['nota4'];
	$nota5=$_POST['nota5'];
	$nota6=$_POST['nota6'];
	$recomanacio=$_POST['recomanacio'];
	$notatotal=$_POST['notatotal'];

	$result = mysqli_query($con,"select * from `comunicacions_nota` where id = '$id' and user='$user'");
	if (mysqli_num_rows($result) > 0) {
	   mysqli_query($con,"UPDATE `comunicacions_nota` SET nota1='$nota1',nota2='$nota2',nota3='$nota3',nota4='$nota4',nota5='$nota5',nota6='$nota6',notatotal='$notatotal',recomanacio='$recomanacio'  WHERE id = '$id' and user='$user' ");
	} else {
	   mysqli_query($con,"INSERT INTO  `comunicacions_nota` ( `id` ,`user` ,`nota1`,`nota2`,`nota3`,`nota4`,`nota5`,`nota6`,`notatotal`,`recomanacio`) VALUES ('$id','$user','$nota1','$nota2','$nota3','$nota4','$nota5','$nota6','$notatotal','$recomanacio')");
	}

	
	header("Location: lst_comunicacions_avaluacio.php");
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Comunicaciones</title>

<script type='text/javascript' src='js/domready.js'></script>

<script>

function validate(evt) {
	  var theEvent = evt || window.event;
	  var key = theEvent.keyCode || theEvent.which;
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  	if( !regex.test(key) ) {
	    		theEvent.returnValue = false;
	    		if(theEvent.preventDefault) theEvent.preventDefault();
  		}
}

function sum(){
	var nota1 = parseFloat(document.getElementById("nota1").value);
	var nota2 = parseFloat(document.getElementById("nota2").value);
	var nota3 = parseFloat(document.getElementById("nota3").value);
	var nota4 = parseFloat(document.getElementById("nota4").value);
	var nota5 = parseFloat(document.getElementById("nota5").value);
	var nota6 = parseFloat(document.getElementById("nota6").value);

	var sum=0;
	sum=nota1+nota2+nota3+nota4+nota5+nota6;
	sum=sum.toFixed(2);
	
	if(!isNaN(sum)){
	 	document.getElementById("notatotal").value=sum;
}

}

function isOnInterval(value){
	if (value>=0 && value<=2){
	return true;
	}
	return false;
}


function isOnInterval(value,max){
	if (value>=0 && value<=max){
	return true;
	}
	return false;
}


function validateForm()
{

	var nota1 = parseFloat(document.getElementById("nota1").value);
	var nota2 = parseFloat(document.getElementById("nota2").value);
	var nota3 = parseFloat(document.getElementById("nota3").value);
	var nota4 = parseFloat(document.getElementById("nota4").value);
	var nota5 = parseFloat(document.getElementById("nota5").value);
	var nota6 = parseFloat(document.getElementById("nota6").value);
	
	if (  isOnInterval(nota1,1) && isOnInterval(nota2,1) && isOnInterval(nota3,2) && isOnInterval(nota4,2) && isOnInterval(nota5,2) && isOnInterval(nota6,2)){
		return true;
	}
	
	alert("Formato de nota no valido en algun item");
	return false;

}


DOMReady.add(function (){

});

</script>

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
    Titulo:</strong> <?=htmlspecialchars($row['titol'])?></td>
  </tr>


  <tr>
    <td><strong><br>
    Resumen:</strong><br><?=nl2br(htmlspecialchars($row['resum']))?><br>
    <br></td>
  </tr>

</table>

<table width="75%"  border="0" align="center" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">

 	   <tr>
	    <td>
			<strong>Evaluación:</strong>
			<!--ul>
				<li>RESUMEN ESTRUCTURADO Y CLARO (0-1)</li>
				<li>OBJETIVOS CLAROS Y FACTIBLES (0-1)</li>
				<li>DISEÑO Y METODOLOGÍA ADECUADOS (0-2)</li>
				<li>RESULTADOS PRESENTACIÓN ADECUADA (0-2)</li>
				<li>RELEVANCIA DEL TEMA (0-2)</li>
				<li>ORIGINALIDAD CONTRIBUCIÓN DEL TRABAJO (0-2)</li>
			</ul-->
	   </td>
	
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_1">RESUMEN ESTRUCTURADO Y CLARO (0-1 puntos)</div>
		<input type="text" name="nota1" id="nota1" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota1'])?  "0.00" : $row_nota['nota1'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_2">OBJETIVOS CLAROS Y FACTIBLES (0-1 puntos)</div>
		<input type="text" name="nota2" id="nota2" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota2'])?  "0.00" : $row_nota['nota2'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_3">DISEÑO Y METODOLOGÍA ADECUADOS (0-2 puntos)</div>
		<input type="text" name="nota3" id="nota3" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota3'])?  "0.00" : $row_nota['nota3'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_4">RESULTADOS PRESENTACIÓN ADECUADA (0-2 puntos)</div>
		<input type="text" name="nota4" id="nota4" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota4'])?  "0.00" : $row_nota['nota4'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>	
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_5">RELEVANCIA DEL TEMA (0-2 puntos)</div>
		<input type="text" name="nota5" id="nota5" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota5'])?  "0.00" : $row_nota['nota5'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>	
	  </tr>
	  <tr>
	    <td>
                <div id="criteri_6">ORIGINALIDAD CONTRIBUCIÓN DEL TRABAJO (0-2 puntos)</div>
		<input type="text" name="nota6" id="nota6" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?= (empty($row_nota['nota6'])?  "0.00" : $row_nota['nota6'])?>" onkeypress='validate(event)' onchange="sum()" />
	   </td>	
	  </tr>
	  <tr>
	    <td><strong>TOTAL:</strong><br>
		(auto calculado)
		<input type="text" name="notatotal" id="notatotal" maxlength="4" size="4"  onfocus="if(this.value == '0.00') { this.value = ''; }" value="<?=$row_nota['notatotal']?>" readonly="true" />
	   </td>
	  </tr>
	<tr>
	    	<td> 
		    	<strong>Preferencia Autor: </strong>
			<br />    
		    	<p>
    				<?=$comunicacio_eval[$row['comunicacio']]?>
		    	</p>
		</td>
	</tr>
	<tr>
	    	<td>
		    	<strong>Recomendación si es diferente a la preferencia del autor: </strong>
			<br />    
		    	<p>
				<select name="recomanacio">
				  <option value="igual" <?=($row_nota['recomanacio']=="igual") ? 'selected':''  ?> >Igual</option>
				  <option value="comunicacio" <?=($row_nota['recomanacio']=="comunicacio") ? 'selected':''  ?>>Comunicación</option>
				  <option value="poster" <?=($row_nota['recomanacio']=="poster") ? 'selected':''  ?>>Póster</option>
				  <option value="rechazada" <?=($row_nota['recomanacio']=="rechazada") ? 'selected':''  ?>>Rechazada</option>
				</select>
		    	</p>
		</td>
	</tr>

	<tr>
	      	<td>
		<input type="submit" value="Validar" />
		</td>
	  </tr>

	</table>
	
		<input type="hidden" name="id" value="<?=$row['id']?>"/>
		<input type="hidden" name="user" value="<?=$_SESSION['user']?>"/>  

	</form>
</body>
</html>
