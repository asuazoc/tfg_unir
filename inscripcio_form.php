<? include('vars.inc.php');

	include('lang_es.php');
	$lang = 'es';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="generator" content="Bluefish 2.2.2" />
    <title>
      <?=TXT_TITOL_FORM_INSCRIPCIO?> - <?=$titol_congres ?>
    </title>
    <meta http-equiv="content-type"
          content="text/html; charset=utf-8" />
    <meta name="author" content="Adrià" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="mystyle.css">

    <!-- calendar stylesheet -->

    <script type="text/javascript"
          src="js/prototype.js">
</script>
    <script type="text/javascript"
          src="js/wforms.js">
</script>
<script src="js/jscal2.js"
          type="text/javascript">
</script>
<?if($lang=='en'){?>
	<script src="js/lang/en.js"
	          type="text/javascript">
	</script>
<?}else{?>
	<script src="js/lang/es.js"
	          type="text/javascript">
	</script>
	<script type="text/javascript"
	          src="js/localization-es.js">
	</script>
<?}?>
    <link rel="stylesheet"
          type="text/css"
          href="css/calendar/jscal2.css" />
    <link rel="stylesheet"
          type="text/css"
          href="css/calendar/border-radius.css" />
    <link rel="stylesheet"
          type="text/css"
          href="css/calendar/steel/steel.css" />
    <script type="text/javascript"
          language="javascript"
          charset="utf-8">


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


    function calcula()
    {

    if($RF('id_inscripcio')=='ES'){
    	$('div_txt_estudiant').show();
    	$('fitxerdoc').addClassName('required');
    }else{
    	$('div_txt_estudiant').hide();
    	$('fitxerdoc').removeClassName('required');
    	$('fitxerdoc').value='';
    }

    if(($RF('id_inscripcio')=='D1')||($RF('id_inscripcio')=='D3')){
        $('div_sopar').hide();
        $('soparN').checked = true;
    }else{
        $('div_sopar').show();
    }
    $('div_sopar').hide(); //PER DESHABILITAR SOPAR


    $('ns_validat').value=1;
		$('submit').show();

    var acomp_sopar_value = $('acomp_soparN').value;
    if($('soparN').checked){
        $('acomp_soparN').checked = true;
    }else{
        if($('acomp_soparS').checked){
            acomp_sopar_value = $('acomp_soparS').value;
        }
    }

    $('submit').disabled=true;
    url = 'inscripcio_ajax.php';
    params ='hotel_habitacio=' + $RF('hotel_habitacio') + '&dataentrada=' + $('dataentrada').value + '&datasortida=' + $('datasortida').value + '&id_inscripcio=' + $RF('id_inscripcio') + '&acomp_sopar=' + acomp_sopar_value; /*$RF('acomp_sopar')*/

    //va a buscar el significat tambe

    new Ajax.Request(url,{method: 'post',parameters: params, onFailure: reportError , onComplete: actualitzaTotals});
        }


        function actualitzaTotals(request) {
           //info objecte: inscripcio,allotjament,nits,total

                 var inscripcio = request.responseText.evalJSON();

                 if((inscripcio.valid=='ERD')||(inscripcio.valid=='ER')){
                 	    alert(inscripcio.missatge);
						$('datasortida').value='';
						calcula();
   			    /*var checkboxes = $$("#f1 input[type=radio,name=hotel_habitacio]");

			      checkboxes.each(function(box){
				box.checked = false;
			      });

                            calcula();*/

                 }else{

		                 $('label_inscripcio').value=inscripcio.inscripcio;
		                 $('label_preu_allotjament').value=inscripcio.allotjament;
		                 $('label_nits').value=inscripcio.nits;
		                 $('label_preu_total').value=inscripcio.total;
		                 $('submit').disabled=false;
		           }
        }


        function reportError(request) {
                alert("Error al portar la definició");
        }


        function comprovaTabs(){
                if ( !$('inscripcio').visible() &&  !$('allotjament').visible()  ) {
                        $('botons').hide();
                        $('nobotons').show();

                }
                else {
                        $('botons').show();
                        $('nobotons').hide();
                }
        }

	function activaRestriccioAlimenticia(){
		if($RF('restriccio_alimenticia_si')=='Si'){
                        $('restriccio_alimenticia_quina').show();

                }
                else {
                        $('restriccio_alimenticia_quina').hide();
                }
        }


    function valida(){
    	if(confirm("<?=TXT_RECORDATORI_TARGETA?>")){
  			return true;
  		}else{
  			return false;
  		}
    }

    function clickTab(id){
        $('dadesp_tab').hide();
        $('dadesp_tab-button').removeClassName("active");
        $('dadesf_tab').hide();
        $('dadesf_tab-button').removeClassName("active");
        $('inscripcio_tab').hide();
        $('inscripcio_tab-button').removeClassName("active");
        $(id).show();
        $(id+'-button').addClassName("active");
    }

	 function init() {
				calcula();
		        clickTab('dadesp_tab');
	  }
	 window.onload = init;

    </script>
  </head>
  <body>
    <form id="f1"
          name="f1"
          class="cleanform"
          action="inscripcio_resultat.php"
          method="post"
          enctype="multipart/form-data"
          onSubmit="return valida(this)">

	<input type="hidden" value="<?=$lang?>" name="lang" id="lang"/>
  <div class="header">
  	<img style="width:100%" src="templates/cabecera_es.jpg"/>
		<h2>
      <?=TXT_TITOL_FORM_INSCRIPCIO?>
  	</h2>
  	<p class="description">
        <?php echo $dates_congres[$lang];?>
    </p>
  </div>
  <div <?$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
        if($data>$data_final_inscripcions){
             echo ' style="display:none" ';
        }?>>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dadesp_tab-button" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesp_tab');"><?=TXT_DADES_PERSONALS?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="dadesf_tab-button" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="clickTab('dadesf_tab');"><?=TXT_DADES_FACTURACIO?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inscripcio_tab-button" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="clickTab('inscripcio_tab');"><?=TXT_QUOTES_INSCRIPCIO?></button>
        </li>
    </ul>


    <div id="dadesp_tab" class="tabs" style="display:none">
      <fieldset id="wf_ParticipantInform-sessur">
			<legend><?=TXT_DADES_PERSONALS?></legend>

			<input name="categoria" id="categoria" type="hidden" value="A" /></span>
			<div class="spacer"></div>
			<table>
			<tr>

				<td>
					<label for="nom">
						<span class="reqMark">*</span><?=TXT_NOM?>
					</label>
	   	     			<input id="nom" name="nom" value="" size="" class="required" type="text" />
				</td>
				<td>
					<span>
						<label for="nif"><span class="reqMark">*</span><?=TXT_NIF?></label>
		         	<input id= "nif" name="nif" value="" size="" type="text" class="required" />
		         </span>
				</td>
        	</tr>
			<tr>
				<td>
					<label for="cg1">
							<span class="reqMark">*</span><?=TXT_CG1?>
						</label>
					<input id="cg1" name="cg1" value="" size="" class="required" type="text" />
        			</td>
				<td>
					<label for="cg2">
						<span class="reqMark">*</span><?=TXT_CG2?>
					</label>
	   	     			<input id="cg2" name="cg2" value="" size="" class="required" type="text" />
				</td>

        		</tr>

				<tr>
					<td>
					<span>
						<label for="email2"><span class="reqMark">*</span><?=TXT_CORREU_ELECTRONIC?></label>
						<input id="email2" name="email2" value="" size="" class="required validate-email" type="text" />
					</span>
	        		</td><td></td>
        		</tr>
        		<tr>
				<td>
        		<span>
	        		<label for="adresa"><?=TXT_ADRECA?></label>
	        		<input id="adresa" name="adresa" value="" size="" type="text" />
	        	</span>
        		</td>

			<td>
	        	<span>
					<label for="localitat">
						<span class= "reqMark">*</span><?=TXT_LOCALITAT?>
					</label>
					<input id="localitat" name="localitat" value="" size="" class="required" type="text" />
				</span>
				</td>
        		</tr>
				<tr>
				<td>
				<span>
					<label for="cp"><?=TXT_CP?></label>
					<input id="cp" name="cp" value="" size="" type="text" />
				</span>
        		</td><td>
            <span>
         		<label for="provincia"><?=TXT_PROVINCIA?></label>
         		<input id="provincia" name="provincia" value="" size="" type="text" />
            </span>
				</td>
        		</tr>
				<tr>
				<td>
				<span>
					<label for="telparticular"><?=TXT_TEL_PARTICULAR?></label>
					<input id="telparticular" name="telparticular" value="" size="" type="text" />
            </span>
        		</td><td>
            <span>
         		<label for="teltreball"><?=TXT_TEL_TREBALL?></label>
         		<input id="teltreball" name="teltreball" value="" size="" type="text" />
            </span>
				</td>
        		</tr>
				<tr>
				<td>
				<span>
					<label for="lloctreball"><span class="reqMark">*</span><?=TXT_LLOC_TREBALL?></label>
					<input id="lloctreball" name="lloctreball" value="" size="" class="required" type="text" />
				</span>
				</td>
        		</tr>

			</table>
      <!--</fieldset>
      <fieldset>-->
        <legend><?=TXT_DADES_CONTACTE_EMAIL?></legend>
        <span><label for="email"><?=TXT_CORREU_ELECTRONIC?>
        <span class="small"><?=TXT_ACLARIMENT_CORREU?></span></label>
        <input id="email" name="email" value="" size="" class="required validate-email" type="text" />
        <span class="reqMark">*</span></span>
      <!--</fieldset>-->

        <div style="clear:both"></div>
	    <br/>
	    <ul style="display:inline-block;float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      		<li class="nav-item" role="presentation">
			    <button class="nav-link active" id="dadesp_tab-next" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesf_tab');">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                      <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                    </svg>
                </button>
		    </li>
	    </ul>
     </fieldset>
    </div>

    <div id="dadesf_tab" class="tabs" style="display:none">
      <fieldset>
        <legend><?=TXT_DADES_FACTURACIO?></legend>
        <table>
				<tr>
					<td>
			        <span>
							<label for="nom_facturacio"><?=TXT_RAO_SOCIAL?>
								<span class="small"><?=TXT_ACLARIMENT_RAO_SOCIAL?></span>
							</label>
							<input id="nom_facturacio" name="nom_facturacio" value="" size="" type="text" class="required" />
			        </span>
					</td>
					<td>
						<span>
							<label for="nif_facturacio"><?=TXT_NIF?></label>
			         	<input id= "nif_facturacio" name="nif_facturacio" value="" size="" type="text" class="required" />
			         </span>
					</td>
			  </tr>
			  <tr>
					<td>
			        <span>
			        	<label for="adresa_facturacio"><?=TXT_ADRECA?></label>
			        	<input id="adresa_facturacio" name="adresa_facturacio" value="" size="" type="text" class="required" />
			        </span>
			      </td>
			      <td>
			      	<span>
	        				<label for="localitat_facturacio"><?=TXT_LOCALITAT?></label>
	        				<input id="localitat_facturacio" name="localitat_facturacio" value="" size="" type="text" class="required" />
	        			</span>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td>
			        <span>
			        	<label for="cp_facturacio"><?=TXT_CP?></label>
			        	<input id="cp_facturacio" name="cp_facturacio" value="" size="" type="text" class="required" />
			        </span>
			      </td>
			      <td>
			        <span>
			        	<label for="provincia_facturacio"><?=TXT_PROVINCIA?></label>
			        	<input id="provincia_facturacio" name="provincia_facturacio" value="" size="" type="text" class="required" />
			        </span>
			      </td>
				</tr>
				<tr>
					<td>
			        <span>
			        	<label for="tel_facturacio"><?=TXT_TEL?></label>
			        	<input id="tel_facturacio" name="tel_facturacio" value="" size="" class="validate-integer" type="text" />
			        </span>
			      </td>
			      <td>
			        <span>
			        	<label for="atencio_facturacio"><?=TXT_ATENCION_FACTURA?></label>
			        	<input id="atencio_facturacio" name="atencio_facturacio" value="" size="" type="text" />
			        </span>
			      </td>
			   </tr>
			</table>
          <div style="clear:both"></div>
        <br/>
        <ul style="float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
	            <button class="nav-link active" id="dadesf_tab-prev" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesp_tab');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                      <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
                    </svg>
                </button>
            </li>
            <li>
	            &#160;&#160;
            </li>
      		<li class="nav-item" role="presentation">
	            <button class="nav-link active" id="dadesf_tab-next" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('inscripcio_tab');">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                      <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                    </svg>
                </button>
            </li>
        </ul>
     </fieldset>
   </div>

    <div id="inscripcio_tab" class="tabs" style="display:none">
      <div id="inscripcio">
        <fieldset>
          <legend><?=TXT_QUOTES_INSCRIPCIO?></legend>
          <div>
            <table class="required preus">
              <tr>
                <td>
                  <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                </td>
                <td>
                  <label>&nbsp;<?=TXT_PREU_1?></label>
                </td>
                <td>
                  <label>&nbsp;<?=TXT_PREU_2?></label>
                </td>
                <td></td>
              </tr>

              <?
		foreach ($a_inscripcio as $key => $value){?>
              <tr>
                <td>
                  <label><?=$a_inscripcio[$key][$lang]?>
                  </label>
                </td>
                <td>
                  <label><?=$inscripcio[$key][1]?>
                   €</label>
                </td>
                <td>
                  <label><?=$inscripcio[$key][2]?>
                   €</label>
                </td>
                <td>
                  &nbsp;&nbsp;&nbsp;<input type="radio"
                      name="id_inscripcio"
                      value="<?=$key?>"
                      id="id_inscripcio"
                      onclick="calcula()"
                      />
                </td>
              </tr>
							<?if($key=='D3'){
	                echo "<tr><td colspan=\"4\">".TXT_ACLARIMENT_DIES."</td></tr>";
	            }
              }?>
            </table>
            <div class="spacer"></div><br/>
				<div>
					<b><?=TXT_ACLARIMENT_INSCRIPCIO?></b>
				</div>

            <br/>
				<div id="div_txt_estudiant" style="display:none">
			      	<b><?=TXT_ADJUNT_ESTUDIANTE?>:</b>
			      	<br/>
			      	<input name="fitxerdoc"
			            id="fitxerdoc"
			            size="20"
			            type="file" />
				</div>
				<input type="hidden" name="ns_validat" id="ns_validat" value="1"/>
				</fieldset>
      </div>

      <div id="allotjament" style="display:block">
        <fieldset>
          <legend><?=TXT_PREU_ALLOTJAMENT?></legend>
          <div>
          <div <?$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
                             if($data>$data_final_allotjament){
                                  echo ' style="display:none" ';
                             }?>>
				<?foreach ($a_hotel as $key => $value){
					if($key!='HS' && $key!='HMC' && $key!='HMA'){?>
		                        <span>
			            <H4 style="text-decoration: underline"><?=$a_hotel[$key]?></H4>
			            </span>
			            <div class="spacer"></div>

			            <span>
			            <label for="hotel_habitacio"><?=TXT_HABITACIO_DUI?></label>
			            <?=number_format($allotjament[$key]['DUI'], 2, '.', '')?>€
			            <input value="<?=$key?>|DUI"
			                   id="hotel_habitacio"
			                   name="hotel_habitacio"
			                   type="radio"
			                   onclick="calcula()" class="check"/>
			            </span>

			            <div class="spacer"></div>

			  		        <span>
				            <label for="hotel_habitacio"><?=TXT_HABITACIO_DOB?></label>
				             <?=number_format($allotjament[$key]['DOB'], 2, '.', '')?>€

				             <input value="<?=$key?>|DOB"
				                   id="hotel_habitacio"
				                   name="hotel_habitacio"
				                   type="radio"
				                   onclick="calcula()" class="check"/>

				           </span>

			           	<div class="spacer"></div>

		           <?}
	        }?>

               <span><label for="dataentrada"><?=TXT_DATA_ENTRADA?> <span class="small"> <?=TXT_ACLARIMENT_DATA?></span></label>
            		<input id="dataentrada"
                   name="dataentrada"
                   value=""
                   size=""
                   type="text"
                   onchange="calcula()" />

									 &#160;&#160;&#160;&#160;&#160;&#160;

                   <label for="datasortida"><?=TXT_DATA_SORTIDA?></label>

                   <input id=
                   "datasortida"
                   name="datasortida"
                   value=""
                   size=""
                   type="text"
                   onchange="calcula()" />


            </span>





    		  </div>
			  <div style="clear:both"></div>
			<div class="text"><strong><?=TXT_ACLARIMENT_ALLOTJAMENT?></strong></div>

    		  <?if($data>$data_final_allotjament){?>
          <div class="text">
            <strong><?=TXT_NO_ALLOTJAMENT?></strong>
          </div>
          <?}?>
	      </fieldset>

      </div>

			<div id="div_sopar" style="display:none">
			<fieldset>
				<legend><?=TXT_SOPAR2?></legend>
				<b><?=TXT_VISITA_CENA_INFO?></b>
				<div>
				<span><label for="sopar"><?=TXT_SI?></label><input id="soparS" name="sopar" value="Si" size="" type="radio" onclick="calcula()"/></span>&#160;&#160;&#160;
				<span><label for="sopar"><?=TXT_NO?></label><input id="soparN" name="sopar" value="No" size="" checked="true" type="radio" onclick="calcula()"/></span>
				</div>
				<div class="spacer"></div>

				<div style="display:none">
				    <b><?=TXT_ACOMP_SOPAR?></b>
                    <div>
				        <span><label for="acomp_sopar"><?=TXT_SI?></label><input id="acomp_soparS" name="acomp_sopar" value="Si" size="" type="radio" onclick="calcula()"/></span>&#160;&#160;&#160;
				        <span><label for="acomp_sopar"><?=TXT_NO?></label><input id="acomp_soparN" name="acomp_sopar" value="No" size="" checked="true" type="radio" onclick="calcula()"/></span>
				    </div>
			    </div>
			</fieldset>
      </div>

	  <div id="restriccio" style="display:block">
			<fieldset>
				<legend><?=TXT_RESTRICCIO_ALIMENTICIA?></legend>
				<div>
				<span><label for="restriccio_alimenticia_si"><?=TXT_SI?></label><input id="restriccio_alimenticia_si" name="restriccio_alimenticia" value="Si" size="" type="radio" onclick="activaRestriccioAlimenticia()"/></span>
				&#160;&#160;&#160;
				<span><label for="restriccio_alimenticia_si"><?=TXT_NO?></label><input id="restriccio_alimenticia_no" name="restriccio_alimenticia" value="No" size="" checked="true" type="radio" onclick="activaRestriccioAlimenticia()"/></span>
				</div><br/>
				<div style="display:none" id="restriccio_alimenticia_quina">
					<span>
						<label for="restriccio_alimenticia_text"><?=TXT_QUINA?></label>
						<input id="restriccio_alimenticia_text" name="restriccio_alimenticia_text" value="" type="text" />
					</span>
	    	   </div>
		   </fieldset>

      <script type="text/javascript">
		//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { calcula();cal.hide(); },
          min: 20260319,
    	  max: 20260323
      });
      cal.manageFields("dataentrada", "dataentrada", "%d/%m/%Y");
      cal.manageFields("datasortida", "datasortida", "%d/%m/%Y");
      //]]>
      </script>

      <fieldset>
			<legend><?=TXT_TOTALS?></legend>
			<span>
			<label for="label_inscripcio"><?=TXT_INSCRIPCIO?> <span class="small"><?=TXT_EUROS?></span></label>
			<input id="label_inscripcio" name="label_inscripcio" value="" size="" type="text" readonly  />
			<span style="display:block">
				<label for="label_nits"><?=TXT_NITS?></label>
            	<input id="label_nits" name="label_nits" value="" size="" type="text" readonly />
            </span>
       	</span>
       	<br><br>
			<br><br>
			<br><br>
         <span>
	         	<span style="display:block">
	         		<label for="label_preu_allotjament"><?=TXT_ALLOTJAMENT?> <span class="small"><?=TXT_EUROS?></span></label>
					<input id="label_preu_allotjament" name="label_preu_allotjament" value="" size="" type="text" readonly />
				</span>
				<label for="label_preu_total"><?=TXT_PREU_TOTAL?> <span class="small"><?=TXT_EUROS?></span></label>
				<input id="label_preu_total" name="label_preu_total" value="" size="" type="text"  readonly />
      	</span>

        <div style="clear:both"></div>
        <br/>
        <ul style="float:right;" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
	            <button class="nav-link active" id="inscripcio_tab-prev" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="clickTab('dadesf_tab');">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                      <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
                    </svg>
                </button>
            </li>
            <li>
	            &#160;&#160;
            </li>
      		<li class="nav-item" role="presentation">
	            <button class="nav-link active" id="submit" data-bs-toggle="pill" data-bs-target="#pills-home" type="submit" role="tab" aria-controls="pills-home" aria-selected="true"><?=TXT_COMUNICACIO_SEND?></button>
            </li>
        </ul>
        </fieldset>
      </div>

      <fieldset>
        <legend><?=TXT_POLITICA_CANCELACIONS_TITOL?></legend>
        <div class="text">
          <?=TXT_POLITICA_CANCELACIONS?>
        </div>
      </fieldset>

      <br/>
		<fieldset>
        <div class="text">
          <input type="checkbox" id="lopd" name="lopd" value="S" class="required"/><?=TXT_PROTECCIO_DADES_NEW?>
          <br />
        </div>
      </fieldset>
      <p>
      <div id="botons" >
        		<input class="button"
             id="reset"
             type="reset"
             value="<?=TXT_NETEJA?>" />
      </div>
      <div class="button"
           style="display: none;"
           id="nobotons">
        <?=TXT_VALIDACIO_FORM?>
      </div>
      </p>
      <div class="spacer"></div>
      </div>
      <?if($data>$data_final_inscripcions){?>
       <div class="text">
         <strong><?=TXT_NO_INSCRIPCIONS?></strong>
       </div>
       <?}?>
    </form>
  </body>
</html>
