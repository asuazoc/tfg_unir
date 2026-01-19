<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



if ($_SERVER['REQUEST_METHOD']=="GET"){
	$accio=$_GET['accio'];
	$id=$_GET['id'];
    if ($accio=='E'){
    	    $sql="UPDATE comunicacions SET removed='S' where id=".$id;
   	    //$sql="delete from comunicacions where id=".$id;
	    mysqli_query($con,$sql);
	    header("Location: lst_comunicacions.php");
    }
	}
else{
	//agafem totes les variables
	$id=$_POST['id'];
	$accio=$_POST['accio'];
	$desti=$_POST['desti'];

	$autor=str_replace("'","''",$_POST['autor']);
	$centre_principal=str_replace("'","''",$_POST['centre_principal']);	

	
	$autors=str_replace("'","''",$_POST['autors']);
	$centre=str_replace("'","''",$_POST['centre']);	
	
	
	$categoria=$_POST['categoria'];
	$direccio=str_replace("'","''",$_POST['direccio']);
	$poblacio=str_replace("'","''",$_POST['poblacio']);
	$provincia=str_replace("'","''",$_POST['provincia']);
	$cp=$_POST['cp'];
	$tel=$_POST['tel'];
	$fax=$_POST['fax'];
	$email=$_POST['email'];
	$nif=$_POST['nif'];
	$publicacio=$_POST['publicacio'];
	$autorizacio_dni=$_POST['autorizacio_dni'];	  
	$telparticular=$_POST['telparticular'];
	$titol=str_replace("'","''",$_POST['titol']);
	$fitxerdoc=$_FILES['fitxerdoc']['name'];
	$comunicacio=$_POST['comunicacio'];
	$tematica=$_POST['tematica'];
	$tema=str_replace("'","''",$_POST['tema']);
	$resum=trim(str_replace("'","''",$_POST['resum']));
	$paraules_clau1=$_POST['paraules_clau1'];
	$paraules_clau2=$_POST['paraules_clau2'];
	$estat=$_POST['estat'];
	$comunicacio_lang=$_POST['comunicacio_lang'];

	if ($accio=='M'){
	   		$sql="UPDATE comunicacions SET desti='$desti' , autor='$autor' , centre='$centre' ,
	   		autors='$autors' , centre_principal='$centre_principal' ,
	   		categoria='$categoria' , direccio='$direccio' , 
	   		poblacio='$poblacio' , provincia='$provincia' , autorizacio_dni='$autorizacio_dni', publicacio='$publicacio',
	   		cp='$cp' , tel='$tel' , fax='$fax' , email='$email' , nif='$nif', telparticular='$telparticular',
	   		titol='$titol' ,  comunicacio='$comunicacio', tematica='$tematica', comunicacio_lang='$comunicacio_lang', 
	   		resum='$resum', estat='$estat', paraules_clau1='$paraules_clau1',paraules_clau2='$paraules_clau2' where id=".$id;
	   		mysqli_query($con,$sql);		
				//echo $sql;		      
		      header("Location: lst_comunicacions.php");
	}
 	else if ($accio=='N'){
	   		$sql="INSERT INTO comunicacions SET id=NULL , autorizacio_dni='$autorizacio_dni', publicacio='$publicacio', desti='$desti' ,nif='$nif',telparticular='$telparticular', autor='$autor' , centre='$centre' ,  comunicacio_lang='$comunicacio_lang', categoria='$categoria' , direccio='$direccio' , poblacio='$poblacio' , provincia='$provincia' , cp='$cp' , tel='$tel' , fax='$fax' , email='$email' , titol='$titol' , comunicacio='$comunicacio' , tema='$tema' , paraules_clau1='$paraules_clau1',paraules_clau2='$paraules_clau2',resum='$resum', estat='$estat',autors='$autors' , centre_principal='$centre_principal'  ";
				mysqli_query($con,$sql);
				header("Location: lst_comunicacions.php");
		}
	else{
		echo 'Accio inexistent';
		exit;
		}
	}

if (empty($accio)){
   header("Location: lst_comunicacions.php");
}

if($accio=="M"){
	$sql="select * from comunicacions where id=$id";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
}

include('header.php');
include('menu.php'); 
ini_set('display_errors', 0);
?>
<script type="text/javascript" src="js/prototype.js"></script>
</div>
</div> <!-- End #sidebar -->
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript>
<!-- Show a notification if the user has disabled javascript --> <div
class="notification error png_bg"> <div> Javascript is disabled or is
not supported by your browser. Please <a href="http://browsehappy.com/"
title="Upgrade to a better browser">upgrade</a> your browser or <a
href="http://www.google.com/support/bin/answer.py?answer=23852"
title="Enable Javascript in your browser">enable</a> Javascript to
navigate the interface properly. </div> </div> </noscript>
		
<h2>Comunicacions</h2>
			<p id="page-intro">Gesti&oacute; comunicacions</p>
			
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Comunicaci&oacute;</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Assistent</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">

			<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
			
			
			
			<form action="adm_comunicacions.php" method="post" class="f-wrap-1" enctype="multipart/form-data" onsubmit="return validar_doc();" >
			<fieldset>
	<input id="desti" name="desti" type="hidden" class="f-name" tabindex="1" value="Jornada" size="40"/>
<?if($accio=="M"){?> 
<label for="autor">
 ID: <?=$row['id']?>
</label>
<?}?>

<label for="autor"> Autor Signant:</label>
<input id="autor" name="autor" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['autor']) :'' ?>" size="20" /><br />
<label for="centre_principal"> Centre Signant:</label>
<input id="centre_principal" name="centre_principal" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['centre_principal']) :'' ?>" size="40"/>

<label for="nif"> NIF:</label>
<input id="nif" name="nif" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['nif']) :'' ?>" size="20" /><br />
<label for="telparticular"> tel particular:</label>
<input id="telparticular" name="telparticular" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['telparticular']) :'' ?>" size="40"/>

<label for="autors"> Autors:</label>
<input id="autors" name="autors" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['autors']) :'' ?>" size="20" /><br />
<label for="centre"> Centre:</label>
<input id="centre" name="centre" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['centre']) :'' ?>" size="40"/>

<label for="email"> Email:</label>
<input id="email" name="email" type="text"  class="text-input small-input"  class="required validate-email" value="<?=($accio=="M")? $row['email'] :'' ?>" size="75" maxlength="75"/><br />
<label for="titol"> Titol:</label>
<input id="titol" name="titol" type="text"  class="text-input medium-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['titol']) :'' ?>" size="100" maxlength="255"/><br />



<label for="paraules_clau"> Paraules clau:</label>

		      <div class="spacer"></div> 
		      <br/>Primera Opción:
		      <div class="spacer"></div>   
		      <select name="paraules_clau1"
	            id="paraules_clau1"
	            class="required">
	            <option value="">---</option>
	          	<?foreach ($paraules_clau as $key => $value){?>
					<option value="<?=$key?>"
					<?if($row['paraules_clau1']==$key){?>
						selected="true"
					<?}?>
					><?=$paraules_clau[$key]['es']?></option>
				<?}?>
			  </select>  
			  <div class="spacer"></div> 
			  <br/>Segunda Opción:  
			  <div class="spacer"></div> 
		      <select name="paraules_clau2"
	            id="paraules_clau2">
	            <option value="">---</option>
	          	<?foreach ($paraules_clau2 as $key => $value){?>
					<option value="<?=$key?>"
					<?if($row['paraules_clau2']==$key){?>
						selected="true"
					<?}?>
					><?=$paraules_clau2[$key]['es']?></option>
				<?}?>
			  </select>







<label for="resum"> Resum:</label>
<textarea name="resum" rows="7" cols="60"><?=($accio=="M")?trim(htmlspecialchars($row['resum'])):'' ?></textarea>

<br/>

<!--TEMÀTIQUES-->
<span>
	<label for="tematica">Temàtica:</label>
	<table> 
	<?foreach ($tematica as $key => $value){?>
		<tr>
			<td><?=$tematica[$key]?></td>
			<td><input name="tematica" value="<?=$key?>" type="radio"  <?if($row['tematica']==$key) echo 'checked';?>/></td>
		</tr>
	<?}?>
	</table>
</span>
<br/>

<!--PREFERENCIES-->
<span>
	<label for="preferencia">Preferència:</label>
	<table> 
	<?foreach ($comunicacio as $key => $value){?>
		<tr>
			<td><?=$comunicacio[$key]['es']?></td>
			<td><input name="comunicacio" value="<?=$key?>" type="radio"  <?if($row['comunicacio']==$key) echo 'checked';?>/></td>
		</tr>
	<?}?>
	</table>
</span>
<br/>

<label for="estat"> Estat:</label>
<select name="estat" size="1">
	<option value="Pendet valoració" label="Pendet valoració" <?=($accio=="M" && $row['estat']=='Pendet valoració')? 'selected' :'' ?>>Pendet valoració</option>
	<option value="Acceptat" label="Acceptat" <?=($accio=="M" && $row['estat']=='Acceptat')? 'selected' :'' ?>>Acceptat</option>
	<option value="Descartat" label="Descartat" <?=($accio=="M" && $row['estat']=='Descartat')? 'selected' :'' ?>>Descartat</option>
</select>

<br/>

<label for="comunicacio_lang"> Idioma:</label>
<select name="comunicacio_lang">
	<option value=""></option>
<?foreach ($comunicacio_lang as $key => $value){?>
	<option value="<?=$key?>" <?=($accio=="M" && $row['comunicacio_lang']==$key)? 'selected' :'' ?>><?=$comunicacio_lang[$key]?></option>
<?}?>
</select>
<br>


<label for="publicacio"> Publicació:</label>
Si<input type="radio" name="publicacio" type="text"  class="text-input small-input"  class="required" value="S" 
<?php if($row['publicacio']=='S'){?>
checked="true"
<?}?>/><br/>
No<input type="radio" name="publicacio" type="text"  class="text-input small-input"  class="required" value="N" 
<?php if($row['publicacio']!='S'){?>
checked="true"
<?}?>/><br />
<label for="autorizacio_dni"> NIF autorització:</label>
<input id="autorizacio_dni" name="autorizacio_dni" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['autorizacio_dni']) :'' ?>" size="40"/>



<input name="accio" id="accio" type="hidden" value="<?=$accio?>" />
<input name="id" type="hidden" value="<?=$id?>" />
		  
		</fieldset>

			<br/>
			<input class="button" value="Enviar" type="submit">
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
			
			
<? include('footer.php') ?>			
