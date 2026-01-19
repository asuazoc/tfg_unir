<?
//revisem que tingui permis per accedir-hi
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD']=="GET"){
	$accio=$_GET['accio'];
	$id=$_GET['id'];
	if ($accio=='E'){
		$sql="delete from inscripcions where id=".$id;
		mysqli_query($con,$sql);
		header("Location: lst_inscripcions.php");
	}
//si es post
}else{
	//agafem totes les variables
	$id=$_POST['id'];
	$accio=str_replace("'","''",$_POST['accio']);
	$tractament=str_replace("'","''",$_POST['tractament']);
	$categoria=str_replace("'","''",$_POST['categoria']);
	$cg1=(str_replace("'","''",$_POST['cg1']));
	$cg2=(str_replace("'","''",$_POST['cg2']));
	$nom=(str_replace("'","''",$_POST['nom']));
	$nif=str_replace("'","''",$_POST['nif']);
	$adresa=(str_replace("'","''",$_POST['adresa']));
	$localitat=(str_replace("'","''",$_POST['localitat']));
	$cp=utf8_decode(str_replace("'","''",$_POST['cp']));
	$provincia=(str_replace("'","''",$_POST['provincia']));
	$telparticular=str_replace("'","''",$_POST['telparticular']);
	$lloctreball=(str_replace("'","''",$_POST['lloctreball']));
	$teltreball=str_replace("'","''",$_POST['teltreball']);
	$email=str_replace("'","''",$_POST['email']);
	$email2=str_replace("'","''",$_POST['email2']);
	$id_inscripcio=str_replace("'","''",$_POST['id_inscripcio']);
	$sopar=str_replace("'","''",$_POST['sopar']);
	$restriccio_alimenticia=$_POST['restriccio_alimenticia'];
	$restriccio_alimenticia_text=str_replace("'","''",$_POST['restriccio_alimenticia_text']);

	$acomp_sopar=str_replace("'","''",$_POST['acomp_sopar']);
	$total_sopar=str_replace("'","''",$_POST['total_sopar']);
	$pagat_sopar=str_replace("'","''",$_POST['pagat_sopar']);

	$hotel=str_replace("'","''",$_POST['hotel']);
	$habitacio=str_replace("'","''",$_POST['habitacio']);
	$dataentrada=canvia_mysql($_POST['dataentrada']);
	$datasortida=canvia_mysql($_POST['datasortida']);
	$nits=$_POST['nits'];
	$total_allotjament=str_replace("'","''",$_POST['total_allotjament']);
	$pagat_allotjament=str_replace("'","''",$_POST['pagat_allotjament']);
	$total_inscripcio=str_replace("'","''",$_POST['total_inscripcio']);
	$pagat_inscripcio=str_replace("'","''",$_POST['pagat_inscripcio']);
	$estat=str_replace("'","''",$_POST['estat']);
	$estat_factura=str_replace("'","''",$_POST['estat_factura']);
	$total=str_replace("'","''",$_POST['total']);
	$total_pagat=str_replace("'","''",$_POST['total_pagat']);
	$nom_facturacio=(str_replace("'","''",$_POST['nom_facturacio']));
	$nif_facturacio=(str_replace("'","''",$_POST['nif_facturacio']));
	$adresa_facturacio=(str_replace("'","''",$_POST['adresa_facturacio']));
	$localitat_facturacio=(str_replace("'","''",$_POST['localitat_facturacio']));
	$cp_facturacio=(str_replace("'","''",$_POST['cp_facturacio']));
	$atencio_facturacio=(str_replace("'","''",$_POST['atencio_facturacio']));
	$provincia_facturacio=(str_replace("'","''",$_POST['provincia_facturacio']));
	$tel_facturacio=(str_replace("'","''",$_POST['tel_facturacio']));
	$metode_pagament=str_replace("'","''",$_POST['metode_pagament']);

	$usuari=str_replace("'","''",$_POST['usuari']);
	$password=str_replace("'","''",$_POST['password']);

	//obs
	$obs=str_replace("'","''",$_POST['obs']);
	$incidencia=str_replace("'","''",$_POST['incidencia']);

	//netejem la variable si esta amb blanc
	$numero_factura=$_POST['numero_factura'];
	if (empty($numero_factura)){
		$numero_factura=0;
	}
	$data_factura=$_POST['data_factura'];
	//mirem quin numero de factura toca
	if ($nif_facturacio!="" && $estat_factura=="F" && $numero_factura==0 && $total==$total_pagat && $total_pagat!=0){
		$numero_factura=cercaNumFacturaValid();
		$data_factura=date('Y-m-d');
	}
	if ($accio=='M'){
		$sql="UPDATE inscripcions SET tractament='$tractament' , categoria='$categoria' , cg1='$cg1' ,cg2='$cg2' , nom='$nom' , nif='$nif', email2='$email2', adresa='$adresa' , localitat='$localitat' , cp='$cp' , provincia='$provincia' ,
		telparticular='$telparticular' , lloctreball='$lloctreball' , teltreball='$teltreball' , email='$email' , id_inscripcio='$id_inscripcio' , recepcio='$recepcio', sopar='$sopar', restriccio_alimenticia = '$restriccio_alimenticia',
		restriccio_alimenticia_text = '$restriccio_alimenticia_text', acomp_sopar='$acomp_sopar' , hotel='$hotel' , habitacio='$habitacio' , dataentrada='$dataentrada' , datasortida='$datasortida' , nits='$nits' , 
		total_allotjament='$total_allotjament' , pagat_allotjament='$pagat_allotjament' , total_inscripcio='$total_inscripcio' , pagat_inscripcio='$pagat_inscripcio' , estat='$estat', total='$total', total_pagat='$total_pagat',
		nom_facturacio='$nom_facturacio',nif_facturacio='$nif_facturacio',adresa_facturacio='$adresa_facturacio', localitat_facturacio='$localitat_facturacio', cp_facturacio='$cp_facturacio', atencio_facturacio='$atencio_facturacio',
		total_sopar='$total_sopar',pagat_sopar='$pagat_sopar', usuari= '$usuari' , password= '$password', provincia_facturacio='$provincia_facturacio', tel_facturacio='$tel_facturacio', estat_factura='$estat_factura',
		numero_factura='$numero_factura',data_factura='$data_factura',obs='$obs',incidencia='$incidencia',metode_pagament='$metode_pagament' where id=".$id;
    mysqli_query($con,$sql);
	  header("Location: lst_inscripcions.php");
	} else if ($accio=='N'){
		$sql="INSERT INTO inscripcions SET id=NULL ,tractament='$tractament' , categoria='$categoria' , cg1='$cg1' ,cg2='$cg2'  , nom='$nom' , nif='$nif', email2='$email2', adresa='$adresa' , localitat='$localitat' , cp='$cp' , provincia='$provincia' ,
		telparticular='$telparticular' , lloctreball='$lloctreball' , teltreball='$teltreball' , email='$email' , id_inscripcio='$id_inscripcio',sopar='$sopar', restriccio_alimenticia = '$restriccio_alimenticia', restriccio_alimenticia_text = '$restriccio_alimenticia_text',
		acomp_sopar='$acomp_sopar', hotel='$hotel' , habitacio='$habitacio' , dataentrada='$dataentrada' , datasortida='$datasortida' , nits='$nits' , total_allotjament='$total_allotjament' , pagat_allotjament='$pagat_allotjament' , total_inscripcio='$total_inscripcio' ,
		pagat_inscripcio='$pagat_inscripcio', estat='$estat',total='$total' ,total_pagat='$total_pagat',nom_facturacio='$nom_facturacio',nif_facturacio='$nif_facturacio',adresa_facturacio='$adresa_facturacio', localitat_facturacio='$localitat_facturacio',
		cp_facturacio='$cp_facturacio',atencio_facturacio='$atencio_facturacio', total_sopar='$total_sopar',pagat_sopar='$pagat_sopar',usuari= '$usuari' , password= '$password', provincia_facturacio='$provincia_facturacio',tel_facturacio='$tel_facturacio',
		estat_factura='$estat_factura',numero_factura='$numero_factura',data_factura='$data_factura',obs='$obs',incidencia='$incidencia',metode_pagament='$metode_pagament'";
		mysqli_query($con,$sql);
		header("Location: lst_inscripcions.php");
	}else{
		echo 'Accio inxeistent';
		exit;
	}
}

if (empty($accio)){
   header("Location: lst_inscripcions.php");
}


if($accio=="M"){
	$sql="select * from inscripcions where id=".$id;
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	foreach ($row as $key => $value) {
		if (!(mb_detect_encoding($value, 'UTF-8', true))) {
        $value = utf8_encode($value);
    }
		$row[$key] = $value;
	}
}

include('header.php');
include('menu.php');
?>

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

<h2>Inscripcions</h2>
			<p id="page-intro">Llistat d'inscripcions</p>


			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Content box</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Assistent</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">

			<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

			<form action="adm_inscripcions.php" method="post" class="f-wrap-1" onsubmit="return validarForm();" >

<label for="tractament">Tractament:</label>
<select name="tractament" id="tractament">
 	<option value="Dr."  <?=($accio=="M" && $row['tractament']=='Dr.')? 'selected' :'' ?> >Dr.</option>
        <option value="Dra." <?=($accio=="M" && $row['tractament']=='Dra.')? 'selected' :'' ?> >Dra.</option>
        <option value="Sr."  <?=($accio=="M" && $row['tractament']=='Sr.')? 'selected' :'' ?> >Sr.</option>
        <option value="Sra." <?=($accio=="M" && $row['tractament']=='Sra.')? 'selected' :'' ?> >Sra.</option>
 </select>

<label for="id_condicio">Categoria:</label>
            <select name="categoria" id="categoria">
		<option value="A" <?=($accio=="M" && $row['categoria']=='A')? 'selected' :'' ?> >Assistent</option>
		<option value="P" <?=($accio=="M" && $row['categoria']=='P')? 'selected' :'' ?>>Ponent Jornada</option>
		<option value="M" <?=($accio=="M" && $row['categoria']=='M')? 'selected' :'' ?>>Moderador Jornada</option>
		<option value="C" <?=($accio=="M" && $row['categoria']=='C')? 'selected' :'' ?>>Membre del Comité Cientific/organitzador</option>
		<option value="E" <?=($accio=="M" && $row['categoria']=='E')? 'selected' :'' ?>>Expositor Casa Comercial</option>
            </select>
<label for="cognoms">Cognoms:</label>
<input id="cg1" name="cg1" type="text" class="text-input small-input" tabindex="3" value="<?=($accio=="M")? htmlspecialchars($row['cg1']) :'' ?>" size="50" maxlength="50"/><br />
<input id="cg2" name="cg2" type="text" class="text-input small-input" tabindex="3" value="<?=($accio=="M")? htmlspecialchars($row['cg2']) :'' ?>" size="50" maxlength="50"/><br />

<label for="nom">Nom:</label>
<input id="nom" name="nom" type="text" class="text-input small-input" tabindex="4" value="<?=($accio=="M")? htmlspecialchars($row['nom']) :'' ?>" size="20" maxlength="20"/><br />

<label for="email2">E-mail:</label>
<input id="email2" name="email2" type="text" class="text-input small-input" tabindex="13" value="<?=($accio=="M")? $row['email2'] :'' ?>" size="60" maxlength="60"/><br />

<label for="nif">NIF:</label>
<input id="nif" name="nif" type="text" class="text-input small-input" tabindex="4" value="<?=($accio=="M")? htmlspecialchars($row['nif']) :'' ?>" size="20" maxlength="20"/><br />

<label for="adresa">Adreça:</label>
<textarea id="adresa" name="adresa" class="f-comments" rows="6" cols="20" tabindex="5">
<?=($accio=="M")? $row['adresa'] :'' ?>
</textarea>

<label for="localitat">Localitat:</label>
<input id="localitat" name="localitat" type="text" class="text-input medium-input" tabindex="6" value="<?=($accio=="M")? htmlspecialchars($row['localitat']) :'' ?>" size="20" maxlength="20"/><br />

<label for="cp">Codi Postal:</label>
<input id="cp" name="cp" type="text" class="text-input small-input" tabindex="7" value="<?=($accio=="M")? $row['cp'] :'' ?>" size="10" maxlength="10"/><br />

<label for="provincia">Provincia:</label>
<input id="provincia" name="provincia" type="text" class="text-input small-input" tabindex="8" value="<?=($accio=="M")? htmlspecialchars($row['provincia']) :'' ?>" size="10" maxlength="10"/><br />

<label for="telparticular"><b> Telefon Particular:</b></label>
<input id="telparticular" name="telparticular" type="text" class="text-input small-input" tabindex="9" value="<?=($accio=="M")? $row['telparticular'] :'' ?>" size="9" maxlength="9"/><br />

<label for="lloctreball">Lloc treball:</label>
<input id="lloctreball" name="lloctreball" type="text" class="text-input small-input" tabindex="10" value="<?=($accio=="M")? htmlspecialchars($row['lloctreball']) :'' ?>" size="50" maxlength="50"/><br />

<label for="teltreball">Telefon treball:</label>
<input id="teltreball" name="teltreball" type="text" class="text-input small-input" tabindex="11" value="<?=($accio=="M")? $row['teltreball'] :'' ?>" size="9" maxlength="9"/><br />

<label for="fax">Fax:</label>
<input id="fax" name="fax" type="text" class="text-input small-input" tabindex="12" value="<?=($accio=="M")? $row['fax'] :'' ?>" size="9" maxlength="9"/><br />

<label for="email">E-mail(Contacte):</label>
<input id="email" name="email" type="text" class="text-input small-input" tabindex="13" value="<?=($accio=="M")? $row['email'] :'' ?>" size="60" maxlength="60"/><br />

<span <?=($accio=="M")? 'style="display:block"' :'style="display:none"'?>>
	<label for="usuari">Usuari:</label>
	<input id="usuari" name="usuari" type="text" class="text-input small-input" value="<?=($accio=="M")? $row['usuari'] :'' ?>" size="11" maxlength="11"/>

	<label for="password">Password:</label>
	<input id="password" name="password" type="text" class="text-input small-input" value="<?=($accio=="M")? $row['password'] :'' ?>" size="11" maxlength="11"/>
</span>

<label for="id_inscripcio"><b> Inscripcio:</b></label>
<select name="id_inscripcio" id="id_inscripcio">
<option value="" > ...</option>
<?
foreach ($a_inscripcio as $key => $value){
?>
 	<option value="<?=$key?>"  <?=($accio=="M" && $row['id_inscripcio']==$key)? 'selected' :'' ?> ><?=$a_inscripcio[$key]['es']?></option>
<?
 }
?>
</select>

<label for="hotel">Hotel:</label>
<select name="hotel">
<option value="" > ...</option>
<?foreach ($a_hotel as $key => $value){?>
 	<option value="<?=$key?>"  <?=($accio=="M" && $row['hotel']==$key)? 'selected' :'' ?> ><?=$value?></option>
<? }?>
</select>

<label for="habitacio">Habitacio:</label>
<select name="habitacio">
	<option value="" > ...</option>
	<option value="DOB" <?=($accio=="M" && $row['habitacio']=='DOB')? 'selected' :'' ?>> Doble </option>
	<option value="DUI" <?=($accio=="M" && $row['habitacio']=='DUI')? 'selected' :'' ?>> Doble d'us individual </option>
</select>
<label for="dataentrada">Data entrada:</label>
<input id="dataentrada" name="dataentrada" type="text" class="text-input small-input" tabindex="22" value="<?=($accio=="M")? canvia_normal($row['dataentrada']) :'' ?>" size="11" maxlength="11"/><br />

<label for="datasortida">Data sortida:</label>
<input id="datasortida" name="datasortida" type="text" class="text-input small-input" tabindex="23" value="<?=($accio=="M")? canvia_normal($row['datasortida']) :'' ?>" size="11" maxlength="11"/><br />

<label for="nits">Nits:</label>
<input id="nits" name="nits" type="text" class="text-input small-input" tabindex="24" value="<?=($accio=="M")? $row['nits'] :'0' ?>" size="3" maxlength="3"/><br />

<label for="sopar">Recepción de bienvenida:</label>

<label for="sopar">Sopar:</label>

<select name="sopar">
	<option value="" > ...</option>
	<option value="Si" <?=($accio=="M" && $row['sopar']=='Si')? 'selected' :'' ?>>Si</option>
	<option value="No" <?=($accio=="M" && $row['sopar']=='No')? 'selected' :'' ?>>No</option>
</select>

<label>Restricció alimentícia:</label>
<select name="restriccio_alimenticia">
	<option value="" > ...</option>
	<option value="Si" <?=($accio=="M" && $row['restriccio_alimenticia']=='Si')? 'selected' :'' ?>>Si</option>
	<option value="No" <?=($accio=="M" && $row['restriccio_alimenticia']=='No')? 'selected' :'' ?>>No</option>
</select>

<label for="restriccio_alimenticia_text">Quina restricció alimentícia:</label>
<input id="restriccio_alimenticia_text" name="restriccio_alimenticia_text" value="<?=$row['restriccio_alimenticia_text']?>" type="text"  class="text-input medium-input" />

<label for="acomp_sopar">Acompanyant sopar:</label>
<select name="acomp_sopar">
	<option value="" > ...</option>
	<option value="Si" <?=($accio=="M" && $row['acomp_sopar']=='Si')? 'selected' :'' ?>>Si</option>
	<option value="No" <?=($accio=="M" && $row['acomp_sopar']=='No')? 'selected' :'' ?>>No</option>
</select>

<label for="total_sopar">Total Sopar:</label>
<input id="total_sopar" name="total_sopar" type="text" class="text-input small-input" tabindex="25" value="<?=($accio=="M")? $row['total_sopar'] :'' ?>" size="6" maxlength="6"/><br />

<label for="pagat_sopar">Pagat Sopar:</label>
<input id="pagat_sopar" name="pagat_sopar" type="text" class="text-input small-input" tabindex="26" value="<?=($accio=="M")? $row['pagat_sopar'] :'' ?>" size="11" maxlength="11"/><br />


<label for="total_allotjament">Total Allotjament:</label>
<input id="total_allotjament" name="total_allotjament" type="text" class="text-input small-input" tabindex="25" value="<?=($accio=="M")? $row['total_allotjament'] :'' ?>" size="6" maxlength="6"/><br />

<label for="pagat_allotjament">Pagat Allotjament:</label>
<input id="pagat_allotjament" name="pagat_allotjament" type="text" class="text-input small-input" tabindex="26" value="<?=($accio=="M")? $row['pagat_allotjament'] :'' ?>" size="11" maxlength="11"/><br />

<label for="total_inscripcio">Total Inscripcio:</label>
<input id="total_inscripcio" name="total_inscripcio" type="text" class="text-input small-input" tabindex="27" value="<?=($accio=="M")? $row['total_inscripcio'] :'' ?>" size="6" maxlength="6"/><br />

<label for="pagat_inscripcio">Pagat Inscripcio:</label>
	<input id="pagat_inscripcio" name="pagat_inscripcio" type="text" class="text-input small-input" tabindex="28" value="<?=($accio=="M")? $row['pagat_inscripcio'] :'' ?>" size="6" maxlength="6"/><br />

<label for="metode_pagament">Metode Pagament:</label>
<select name="metode_pagament">
<option value="" > ...</option>
	<option value="trans" <?=($accio=="M" && $row['metode_pagament']=="trans")? 'selected' :'' ?>>Transferéncia</option>
	<option value="visa" <?=($accio=="M" && $row['metode_pagament']=="visa")? 'selected' :'' ?>>Visa</option>
</select>

<label for="estat">Estat:</label>
<select name="estat">
<option value="" > ...</option>
	<option value="FR" <?=($accio=="M" && $row['estat']=="FR")? 'selected' :'' ?>> Fax Rebut </option>
	<option value="NI" <?=($accio=="M" && $row['estat']=="NI")? 'selected' :'' ?>> Sense Inscripció</option>
	<option value="PP" <?=($accio=="M" && $row['estat']=="PP")? 'selected' :'' ?>> Pendent Pagament</option>
	<option value="OK" <?=($accio=="M" && $row['estat']=="OK")? 'selected' :'' ?>> Inscripció OK</option>
</select>


<label for="estat_factura">Facturació:</label>
<select name="estat_factura">
<option value="" > ...</option>
	<option value="N" <?=($accio=="M" && $row['estat_factura']=="N")? 'selected' :'' ?>> Sense Factura</option>
	<option value="P" <?=($accio=="M" && $row['estat_factura']=="P")? 'selected' :'' ?>> Pendent Factura </option>
	<option value="F" <?=($accio=="M" && $row['estat_factura']=="F")? 'selected' :'' ?>> Facturat</option>
</select>


<label for="incidencia">Incidencia:</label>
<select name="incidencia">
	<option value="" > ...</option>
	<option value="N" <?=($accio=="M" && $row['incidencia']=="N")? 'selected' :'' ?>> No</option>
	<option value="S" <?=($accio=="M" && $row['incidencia']=="S")? 'selected' :'' ?>> Si</option>
</select>

<label for="obs"><b> Observacions:</b></label>
<textarea id="obs" rows="2" cols="20"  name="obs">
<?=($accio=="M")? $row['obs'] :'' ?>
</textarea>



<label for="total"><b> Total:</b></label>
<input id="total" name="total" type="text" class="text-input small-input" tabindex="30" value="<?=($accio=="M")? $row['total'] :'0' ?>" size="11" maxlength="11"/><br />

<label for="total_pagat"><b> Total Pagat:</b></label>
<input id="total_pagat" name="total_pagat" type="text" class="text-input small-input" tabindex="31" value="<?=($accio=="M")? $row['total_pagat'] :'0' ?>" size="11" maxlength="11"/><br />
<hr>
<?
	if ($accio=="M") {
?>
	<label for="numero_factura"><b> Numero de factura:</b>
		<?= $row['numero_factura']?><br />
		<input type="hidden" name="numero_factura" value="<?= $row['numero_factura'] ?>" />
	</label>
	<label for="data_factura"><b> Data de la factura:</b>
		<?= canvia_normal($row['data_factura'])?>
		<input type="hidden" name="data_factura" value="<?= $row['data_factura'] ?>" />
		<br />
	</label>
<?
	}
?>

<label for="nom_facturacio">Nom Facturacio:</label>
<input id="nom_facturacio" name="nom_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? htmlspecialchars($row['nom_facturacio']) :'' ?>" size="75" maxlength="75"/><br />

<label for="nif_facturacio">Nif facturacio:</label>
<input id="nif_facturacio" name="nif_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? $row['nif_facturacio'] :'' ?>" size="75" maxlength="75"/><br />

<label for="adresa_facturacio">Adreça Facturacio:</label>
<input id="adresa_facturacio" name="adresa_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? htmlspecialchars($row['adresa_facturacio']) :'' ?>" size="75" maxlength="75"/><br />

<label for="localitat_facturacio">Poblacio facturacio:</label>
<input id="localitat_facturacio" name="localitat_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? $row['localitat_facturacio'] :'' ?>" size="75" maxlength="75"/><br />

<label for="cp_facturacio">Codi Postal facturacio:</label>
<input id="cp_facturacio" name="cp_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? $row['cp_facturacio'] :'0' ?>" size="75" maxlength="75"/><br />

<label for="atencio_facturacio">Atenció facturacio:</label>
<input id="atencio_facturacio" name="atencio_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? htmlspecialchars($row['atencio_facturacio']) :'0' ?>" size="75" maxlength="75"/><br />

<label for="provincia_facturacio">Provincia facturacio:</label>
<input id="provincia_facturacio" name="provincia_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? $row['provincia_facturacio'] :'0' ?>" size="75" maxlength="75"/><br />

<label for="tel_facturacio"> Tel facturacio:</label>
	<input id="tel_facturacio" name="tel_facturacio" type="text" class="text-input small-input" tabindex="32" value="<?=($accio=="M")? $row['tel_facturacio'] :'0' ?>" size="75" maxlength="75"/><br />
		  <input name="accio" type="hidden" value="<?=$accio?>" />
		  <input name="id" type="hidden" value="<?=$id?>" />

						<input class="button" value="Submit" type="submit">
								</p>

							</fieldset>

							<div class="clear"></div><!-- End .clear -->

						</form>

					</div> <!-- End #tab2 -->

				</div> <!-- End .content-box-content -->

			</div> <!-- End .content-box -->



<? include('footer.php') ?>
