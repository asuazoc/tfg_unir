<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../vars.inc.php');
if($_GET['lang']=='en'){
	include('lang_en.php');
	$lang = 'en'; 
}else{
	include('lang_es.php');
	$lang = 'es';
}

$id = $_GET['id'];

$page = $_GET['page'];

$real_id  = base64_decode($id);

/*mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
$sql_count = "select count(*) num from enquesta where id = $real_id ";
/*$res = mysql_query($sql_count);
$row = mysql_fetch_assoc($res);*/
$result = $con->query($sql_count);
$row = $result->fetch(PDO::FETCH_ASSOC);
$c = $row['num'];

if ($c>0) {
	header("Location: ".base64_decode($page)."");
	exit();
}

function getOptions($name) {
	$text="";
	$text.="<table>";
	$text.="    <tr>";
	$text.="        <td>1</td>";
	$text.="        <td>2</td>";
	$text.="        <td>3</td>";
	$text.="        <td>4</td>";
	$text.="        <td>5</td>";
	$text.="    </tr>";
	$text.='    <tr class="required" >';
	$text.='        <td><input type="radio" name="'.$name.'" class="radiobt" value="1"></td>';
	$text.='        <td><input type="radio" name="'.$name.'" class="radiobt" value="2"></td>';
	$text.='        <td><input type="radio" name="'.$name.'" class="radiobt" value="3"></td>';
	$text.='        <td><input type="radio" name="'.$name.'" class="radiobt" value="4"></td>';
	$text.='        <td><input type="radio" name="'.$name.'" class="radiobt" value="5"></td>';
	$text.="    </tr>";
	$text.="</table>";
	return $text;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="generator" content="Bluefish 2.2.2" />
    <title>
      <?=TXT_ENQUESTA_TITOL?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Adrià" />
    <style type="text/css">
    body{
		font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;

		background: #E7EFE7;
    }

    p, h1, form, button{border:0; margin:0; padding:0;}
    .spacer{clear:both; height:1px;}

	/* Styling for message associated with a validation error. */
	form.cleanform  .errMsg {	
		color: #CC3333 !important;
		display: block;
		border: 1px solid #CC3333;
	}


    form.cleanform{
        margin:0 auto;
        width:800px;
        padding:14px;
        border:solid 2px #E2E2E2;
        background:#fff;
    }

    form.cleanform div.header {
        border-bottom:solid 1px #E2E2E2;
        font-size:11px;
        margin-bottom:20px;
    }

    form.cleanform div.header h1 {
        font-size:16px;
        font-weight:bold;
        margin-bottom:8px;
    }

    form.cleanform div.header .description {
        color: #666666;
    }

    form.cleanform p{
        font-size:11px;
        margin-bottom:20px;
    }

    form.cleanform label{
        display:block;
        text-align:right;
        width:140px;
        float:left;
    }

    form.cleanform label.full_lenght{
        display:block;
        text-align:right;
        width:auto;
    }


	.cp_button  {
	 width: 139px; 
	    height: 19px; color: #FFFFFF; font-size: 11px; font-weight: bold; 
	    background-color: #FFD7D7; border: 1px solid #dedede; border-top: 1px solid #eee;
 border-left: 1px solid #eee; font-family: &quot;Lucida Grande&quot;, Tahoma, Arial, Verdana, sans-serif; font-size: 90%; text-decoration: none; font-weight: bold; color: #565656; cursor: pointer; background-position: 6px; background-repeat: no-repeat; text-align: center; 
	    margin: 5px; 
	    padding: 5px;
    float: left;
}

    form.cleanform .small{
        color:#666666;
        display:block;
        font-size:11px;
        font-weight:normal;
        text-align:right;
        width:140px;
    }


    form.cleanform .check{
        font-size:12px;
        padding:4px 2px;
        margin:2px 0 20px 10px;
    }
    
    form.cleanform input{
        float:left;
        font-size:12px;
        padding:4px 2px;
        border:solid 1px #E2E2E2;
        width:200px;
        margin:2px 0 20px 10px;
    }
    
    form.cleanform input.radiobt{
        float:none;
        width:125px;
        margin:10px;
    }
		
	form.cleanform  legend
	{
      font-size:12px;
      font-weight:bold;
		padding: 2px 6px;
		border:none;
	}     
    
	form.cleanform  fieldset{
        border:solid 1px #E2E2E2;
        padding:10px;
    }

    form.cleanform select{
        float:left;
        font-size:12px;
        padding:4px 2px;
        border:solid 1px #E2E2E2;
        width:200px;
        margin:2px 0 20px 10px;
    }

    /* Button main class */
    form.cleanform input.button {
       
		width:125px;
		height:30px;

		color:#FFFFFF;
		font-size:11px;
		font-weight:bold;

		background-color:#f5f5f5;
		border:1px solid #dedede;
		border-top:1px solid #eee;
		border-left:1px solid #eee;

		font-family:"Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
		font-size:90%;
		text-decoration:none;
		font-weight:bold;
		color:#565656;
		cursor:pointer;

		background-position: 6px;
		background-repeat:no-repeat;
		text-align:center;

		margin: 5px;
		padding: 5px;
    }

    form.cleanform td {
    	text-align: center;
    	font-size:11px;
		font-weight:bold;
	}

	form.cleanform table {
    	margin-top: 25px;
    	margin-bottom: 15px;
	}
    </style>

    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/wforms.js"></script>
<?if($lang=='es'){?>
	<script type="text/javascript" src="js/localization-es.js"></script>
<?}?>

    <script type="text/javascript" language="javascript" charset="utf-8">


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
        var resum=$('aportacions');
        var words=word_count(resum);
               
        if(words>200){          
         	alert("El resumen puede tener como máximo 200 palabras. El actual te :"+words);                
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



    </script>
  </head>
  <body>
  
    <form id="f1" name="f1" class="cleanform" action="enquesta_result.php"
          method="post" enctype="multipart/form-data"
          onSubmit="return validar_doc(this)">
	
			<input type="hidden" name="sid"  id="sid" value="<?=$id?>">
			<input type="hidden" name="page"  id="page" value="<?=$page?>">

		  	<div class="header">
		  	<h1>
		      <?=TXT_ENQUESTA_TITOL?>
		  	</h1>  
		  		<p class="description"><?=TXT_ENQUESTA_EXPLICACIO?> </p>    

		  		<p class="description"><?=TXT_ENQUESTA_VALORACIO?> </p>  
		  	</div> 

	      	<fieldset>
					<legend><?=TXT_ENQUESTA_TITOL_CONTINGUT?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_CONTINGUT?>
					</label>
					<?= getOptions("opcio_contingut") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_TEMES?>
					</label>
					<?= getOptions("opcio_temes") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TITOL_METODOLOGIA?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_DURACIO?>
					</label>
					<?= getOptions("opcio_duracio") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_METODOLOGIA?>
					</label>
					<?= getOptions("opcio_metodologia") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_CONDICIONS?>
					</label>
					<?= getOptions("opcio_condicions") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TITOL_TAULES_RODONES?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_PONENETS?>
					</label>
					<?= getOptions("opcio_ponents") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_CLARETAT?>
					</label>
					<?= getOptions("opcio_claretat") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_MOTIVICIO?>
					</label>
					<?= getOptions("opcio_motivacio") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_HORARI?>
					</label>
					<?= getOptions("opcio_horari") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TITOL_VALORACIO?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_UTIL?>
					</label>
					<?= getOptions("opcio_util") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_OPCIO_ORGANITZACIO?>
					</label>
					<?= getOptions("opcio_organizacio") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_APORTACIONS?></legend> 
					<span class="info"> 
						<?=TXT_ENQUESTA_MAX?>
				    </span>
				    <br>
				    <span>
						<textarea name="aportacions" id="aportacions" rows="7"  style="width:90%"></textarea> 
					</span>
			</fieldset>
			
			<?/*
			<br/><hr/><br/>			<!-- ENQUESTA TALLERS -->	
			
				
			<div class="header">
		  	<h1>
		      <?=TXT_ENQUESTA_TALLERS_TITOL?>
		  	</h1>  
		  		<p class="description"><?=TXT_ENQUESTA_TALLERS_EXPLICACIO?> </p>    

		  		<p class="description"><?=TXT_ENQUESTA_TALLERS_VALORACIO?> </p>  
		  	</div> 

	      	<fieldset>
					<legend><?=TXT_ENQUESTA_TALLERS_TITOL_CONTINGUT?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_CONTINGUT?>
					</label>
					<?= getOptions("opcio_taller_contingut") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_TEMES?>
					</label>
					<?= getOptions("opcio_taller_temes") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TALLERS_TITOL_METODOLOGIA?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_DURACIO?>
					</label>
					<?= getOptions("opcio_taller_duracio") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_METODOLOGIA?>
					</label>
					<?= getOptions("opcio_taller_metodologia") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_CONDICIONS?>
					</label>
					<?= getOptions("opcio_taller_condicions") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TALLERS_TITOL_TAULES_RODONES?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_PONENETS?>
					</label>
					<?= getOptions("opcio_taller_ponents") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_CLARETAT?>
					</label>
					<?= getOptions("opcio_taller_claretat") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_MOTIVICIO?>
					</label>
					<?= getOptions("opcio_taller_motivacio") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_HORARI?>
					</label>
					<?= getOptions("opcio_taller_horari") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TALLERS_TITOL_VALORACIO?></legend> 
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_UTIL?>
					</label>
					<?= getOptions("opcio_taller_util") ?>
					<label class="full_lenght">
						<?=TXT_ENQUESTA_TALLERS_OPCIO_ORGANITZACIO?>
					</label>
					<?= getOptions("opcio_taller_organizacio") ?>
			</fieldset>

			<fieldset>
					<legend><?=TXT_ENQUESTA_TALLERS_APORTACIONS?></legend> 
					<span class="info"> 
						<?=TXT_ENQUESTA_MAX?>
				    </span>
				    <br>
				    <span>
						<textarea name="aportacions_taller" id="aportacions_taller" rows="7"  style="width:90%"></textarea> 
					</span>
			</fieldset>
			*/?>
			
			<fieldset>
				
			    <div id="botons" >
			            <input class="button" id="submit" type="submit" value="<?=TXT_ENQUESTA_ENVIAR?>" />
			    </div>
		    </fieldset>
    </form>

  </body>
</html>
