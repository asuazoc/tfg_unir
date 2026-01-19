<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");


if ($_SERVER['REQUEST_METHOD']=="GET"){
	$accio=$_GET['accio'];
	$id=$_GET['id'];
    if ($accio=='E'){
   	    $sql="delete from abstracts where id=".$id;
	    mysqli_query($con,$sql);
	    $sql="delete from autors_abstract where id=".$id;
	    mysqli_query($con,$sql);
	    header("Location: lst_abstracts.php");
    }
	}
else{
	//agafem totes les variables
	$id=$_POST['id'];
	$accio=$_POST['accio'];
	$desti=$_POST['desti'];
	$autor=$_POST['autor'];
	$centre=$_POST['centre'];
	$categoria=$_POST['categoria'];
	$direccio=$_POST['direccio'];
	$poblacio=$_POST['poblacio'];
	$provincia=$_POST['provincia'];
	$cp=$_POST['cp'];
	$tel=$_POST['tel'];
	$fax=$_POST['fax'];
	$email=$_POST['email'];
	$titol=$_POST['titol'];
	$fitxerdoc=$_FILES['fitxerdoc']['name'];
	$comunicacio=$_POST['comunicacio'];
	$tematica=$_POST['tematica'];
	$tema=$_POST['tema'];
	$paraules_clau=$_POST['paraules_clau'];
	$total_autors=$_POST['autors'];
	$total_autors_OLD=$_POST['autors_OLD'];

	if ($accio=='M'){
		if($fitxerdoc==''){
	   		$sql="UPDATE abstracts SET desti='$desti' , autor='$autor' , centre='$centre' , categoria='$categoria' , direccio='$direccio' , poblacio='$poblacio' , provincia='$provincia' , cp='$cp' , tel='$tel' , fax='$fax' , email='$email' , titol='$titol' ,  comunicacio='$comunicacio', tematica='$tematica' where id=".$id;
			mysqli_query($con,$sql);
		}else{

			$tipusFitxer = $_FILES['fitxerdoc']['type'];
			$tamany = $_FILES['fitxerdoc']['size'];


			$nomFitxerNou=time().'.doc';

			//compruebo si las características del archivo son las que deseo
			if ($tamany > 10000000) {
			    	echo "El tamany supera les els 10Mb.";
			}else{
			    	if (move_uploaded_file($_FILES['fitxerdoc']['tmp_name'], "../upload/abstracts/".$nomFitxerNou)){
					//echo "Fitxer carregat correctament.";
					chmod("../upload/abstracts/".$nomFitxerNou, 0777);

					$sql="UPDATE abstracts SET desti='$desti' , autor='$autor' , centre='$centre' , categoria='$categoria' , direccio='$direccio' , poblacio='$poblacio' , provincia='$provincia' , cp='$cp' , tel='$tel' , fax='$fax' , email='$email' , titol='$titol' , resum='$nomFitxerNou' , comunicacio='$comunicacio', tematica='$tematica' where id=".$id;
					mysqli_query($con,$sql);
				}
			}
		}

		for($i=1;$i<=$total_autors_OLD;$i++){
			$sql="UPDATE autors_abstract SET autor='".addslashes($_POST['autor'.$i])."' , centre='".addslashes($_POST['centre'.$i])."' where id=".$id." and num_autor=".$i;
			mysqli_query($con,$sql);
		}
		for($i=$total_autors_OLD+1;$i<=$total_autors;$i++){
			$sql="INSERT INTO autors_abstract SET id=".$id.", autor='".addslashes($_POST['autor'.$i])."' , centre='".addslashes($_POST['centre'.$i])."', num_autor=".$i;
			mysqli_query($con,$sql);
		}


		header("Location: lst_abstracts.php");
	}


	else if ($accio=='N'){
		$tipusFitxer = $_FILES['fitxerdoc']['type'];
		$tamany = $_FILES['fitxerdoc']['size'];


		$nomFitxerNou=time().'.doc';

		//compruebo si las características del archivo son las que deseo
		if ($tamany > 10000000) {
		    	echo "El tamany supera les els 10Mb.";
		}else{
		    	if (move_uploaded_file($_FILES['fitxerdoc']['tmp_name'], "../upload/abstracts/".$nomFitxerNou)){
				//echo "Fitxer carregat correctament.";
				chmod("../upload/abstracts/".$nomFitxerNou, 0777);

		   		$sql="INSERT INTO abstracts SET id=NULL , desti='$desti' , autor='$autor' , centre='$centre' , categoria='$categoria' , direccio='$direccio' , poblacio='$poblacio' , provincia='$provincia' , cp='$cp' , tel='$tel' , fax='$fax' , email='$email' , titol='$titol' , resum='$nomFitxerNou' , comunicacio='$comunicacio' , tema='$tema' , paraules_clau='$paraules_clau' ";
				mysqli_query($con,$sql);
				$sql="SELECT max(id) FROM abstracts";
				$result=mysqli_query($con,$sql);
				$autors=$_POST['autors'];
				if($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					for($i=1;$i<=$autors;$i++){
						$autor=addslashes($_POST['autor'.$i]);
						$centre=addslashes($_POST['centre'.$i]);
						$sql="INSERT INTO autors_abstract SET id='".$row['max(id)']."',autor='$autor', centre='$centre', num_autor='$i'";
						mysqli_query($con,$sql);
					}
					//ob_start();

				}

			}
		}
       //$id=mysqli_insert_id($con);
       //$accio='M';
   header("Location: lst_abstracts.php");
		}
	else{
		echo 'Acci&oacute; inxeistent';
		exit;
		}
	}

if (empty($accio)){
   header("Location: lst_abstracts.php");
}
if($accio=="M"){
$sql="select * from abstracts where id=$id";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);

$sql2="select * from autors_abstract where id=$id order by num_autor";
$res2=mysqli_query($con,$sql2);
}
include('header.php');
include('menu.php');
?>

<!--<script type="text/javascript" src="js/prototype.js"></script>-->
<script type="text/javascript">

function validar_doc(){
	var arxiu=document.getElementById("fitxerdoc").value;
	var accio=document.getElementById("accio").value;
	if(arxiu==''){
		if(accio=='N'){
			alert("Falta el fitxer del resum")
			return false;
		}else{
			return true;
		}
	}else{
		var extensio = (arxiu.substring(arxiu.lastIndexOf("."))).toLowerCase();
		if(extensio!='.doc'){
			alert("El fitxer ha de ser de Word(.doc)");
			return false;
		}
		else{
			return true;
		}
	}
}


function afegirAutor(){
	var autors= parseFloat(document.getElementById("autors").value)+1;
	var url = 'afegir_autor.php';
	document.getElementById("autors").value=autors;
	var params = '&autors='+autors;
	$.ajax({
		type: "POST",
		url: url,
		data: params,
		success: resultatAfegirAutor,
	});
}

function resultatAfegirAutor(request) {
	var autor=document.getElementById("autors").value;
	document.getElementById("nou_autor"+autor).innerHTML=request;
}

function reportError(request) {
	$('ERROR').value = "Error";
}
</script>


</div></div> <!-- End #sidebar -->

		<div id="main-content"> <!-- Main Content Section with everything -->

			<noscript>
<!-- Show a notification if the user has disabled javascript --> <div
class="notification error png_bg"> <div> Javascript is disabled or is
not supported by your browser. Please <a href="http://browsehappy.com/"
title="Upgrade to a better browser">upgrade</a> your browser or <a
href="http://www.google.com/support/bin/answer.py?answer=23852"
title="Enable Javascript in your browser">enable</a> Javascript to
navigate the interface properly. </div> </div> </noscript>

<h2>Abstracts</h2>
			<p id="page-intro">Editar abstracts</p>


			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Abstract</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Assistent</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">

			<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->



			<form action="adm_abstracts.php" method="post" class="f-wrap-1" enctype="multipart/form-data" onsubmit="return validar_doc();" >
			<fieldset>
	<input id="desti" name="desti" type="hidden" class="f-name" tabindex="1" value="Jornada" size="40"/>
<?if($accio=="M"){?>
<label for="autor">
 ID: <?=$row['id']?>
</label>
<?}?>
<label for="autor"> Autor:</label>
<input id="autor" name="autor" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? $row['autor'] :'' ?>" size="20" /><br />
<label for="centre"> Centre:</label>
<input id="centre" name="centre" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? $row['centre'] :'' ?>" size="40"/>
<label for="email"> Email:</label>
<input id="email" name="email" type="text"  class="text-input small-input"  class="required validate-email" value="<?=($accio=="M")? $row['email'] :'' ?>" size="75" maxlength="75"/><br />
<label for="titol"> Titol:</label>
<input id="titol" name="titol" type="text"  class="text-input medium-input"  class="required" value="<?=($accio=="M")? $row['titol'] :'' ?>" size="100" maxlength="255"/><br />
<?
$total_autors=0;
if($res2){
	while($row2=mysqli_fetch_assoc($res2)){
	$total_autors++; ?>
	<label for="autor<?=$row2['num_autor']?>"> Autor <?=$row2['num_autor']+1?>:</label>
	<input id="autor<?=$row2['num_autor']?>" name="autor<?=$row2['num_autor']?>" type="text" class="text-input small-input"  value="<?=($accio=="M")? $row2['autor'] :'' ?>" size="20" /><br />
	<label for="centre<?=$row2['num_autor']?>"> Centre <?=$row2['num_autor']+1?>:</label>
	<input id="centre<?=$row2['num_autor']?>" name="centre<?=$row2['num_autor']?>" type="text" class="text-input small-input"  value="<?=($accio=="M")? $row2['centre'] :'' ?>" size="40"/>
	<?}?>
<?}?>
	<input id="autors" name="autors" type="hidden" value="<?=$total_autors?>" />
	<br/>
	<label>
		<a href="javascript:afegirAutor();">Afegir autor</a></td>
	</label>
	<?if ($accio=='N'){?>
		<div id="nou_autor1"></div>
	<?}else{?>
		<input id="autors_OLD" type="hidden" name="autors_OLD" value="<?=$total_autors?>" />
		<div id="nou_autor<?=($total_autors+1)?>"></div>
	<?}?>


<br>
<label for="resum"> Resum:</label>
<?=($accio=="M")? '<a href="../upload/abstracts/'.$row['resum'].'">'.$row['resum'].'</a>' :'' ?>
<span><br><?=($accio=="M")? 'Canviar per:' :'' ?> <input name="fitxerdoc" id="fitxerdoc" size="20" type="file" /></span>
<br>
<!--<label for="comunicacio"> Prefer&egrave;ncia:-->
	<!--<input id="comunicacio" name="comunicacio" type="text" class="f-name" tabindex="24" value="<?=($accio=="M")? $row['comunicacio'] :'' ?>" size="15" maxlength="15"/><br /> -->
<!--	<div class="allrequired">
	<table>
		<tr><td>Oral </td><td><input name="comunicacio" value="oral" type="radio"
		<?if($row['comunicacio']=='oral') echo 'checked';?>/>
		</td></tr>
		<tr><td>Poster </td><td> <input name="comunicacio" value="poster" type="radio"
		<?if($row['comunicacio']=='poster') echo 'checked';?>/>
		</td></tr>
		<tr><td>Indiferent </td><td> <input name="comunicacio" value="indiferent" type="radio"
		<?if($row['comunicacio']=='indiferent') echo 'checked';?>/>
		</td></tr>


	</table>
	</div>
</label>
<label for="tematica"> Tematica:</label>
	<div class="allrequired">
	<table> <tr><td>
		Nefrologia cl&iacute;nica </td><td><input name="tematica" value="nefrologia" type="radio"
		<?if($row['tematica']=='nefrologia') echo 'checked';?>/>
		</td></tr>
		<tr><td>Di&agrave;lisi </td><td> <input name="tematica" value="dialisi" type="radio"
		<?if($row['tematica']=='dialisi') echo 'checked';?>/>
		</td></tr>
		<tr><td>Transplantament renal </td><td> <input name="tematica" value="transplantament" type="radio"
		<?if($row['tematica']=='transplantament') echo 'checked';?>/>
		</td></tr>

	</table>
	</div>
-->


		  <input name="accio" id="accio" type="hidden" value="<?=$accio?>" />
		  <input name="id" type="hidden" value="<?=$id?>" />
</fieldset>
	<br/><br/>
			<input class="button" value="Enviar" type="submit">
								</p>

							</fieldset>

							<div class="clear"></div><!-- End .clear -->

						</form>

					</div> <!-- End #tab2 -->

				</div> <!-- End .content-box-content -->

			</div> <!-- End .content-box -->



<? include('footer.php') ?>
