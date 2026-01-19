<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
include('header.php');
include('menu.php');

function explode_trim($str, $delimiter = ',') {
    if ( is_string($delimiter) ) {
        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str));
        return explode($delimiter, $str);
    }
    return $str;
}


$user=$_SESSION['user'];

$tipus=array('investigacio'=>"Treball d'investigació clínica o experimental",
			  'cas'=>"Cas clínic");

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

<h2>Comunicaciones</h2>
			<p id="page-intro">Resumen comunicaciones</p>

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Evaluaciones</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Taula</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recuerde:</b> Puede utilizar las cabeceras de la tabla para ordenar de forma ascendente o descendente.
</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->

<table id="pagerTable" cellspacing="1" class="tablesorter">
    <thead>
 		<tr>
 		  <th>Ordre</th>
          <th>ID</th>
		  <th>Título</th>
		  <th>Preferencia</th>
		  <th>Opción 1</th>
		  <th>Opción 2</th>
		  <th>Autorización</th>
		  <th>Idioma</th>
		  <th>Nombre Eval</th>
		  <th>RESUMEN ESTRUCTURADO Y CLARO (0-1)</th>
		  <th>OBJETIVOS CLAROS Y FACTIBLES (0-1)</th>
		  <th>DISEÑO Y METODOLOGÍA ADECUADOS (0-2)</th>
		  <th>RESULTADOS PRESENTACIÓN ADECUADA (0-2)</th>
		  <th>RELEVANCIA DEL TEMA (0-2)</th>
		  <th>ORIGINALIDAD CONTRIBUCIÓN DEL TRABAJO (0-2)</th>
          <th>Acciones</th>
        </tr>
	</thead>
	<tbody>
	<?$c=0;
$aSql="SELECT
* FROM comunicacions as c where
c.removed='N'
order by c.id";
foreach ($con->query($aSql) as $row){

	$aSqlNotes="SELECT * FROM `comunicacions_nota` as cn where id=".$row['id']." and revisio='N' order by id";

	$notesRows = array();
	$n = 0;
	foreach ($con->query($aSqlNotes) as $notesRow){?>
	      <tr>
	          <th><?=$c?></th>
	          <th class="sub"><?=$row['id']?></th>
			  <td><?=$row['titol']?></td>
			  <td><?=$row['comunicacio']?></td>
			  <td><?=$paraules_clau[$row['paraules_clau1']]['es']?></td>
			  <td><?=$paraules_clau2[$row['paraules_clau2']]['es']?></td>
			  <td><?=$row['publicacio']?></td>
			  <td><?=$row['comunicacio_lang']?></td>
			  <td><?=$notesRow['user']?></td>
			  <td><?=$notesRow['nota1']?></td>
			  <td><?=$notesRow['nota2']?></td>
			  <td><?=$notesRow['nota3']?></td>
			  <td><?=$notesRow['nota4']?></td>
			  <td><?=$notesRow['nota5']?></td>
			  <td><?=$notesRow['nota6']?></td>
			  <td><a href="comunicacions_show_coordinador.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Ver</a></t
	      </tr>
	<?}
}?>
              </tbody>
            </table>
        </div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
