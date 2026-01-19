<?
include('../vars.inc.php');
include('control.php');

$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
include('header.php');
include('menu.php');

$estat_factura_noms=array();
$estat_factura_noms['N']='No';
$estat_factura_noms['P']='Pendent';
$estat_factura_noms['F']='Facturat';
?>
<script type="text/javascript">
	var limit=5;
	var offset=0;
	var total=0;
	function desar(e){
		$('#desar').attr("disabled", true);
		$('#carregant').show();
		$('#msg_ko').hide();
		$('#msg_ok').hide();

		$.ajax({
		  dataType: "json",
		  url: "desa_certificats.php",
		  data: $('#form_certificats').serialize(),
		  type: "POST",
		  success: function(data){
		  	if(data.error==0){
		  		$('#msg_ok').show();
		  	}else{
		  		$('#msg_ko').html("ERROR: "+data.txterror);
		  		$('#msg_ko').show();
		  	}
		  	$('#carregant').hide();
		  	$('#desar').attr("disabled", false);
		  }
		});
	}

	function enviarEnllac(e){
		$('#enviar').attr("disabled", true);
		$('#carregant').show();
		$('#msg_ko').hide();
		$('#msg_ok').hide();

		$.ajax({
		  dataType: "json",
		  url: "enviar_enllac_certificats.php?limit="+limit+"&offset="+offset,
		  data: $('#form_certificats').serialize(),
		  type: "POST",
		  success: function(data){
		  	if(data.error==0){
		  		//$('#msg_ok').show();
				if(data.total!=0){
					total = total+data.total;
					offset = offset+limit;
					$('#msg_enviament').html("Enviament en curs: Enviats "+total);
			  		$('#msg_enviament').show();
					enviarEnllac();
				}else{
					alert('Enviament finalitzat');
				  	$('#carregant').hide();
				  	$('#enviar').attr("disabled", false);
					$('#msg_enviament').html("Enviament finalitzat: Enviats "+total);
			  		$('#msg_enviament').show();
				}
		  	}else{
		  		$('#msg_ko').html("ERROR: "+data.txterror);
		  		$('#msg_ko').show();
			  	$('#carregant').hide();
			  	$('#enviar').attr("disabled", false);
		  	}
		  }
		});
	}


	function marcar(accio){
		$('.chbx_certificat').each(function(){
			if(accio=='tots'){
				$('#'+this.id).attr('checked', true);
			}else{
				$('#'+this.id).attr('checked', false);
			}
		});
	}

	function onLoad(){
		$('#tots').click(function(){
			marcar(this.id);
		});

		$('#cap').click(function(){
			marcar(this.id);
		});

		$('#desar').click(function(){
			desar(this.id);
		});


		$('#enviar').click(function(){
			$('#msg_enviament').html("");
	  		$('#msg_enviament').hide();
			if(confirm('Segur que voleu enviar el missatge a tots els assistents marcats?')){
				offset=0;
				total=0;
				enviarEnllac(this.id);
			}
		});
	}

	$(document).ready(onLoad);
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

<h2>Certificados de asitencia</h2>

	<div class="clear"></div> <!-- End .clear -->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3 style="cursor: s-resize;"></h3>

			<ul class="content-box-tabs">
				<li><a href="#tab1" class="default-tab current">Asistentes</a></li> <!-- href must be unique and match the id of target div -->
			</ul>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">


	<div class="notification information png_bg"  style="display:none">
		<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
		<div>
			<b>Recuerda:</b> Puedes utilizar las cabeceras de la tabla para ordenar los datos de forma ascendent o descendent.
		</div>
	</div>
	<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
		<div align="left">
			<a id="tots">marcar todos</a>&#160;/&#160;<a id="cap">desmarcar todos</a>
			&#160;<input type="button" id="desar" name="desar" value="guardar cambios"/>
			&#160;<input type="button" id="enviar" name="enviar" value="enviar usuario/passwd/enlace"/>
			&#160;&#160;<img id="carregant" src="images/carregant.gif" style="display:none"/>
			<span id="msg_enviament" style="display:none;color:green"></span>
			<span id="msg_ok" style="display:none;color:green">Canvis desats correctament</span>
			<span id="msg_ko" style="display:none;color:red"></span>
		</div>
		<form id="form_certificats" name="form_certificats" method="post">
		<table id="pagerTable" cellspacing="1" class="tablesorter">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Cat.</th>
					<th>id_inscripcio</th>
					<th>1r apellido</th>
					<th>2o apellido</th>
					<th>Nombre</th>
					<th>Email</th>
					<th>Centro de trabajo</th>
					<th>Ordenante</th>
					<th>Estado</th>
					<th>Estado factura</th>
					<th>Certificado asist.</th>
				</tr>
			</thead>
			<tbody>

		<?$count=1;
		//$res=mysqli_query($con,"SELECT * FROM inscripcions where ( incidencia='' OR incidencia = 'N' OR incidencia IS NULL ) AND estat='OK' AND estat_factura='F' ORDER BY cg1, cg2, nom");
		$res=mysqli_query($con,"SELECT * FROM inscripcions ORDER BY cg1, cg2, nom");
		while($row=mysqli_fetch_assoc($res)){?>
			<tr>
				<td><?=$count;?></td>
				<td><?=$row['id'];?></td>
				<td><?=$row['categoria'];?></td>
				<td><?=$row['id_inscripcio'];?></td>
				<td><?=$row['cg1'];?></td>
				<td><?=$row['cg2'];?></td>
				<td><?=$row['nom'];?></td>
				<td><?=$row['email'];?></td>
				<td><?=$row['lloctreball'];?></td>
				<td><?=$row['nom_facturacio'];?></td>
				<td><?=$row['estat'];?></td>
				<td><?=$row['estat_factura'];?></td>
				<td><input class="chbx_certificat" id="certificat_<?=$row['id'];?>" name="certificat_<?=$row['id'];?>" type="checkbox"
				<?if($row['certificat_assist']=='S'){?>
					checked="true"
				<?}?>
				value="S"/></td>
			</tr>
			<?$count++;
		}?>
			</tbody>
		</table>
		</form>
	</div> <!-- end tab1 -->

</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
