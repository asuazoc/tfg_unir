<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");



if ($_SERVER['REQUEST_METHOD']=="GET"){
	$accio=$_GET['accio'];
	$id=$_GET['id'];
    if ($accio=='E'){
    	    $sql="UPDATE comunicacions_sessio SET removed='S' where id=".$id;
   	    //$sql="delete from comunicacions where id=".$id;
	    mysqli_query($con,$sql);
	    header("Location: lst_comunicacions_session.php");
    }
}else{
	//agafem totes les variables
	$accio=$_POST['accio'];

	$id=$_POST['id'];
	$id_sessio=$_POST['id_sessio'];
	$id_intervencio=$_POST['id_intervencio'];
	$nom_contacte=str_replace("'","''",$_POST['nom_contacte']);
	$email_contacte=str_replace("'","''",$_POST['email_contacte']);
	$tel_contacte=str_replace("'","''",$_POST['tel_contacte']);
	$centre_treball_contacte=str_replace("'","''",$_POST['centre_treball_contacte']);
	$coordinador1=str_replace("'","''",$_POST['coordinador1']);
	$email1=str_replace("'","''",$_POST['email1']);
	$tel1=str_replace("'","''",$_POST['tel1']);
	$coordinador2=str_replace("'","''",$_POST['coordinador2']);
	$email2=str_replace("'","''",$_POST['email2']);
	$tel2=str_replace("'","''",$_POST['tel2']);

	$titol_sessio=str_replace("'","''",$_POST['titol_sessio']);
	$resum_objectius=str_replace("'","''",$_POST['resum_objectius']);
	$idioma=str_replace("'","''",$_POST['idioma']);
	$paraules_clau1=str_replace("'","''",$_POST['paraules_clau1']);
	$paraules_clau2=str_replace("'","''",$_POST['paraules_clau2']);

	$resum_intervencio=str_replace("'","''",$_POST['resum_intervencio']);
	$comentaristes=str_replace("'","''",$_POST['comentaristes']);
	$centres_treball_comentaristes=str_replace("'","''",$_POST['centres_treball_comentaristes']);
	$email_comentaristes=str_replace("'","''",$_POST['email_comentaristes']);

	$autors=str_replace("'","''",$_POST['autors']);
	$centres_treball=str_replace("'","''",$_POST['centres_treball']);
	$telefon=str_replace("'","''",$_POST['telefon']);
	$email=str_replace("'","''",$_POST['email']);
	$titol=str_replace("'","''",$_POST['titol']);

	$autorizacio_dni=str_replace("'","''",$_POST['autorizacio_dni']);
	$publicacio=str_replace("'","''",$_POST['publicacio']);

	$code=str_replace("'","''",$_POST['code']);
	$estat=str_replace("'","''",$_POST['estat']);

	if ($accio=='M'){
	   		$sql="UPDATE comunicacions_sessio SET
	   		id_sessio='$id_sessio',
			id_intervencio='$id_intervencio',
			nom_contacte='$nom_contacte',
			email_contacte='$email_contacte',
			tel_contacte='$tel_contacte',
			centre_treball_contacte='$centre_treball_contacte',
			autorizacio_dni='$autorizacio_dni',
			publicacio='$publicacio',
			coordinador1='$coordinador1',
			email1='$email1',
			tel1='$tel1',
			coordinador2='$coordinador2',
			email2='$email2',
			tel2='$tel2',
			titol_sessio='$titol_sessio',
			resum_objectius='$resum_objectius',
			idioma='$idioma',
			resum_intervencio='$resum_intervencio',
			comentaristes='$comentaristes',
			centres_treball_comentaristes='$centres_treball_comentaristes',
			email_comentaristes='$email_comentaristes',
			paraules_clau1='$paraules_clau1',
			paraules_clau2='$paraules_clau2',
			autors='$autors',
			centres_treball='$centres_treball',
			telefon='$telefon',
			email='$email',
			titol='$titol',
			estat='$estat',
			code='$code'
	   		where id=".$id;
	   		mysqli_query($con,$sql);
				//echo $sql;
		      header("Location: lst_comunicacions_session.php");
	}
 	else if ($accio=='N'){
	   		$sql="INSERT INTO comunicacions_sessio SET
	   		id=NULL ,
	   		id_sessio='$id_sessio',
			id_intervencio='$id_intervencio',
			nom_contacte='$nom_contacte',
			email_contacte='$email_contacte',
			tel_contacte='$tel_contacte',
			centre_treball_contacte='$centre_treball_contacte',
			autorizacio_dni='$autorizacio_dni',
			publicacio='$publicacio',
			coordinador1='$coordinador1',
			email1='$email1',
			tel1='$tel1',
			coordinador2='$coordinador2',
			email2='$email2',
			tel2='$tel2',
			titol_sessio='$titol_sessio',
			resum_objectius='$resum_objectius',
			idioma='$idioma',
			resum_intervencio='$resum_intervencio',
			comentaristes='$comentaristes',
			centres_treball_comentaristes='$centres_treball_comentaristes',
			email_comentaristes='$email_comentaristes',
			paraules_clau1='$paraules_clau1',
			paraules_clau2='$paraules_clau2',
			autors='$autors',
			centres_treball='$centres_treball',
			telefon='$telefon',
			email='$email',
			titol='$titol',
			estat='$estat',
			code='$code'";
				mysqli_query($con,$sql);
				header("Location: lst_comunicacions_session.php");
		}
	else{
		echo 'Accio inexistent';
		exit;
		}
	}

if (empty($accio)){
   header("Location: lst_comunicacions_session.php");
}

if($accio=="M"){
	$sql="select * from comunicacions_sessio where id=$id";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
}

include('header.php');
include('menu.php');
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

<h2>Intervenció-Sessió</h2>
			<p id="page-intro">Gesti&oacute; intervencions</p>


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



			<form action="adm_comunicacions_session.php" method="post" class="f-wrap-1" enctype="multipart/form-data" onsubmit="return validar_doc();" >
			<fieldset>
<?if($accio=="M"){?>
<label for="autor">
 ID: <?=$row['id']?>
</label>
<?}?>
<label for="id_sessio"> ID sessió:</label>
<input id="id_sessio" name="id_sessio" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['id_sessio']) :'' ?>" size="20" /><br />
<label for="id_intervencio"> ID intervenció:</label>
<input id="id_intervencio" name="id_intervencio" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['id_intervencio']) :'' ?>" size="20" /><br />
<label for="nom_contacte"> Nom contacte:</label>

<input id="nom_contacte" name="nom_contacte" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['nom_contacte']) :'' ?>" size="20" /><br />
<label for="email_contacte"> Email contacte(també és l'usuari):</label>
<input id="email_contacte" name="email_contacte" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['email_contacte']) :'' ?>" size="20" /><br />
<label for="code"> Contrasenya:</label>
<input id="code" name="code" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['code']) :'' ?>" size="20" /><br />

<label for="publicacio">Publicació (S/N):</label>
<input id="publicacio" name="publicacio" type="text"  class="text-input small-input"  class="" value="<?=($accio=="M")? htmlspecialchars($row['publicacio']) :'' ?>" size="20" /><br />

<label for="autorizacio_dni">DNI autorització:</label>
<input id="autorizacio_dni" name="autorizacio_dni" type="text"  class="text-input small-input"  class="" value="<?=($accio=="M")? htmlspecialchars($row['autorizacio_dni']) :'' ?>" size="20" /><br />


<label for="tel_contacte"> Tel contacte:</label>
<input id="tel_contacte" name="tel_contacte" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['tel_contacte']) :'' ?>" size="20" /><br />
<label for="centre_treball_contacte"> Centre treball contacte:</label>
<input id="centre_treball_contacte" name="centre_treball_contacte" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['centre_treball_contacte']) :'' ?>" /><br />

<label for="coordinador1"> Soci 1:</label>
<input id="coordinador1" name="coordinador1" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['coordinador1']) :'' ?>" size="40"/>
<label for="coordinador2"> Soci 2:</label>
<input id="coordinador2" name="coordinador2" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['coordinador2']) :'' ?>" size="40"/>
<label for="email1"> Email 1:</label>
<input id="email1" name="email1" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['email1']) :'' ?>" size="40"/>
<label for="email2"> Email 2:</label>
<input id="email2" name="email2" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['email2']) :'' ?>" size="40"/>
<label for="tel1"> Tel 1:</label>
<input id="tel1" name="tel1" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['tel1']) :'' ?>" size="40"/>
<label for="tel2"> Tel 2:</label>
<input id="tel2" name="tel2" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['tel2']) :'' ?>" size="40"/>
<label for="titol_sessio"> Títol sessió:</label>
<input id="titol_sessio" name="titol_sessio" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['titol_sessio']) :'' ?>" size="40"/>
<label for="resum_objectius"> Resum/Objectius:</label>
<textarea name="resum_objectius" id="resum_objectius" rows="7" cols="60"><?=($accio=="M")?trim(htmlspecialchars($row['resum_objectius'])):'' ?></textarea>

<span class="allrequired">
<label>Idioma:</label>
<div class="spacer"></div>
<label>Castellà</label>
<input name="idioma" value="ES" type="radio" class="radiobt"
<?if($row['idioma']=='ES'){?>
	checked="true"
<?}?>/>
<div class="spacer"></div>
<label>Anglès</label>
<input name="idioma" value="EN" type="radio" class="radiobt"
<?if($row['idioma']=='EN'){?>
	checked="true"
<?}?>/>
</span>
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
<label for="autors"> Autor/s intervencio:</label>
<input id="autors" name="autors" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['autors']) :'' ?>" size="40"/>
<label for="centres_treball"> Centre/s treball intervencio:</label>
<input id="centres_treball" name="centres_treball" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['centres_treball']) :'' ?>" size="40"/>
<label for="telefon"> Teléfon intervencio:</label>
<input id="telefon" name="telefon" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['telefon']) :'' ?>" size="40"/>
<label for="email"> Correu electrònic intervencio:</label>
<input id="email" name="email" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['email']) :'' ?>" size="40"/>
<label for="titol"> Títol intervencio:</label>
<input id="titol" name="titol" type="text"  class="text-input small-input"  class="required" value="<?=($accio=="M")? htmlspecialchars($row['titol']) :'' ?>" size="40"/>
<label for="resum_intervencio"> Resum:</label>
<textarea name="resum_intervencio" id="resum_intervencio" rows="7" cols="60"><?=($accio=="M")?trim(htmlspecialchars($row['resum_intervencio'])):'' ?></textarea>
<label for="comentaristes"> Comentaristes:</label>
<input id="comentaristes" name="comentaristes" type="text"  class="text-input small-input"  class="" value="<?=($accio=="M")? htmlspecialchars($row['comentaristes']) :'' ?>" size="40"/>
<label for="centres_treball_comentaristes">Centres treball Comentaristes:</label>
<input id="centres_treball_comentaristes" name="centres_treball_comentaristes" type="text"  class="text-input small-input"  class="" value="<?=($accio=="M")? htmlspecialchars($row['centres_treball_comentaristes']) :'' ?>"/>
<label for="email_comentaristes">Email Comentaristes:</label>
<input id="email_comentaristes" name="email_comentaristes" type="text"  class="text-input small-input"  class="" value="<?=($accio=="M")? htmlspecialchars($row['email_comentaristes']) :'' ?>"/>


<label for="estat"> Estat:</label>
<select name="estat" size="1">
	<option value="Pendet valoració" label="Pendet valoració" <?=($accio=="M" && $row['estat']=='Pendet valoració')? 'selected' :'' ?>>Pendet valoració</option>
	<option value="Acceptat" label="Acceptat" <?=($accio=="M" && $row['estat']=='Acceptat')? 'selected' :'' ?>>Acceptat</option>
	<option value="Descartat" label="Descartat" <?=($accio=="M" && $row['estat']=='Descartat')? 'selected' :'' ?>>Descartat</option>
</select>

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
