<?
include('vars.inc.php');
if($_GET['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else if($_GET['lang']=='ca'){
	include('lang_ca.php');
	$lang = 'ca';
}else{
	include('lang_es.php');
	$lang = 'es';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>

    <meta http-equiv="Content-Type"
          content="text/html; charset=utf-8" />
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <title><?=TXT_TITOL_FORM_COMUNICACIONS?> - <?=$titol_congres ?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="mystyle.css">

    <script type="text/javascript" src="js/wforms.js"></script>
	<?if($lang=='es'){?>
		<script type="text/javascript"
			src="js/localization-es.js">
		</script>
	<?}?>
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" charset="utf-8">

	/**
    * Returns the value of the selected radio button in the radio group, null if
    * none are selected, and false if the button group doesn't exist
    *
    * @param {radio Object} or {radio id} el
    * OR
    * @param {form Object} or {form id} el
    * @param {radio group name} radioGroup
    */
    function $RF(el, radioGroup) {
    	 if($(el)){
		    if($(el).type && $(el).type.toLowerCase() == 'radio') {
		        var radioGroup = $(el).name;
		        var el = $(el).form;
		    } else if ($(el).tagName.toLowerCase() != 'form') {
		        return false;
		    }

		    var checked = $(el).getInputs('radio', radioGroup).find(
		        function(re) {return re.checked;}
		    );
		    return (checked) ? $F(checked) : null;
		}
    }

    function validar_doc(){
        var resum=$('resum');
        var words=word_count(resum);

        if(words>250){
         	alert("El resumen puede tener como máximo 250 palabras. El actual te :"+words);
    			return false;
        }
        else{
        		return true;
        }
    }

 	function word_count(w){
		var y=w.value;
		var r = 0;
		a=y.replace(/\s/g,' ');
		a=a.split(' ');
		for (z=0; z<a.length; z++) {if (a[z].length > 0) r++;}
		return r;
    }

    function reportError(request) {$('ERROR').value = "Error"; }


    function validaPreForm(){
    	$('errorValidacio').hide();
    	if(($RF('protecciopa'))&&($RF('confidencialitat'))&&($RF('privacitat'))&&(($RF('conflictesyn')=='N')||(($RF('conflictesyn')=='S')&&($('conflictes').value!='')))){
    		if(($RF('protecciopa')=='3')||($RF('confidencialitat')=='3')||($RF('privacitat')=='3')){
    			$('errorValidacio').show();
    		}else{
    			$('div_etica').hide();
    			$('div_comunicacio').show();
    			document.body.scrollTop = document.documentElement.scrollTop = 0;
    		}
    	}else{
    		alert("<?=TXT_FALTAN_CAMPOS?>");
    	}
    }

    function onChangeConflictes(estat){
    	if(estat=='S'){
    		$('conflictes').show();
    	}else if(estat=='N'){
    		$('conflictes').hide();
    		$('conflictes').value="";
    	}
    }


    function clickTab(id){
        $('dadesa_tab').hide();
        $('dadesa_tab-button').removeClassName("active");
        $('dadesc_tab').hide();
        $('dadesc_tab-button').removeClassName("active");
        $('dadesr_tab').hide();
        $('dadesr_tab-button').removeClassName("active");
        $(id).show();
        $(id+'-button').addClassName("active");
    }

    function init() {
    	Event.observe('validaPreForm','click',validaPreForm);
    	onPublicacioChange();
        clickTab('dadesa_tab');
	}

    window.onload = init;


    </script>
  </head>
  <body>
	<form name="form" id="form" action="comunicacions_resultat.php" method="post" enctype="multipart/form-data" onsubmit="return validar_doc(this)" class="cleanform">
	  <input type="hidden" value="<?=$lang?>" name="lang" id="lang"/>

	  <div class="header">
	  	<?/*<h1>
	  	  <?php echo $titol_congres;?>
	  	</h1>
	  	<p class="description"><?php if($lang=='es'){
	  		echo $dates_congres_es;
	  	}else{
	  		echo $dates_congres_en;
	  	}?></p>*/?>
		<?php if($lang=='es'){?>
	  		<img style="width:100%" src="templates/cabecera_es.jpg"/>
	  	<?}else if($lang=='ca'){?>
			<img style="width:100%" src="templates/cabecera_ca.jpg"/>
		<?}else{?>
	  		<img style="width:100%" src="templates/cabecera_en.jpg"/>
	  	<?}?>
	  	<h2>
	      <?=TXT_TITOL_FORM_COMUNICACIONS?>
	  	</h2>
        <p class="description">
          <?=TXT_DATA_LIMIT_COMUNICACIONS?>
        </p>
      </div>
		<?$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
		//if(($data<=$data_final_comunicacions)||($_GET['openkey']=='fGtrGtSS')){
		if(1){
			if(isset($_GET['openkey'])){?>
				<input type="hidden" id="openkey" name="openkey" value="<?php echo $_GET['openkey'];?>"/>
			<?}?>

			<!-- FORMULARI ÈTICA I CONFLICTES -->
      		<div id="div_etica" style="display:block">
      			<h2><?=TXT_ACLARIMENT_ETICA_CONFLICTES?></h2>
      			<fieldset>
      				<legend><?=TXT_CONFLICTO_INTERESES?></legend>
 					<span>
	      				<?=TXT_CONFLICTO_INTERESES_DESC?>
	      			</span>
	      			<div class="spacer"></div>
					<span>
						<input name="conflictesyn" id="conflictesyn" value="N" type="radio" class="radiobt" onChange="javascript:onChangeConflictes('N');"/>&#160;<?=TXT_DECLARO_CONFLICTES_1?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="conflictesyn" id="conflictesyn" value="S" type="radio" class="radiobt" onChange="javascript:onChangeConflictes('S');"/>&#160;<?=TXT_DECLARO_CONFLICTES_2?>
					</span>
					<div class="spacer"></div>
					<textarea name="conflictes" id="conflictes" rows="6" type="text" style="display:none"></textarea>
					<div class="spacer"></div>
      			</fieldset>

      			<fieldset>
      				<legend><?=TXT_PROTECCIO_P_A?></legend>
 					<span>
	      				<?=TXT_PROTECCIO_P_A_DESC?>
	      			</span>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
					<span>
						<input name="protecciopa" id="protecciopa" value="1" type="radio" class="radiobt" />&#160;<?=TXT_PROTECCIO_P_A_1?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="protecciopa" id="protecciopa" value="2" type="radio" class="radiobt" />&#160;<?=TXT_PROTECCIO_P_A_2?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="protecciopa" id="protecciopa" value="3" type="radio" class="radiobt" />&#160;<?=TXT_PROTECCIO_P_A_3?>
					</span>
      			</fieldset>

      			<fieldset>
      				<legend><?=TXT_CONFIDENCIALITAT_DATOS?></legend>
 					<span>
	      				<?=TXT_CONFIDENCIALITAT_DATOS_DESC?>
	      			</span>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
					<span>
						<input name="confidencialitat" id="confidencialitat" value="1" type="radio" class="radiobt" />&#160;<?=TXT_CONFIDENCIALITAT_1?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="confidencialitat" id="confidencialitat" value="2" type="radio" class="radiobt" />&#160;<?=TXT_CONFIDENCIALITAT_2?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="confidencialitat" id="confidencialitat" value="3" type="radio" class="radiobt" />&#160;<?=TXT_CONFIDENCIALITAT_3?>
					</span>
      			</fieldset>

      			<fieldset>
      				<legend><?=TXT_PRIVACITAT?></legend>
 					<span>
	      				<?=TXT_PRIVACITAT_DESC?>
	      			</span>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
	      			<div class="spacer"></div>
					<span>
						<input name="privacitat" id="privacitat" value="1" type="radio" class="radiobt" />&#160;<?=TXT_PRIVACITAT_1?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="privacitat" id="privacitat" value="2" type="radio" class="radiobt" />&#160;<?=TXT_PRIVACITAT_2?>
					</span>
					<div class="spacer"></div>
					<span>
						<input name="privacitat" id="privacitat" value="3" type="radio" class="radiobt" />&#160;<?=TXT_PRIVACITAT_3?>
					</span>
      			</fieldset>

      			<div class="spacer"></div>
      			<div id="errorValidacio" style="color:red;display:none;font-size:120%;"><?=TXT_ERROR_VALIDACIO?></div>
      			<div class="spacer"></div>
				<input type="button" name="validaPreForm" id="validaPreForm" value="<?=TXT_VALIDA?>" class="button"/>
				<div class="spacer"></div>
				<div class="spacer"></div>
      		</div>


      		<!-- FORMULARI DE COMUNICACIONS -->
	  		<div id="div_comunicacio" style="display:none">
       			<div>

                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dadesa_tab-button" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesa_tab');"><?=TXT_DADES_PERSONALS_AUTOR_SIGNANT?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dadesc_tab-button" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="clickTab('dadesc_tab');"><?=TXT_DADES_COMUNICACIO?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dadesr_tab-button" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="clickTab('dadesr_tab');"><?=TXT_RESUM?></button>
                    </li>
                 </ul>

                <div id="dadesa_tab" class="tabs" style="display:none">
			      <fieldset>
				      <legend><?=TXT_DADES_PERSONALS_AUTOR_SIGNANT?></legend>
					<span style="color:red"><?= TXT_DADES_PERSONALS_AUTOR_SIGNANT_ACLARIMENT?></span>
				  	<div class="spacer"></div>

				      <span>
						<label><?=TXT_NOM_COGNOMS?>:</label>
						<input name="autor"
				            size="20"
				            class="required"
				            type="text" />
				      </span>


				      <div class="spacer"></div>
				      <span>
						<label><?=TXT_NIF?>:</label>
						<input name="nif"
				            size="20"
				            class="required"
				            type="text" />
				      </span>


				      <div class="spacer"></div>

				      <span>
				      	<label><?=TXT_CENTRE_TREBALL?>:</label>
				      	<input name="centre_principal"
				            size="40"
				            class="required"
				            type="text" />
					</span>

				      <div class="spacer"></div>
				      <span>
							<label><?=TXT_COMUNICACIO_CORREU_ELECTRONIC?>:</label>
				      	<input name="email"
				            id="email1"
				            size="50"
				            class="required validate-email"
				            type="text" />
				       </span>
						<div class="spacer"></div>
					<span>
					<label><?=TXT_COMUNICACIO_TEL_PARTICULAR?>:</label>
							<input name="telparticular" id="telparticular"  size="9"  class="required"          type="text" />
				      </span>

					<div class="spacer"></div>

					<!--PREFERENCIES LANG-->
					<span
						<?if($comunicacio_activa){
							echo 'class="allrequired"';
						}else{
							echo 'style="display:none"';
						}?>>
						<label><?=TXT_PREFERENCIA_LANG?>:</label>
					</span>
					<div class="spacer"></div>
					<span style="color:red"><?= TXT_RECORDATORI_LANG ?></span>
					<div class="spacer"></div>
					<span>
						<?foreach ($comunicacio_lang2 as $key => $value){?>

							<label><?=$comunicacio_lang2[$key][$lang]?></label>
							<input name="comunicacio_lang" value="<?=$key?>" type="radio" class="radiobt"/>

							<span class="info">
				         			<p><?=$comunicacio_tips[$key][$lang]?></p>
				         		</span>

							<div class="spacer"></div>
						<?}?>
					</span>
                    <div class="spacer"></div>
		            <div style="clear:both"></div>
                    	<br/>
                    	<ul style="display:inline-block;float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      		<li class="nav-item" role="presentation">
                    			<button class="nav-link active" id="dadesp_tab-next" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesc_tab');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                  <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/></svg></button>
                    		</li>
                    	</ul>

		            </fieldset>
                </div>
                <div id="dadesc_tab" class="tabs" style="display:none">
                    <fieldset>
				      <legend><?=TXT_DADES_COMUNICACIO?></legend>
				      	<span style="color:red"><?= TXT_RECORDATORI_AUTOR_SIGNANT ?></span>
					  	<div class="spacer"></div>
			      		<span>
						<label><?=TXT_AUTORES?>:</label>
						<input name="autors"
				            id="autors"
				            class="required"
				            type="text" />
				         <span class="info">
				         		<p><?=TXT_NORMES_AUTORS?></p>
				         </span>
				      </span>
				     <div class="spacer"></div>

				      <span>
				      	<label><?=TXT_CENTRE_TREBALL?>:</label>
				      	<input name="centre"
				            id="centre"
				            class="required"
				            type="text" />
					   <span class="info">
					   		<?=TXT_NORMES_CENTRE_TREBALL?>
					   </span>
				      </span>
					<div class="spacer"></div>
					<span>
					     <label><?=TXT_TITOL_COMUNICACIO?>:</label>
					      <input name="titol"
				            id="titol"
				            size="255"
				            class="required"
				            type="text" />
				          <span class="info">
				          		<?=TXT_NORMES_TITOL?>
				          </span>
				      </span>

					<div class="spacer"></div>

					<span>
					<?= TXT_COMUNICACIO_DISPONIBLE_TITLE ?>
					</span>
					<div class="spacer"></div>
			      		<span>
						<label><?= TXT_COMUNICACIO_YES?></label>
						 <input name="publicacio" id="publicacioS" value="S" type="radio" class="radiobt" onclick="onPublicacioChange()"/>
					</span>
					<div class="spacer"></div>
					<span>
						<label><?=TXT_COMUNICACIO_NO?></label>
						 <input name="publicacio" id="publicacioN" value="N" type="radio" class="radiobt" onclick="onPublicacioChange()"/>
					</span>

				        <div class="spacer"></div>

					<div id="alert_message" >
						<span>
							<span class="info_message">
					   			<b><?=TXT_AUTORIZO?></b>
							</span>
							<br/>
							<label>DNI:</label>
							<input name="autorizacio_dni"    id="autorizacio_dni"   size="255"	    type="text" />

						</span>
					</div>

				      <div class="spacer"></div>

				      <span>
					      <label><?=TXT_PARAULES_CLAU?>:</label>
			          </span>
					 <br>
					 <div class="spacer"></div>
					 <!--<span style="color:red"><?= TXT_RECORDATORI_PARAULES_CLAU ?></span>
				     <div class="spacer"></div>-->

			             <span>
					      <label><?=TXT_PRIMER_OPCIO?>:</label>

					      <select name="paraules_clau1" id="paraules_clau1"  class="required">
				               <option value="">---</option>
				          	<?foreach ($paraules_clau as $key => $value){?>
								<option value="<?=$key?>"><?=$paraules_clau[$key][$lang]?></option>
							<?}?>
						  </select>
			             </span>
				  <div class="spacer"></div>
				     <?/*<span>
					      <label><?=TXT_SEGONA_OPCIO?>:</label>
					       <select name="paraules_clau2" id="paraules_clau2">
				               <option value="">---</option>
				          	<?foreach ($paraules_clau2 as $key => $value){?>
								<option value="<?=$key?>"><?=$paraules_clau2[$key][$lang]?></option>
						<?}?>
						 </select>
				      </span>
				     <div class="spacer"></div>*/?>


						<!--TEMÀTIQUES-->
						<span
							<?if($tematica_activa){
								echo 'class="allrequired"';
							}else{
								echo 'style="display:none"';
							}?>>
							<label><?=TXT_TEMATICA?>:</label>
							<div class="spacer"></div>
							<?foreach ($tematica as $key => $value){?>
								<?=$tematica[$key]?><input name="tematica" value="<?=$key?>" type="radio"	<?if($row['tematica']==$key) echo 'checked';?> class="radiobt"/>
								<div class="spacer"></div>
							<?}?>
						</span>

						<!--PREFERENCIES-->
						<span
							<?if($comunicacio_activa){
								echo 'class="allrequired"';
							}else{
								echo 'style="display:none"';
							}?>>
							<label><?=TXT_PREFERENCIA?>:</label>
							<div class="spacer"></div>
							<span style="color:red"><?= TXT_RECORDATORI_PREFERENCIA ?></span>
							<div class="spacer"></div>
							<?foreach ($comunicacio as $key => $value){
								if($key!='rechazada'){?>
									<input name="comunicacio" value="<?=$key?>" type="radio" class="radiobt2"/>&#160;<b><?=$comunicacio[$key][$lang]?></b>
									<?=(isset($comunicacio_desc[$key][$lang]))?': '.$comunicacio_desc[$key][$lang]:''?>
									<div class="spacer"></div>
									<?if($key=='poster'){?>
										<div class="spacer"></div>
										<span style="color:red"><?= TXT_RECORDATORI_PREFERENCIA_2 ?></span>
										<div class="spacer"></div>
										<div><b><i><?= TXT_EXTRA_PREFERENCIES?></i></b></div>
										<div class="spacer"></div>
									<?}
								}
							}?>
						</span>
                        <div style="clear:both"></div>
	                    <br/>
	                    <ul style="float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		                    <li class="nav-item" role="presentation">
			                    <button class="nav-link active" id="dadesc_tab-prev" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesa_tab');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                                    <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/></svg>
                                </button>
		                    </li>
		                    <li>
			                    &#160;&#160;
		                    </li>
                      		<li class="nav-item" role="presentation">
			                    <button class="nav-link active" id="dadesc_tab-next" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesr_tab');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                                    <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/></svg>
                                </button>
		                    </li>
	                    </ul>

                	</fieldset>
                </div>

                <div id="dadesr_tab" class="tabs" style="display:none">
                    <fieldset>
				      <span>

				        <legend><?=TXT_RESUM?></legend>

							<span class="info">
							 <?=TXT_NORMES_RESUM?>
				      	</span>

						</span>

						<span>
							<textarea name="resum" id="resum" rows="7" cols="85"  class="required"></textarea>
						</span>
						<div style="clear:both"></div>
						<div><center><b><?=TXT_PUBLICACIO_RESUM?></b></center></div>
						<div style="clear:both"></div>
	                    <br/>
	                    <ul style="float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		                    <li class="nav-item" role="presentation">
			                    <button class="nav-link active" id="dadesr_tab-prev" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesc_tab');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
              <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/></svg></button>
		                    </li>
		                    <li>
			                    &#160;&#160;
		                    </li>
                      		<li class="nav-item" role="presentation">
                                <!--
<button class="nav-link active" id="submit" data-bs-toggle="pill" data-bs-target="#pills-home" type="submit" role="tab" aria-controls="pills-home" aria-selected="true"><?=TXT_COMUNICACIO_SEND?></button>
				-->
                            </li>
	                    </ul>

		            </fieldset>
				</div>
			</div>
		<?}else{?>
	       <div class="text">
	         <strong><?=TXT_NO_COMUNICACIONS?></strong>
	       </div>
       <?}?>
    </form>

 <script type="text/javascript">

	function onPublicacioChange(){
	    if($('publicacioS').checked){
			$('alert_message').show();
		 	$('autorizacio_dni').addClassName('required');
	    }
	    else{
			$('alert_message').hide();
			$('autorizacio_dni').removeClassName('required');
	    }

	}

	$('alert_message').hide();
 </script>

  </body>
</html>
