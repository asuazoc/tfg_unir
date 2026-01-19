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
			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Comunicaciones</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Evaluaciones</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg" style="display:none">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
						RESUMEN ESTRUCTURADO Y CLARO (RE)<br />
						OBJETIVOS CLAROS Y FACTIBLES (OC)<br />
						DISEÑO Y METODOLOGÍA ADECUADOS (DM)<br />
						RESULTADOS PRESENTACIÓN ADECUADA (RP)<br />
						RELEVANCIA DEL TEMA (RT)<br />
						ORIGINALIDAD CONTRIBUCIÓN DEL TRABAJO (OC)<br />

				</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->

<table id="pagerTable" cellspacing="1" class="tablesorter">
              <thead>
 		<tr>

                  <th>ID</th>
                  <th>Título</th>
                  <th>NOTA</th>
                  <th>Preferencia Autor</th>
		  		  <th>Recomendación</th>
                  <th>Revisi&oacute;n</th>
                </tr>

              </thead>
              <tbody>

                <?
$c=0;
$es_revisio = false;
if($_SESSION['comunicacions_revisio']!=''){
	$es_revisio = true;
	$comunicacions_revisio = $_SESSION['comunicacions_revisio'];
	$sql_revisio = " and id IN (".$comunicacions_revisio.") ";
}
$aSqlComunicacions = 'select * from comunicacions where removed="N" '.$sql_revisio.' order by id';
foreach ($con->query($aSqlComunicacions) as $row){

//check if is visible
//if($row['revisio']=='S'){
//if($es_revisio){
/*if($_SESSION['revisio']=='S'){
	$comunicacions=explode_trim($_SESSION['comunicacions_revisio'],",");
	$ValRevisio = 'S';
}else{
	$comunicacions=explode_trim($_SESSION['comunicacions_visibles'],",");
	$ValRevisio = 'N';
}
if (!in_array("*", $comunicacions)){
	if (!in_array($row['id'], $comunicacions)){
		continue;
	}
}*/


$c++;
$sql_nota ="select * from comunicacions_nota where id_comunicacion='".$row['id']."' and user='".$user."'";
$result = $con->query($sql_nota);
$row_nota = $result->fetch(PDO::FETCH_ASSOC);

$notatotal= ($row_nota['notatotal']=='') ? '-' : $row_nota['notatotal'];

?>
                <tr>
                  <th class="sub"><?=$row['id']?></th>
                  <td><?=$row['titol']?></td>
		  		  <td><?=$notatotal?></td>
                  <td><?=$comunicacio[$row['comunicacio']]['es']?></td>
		  		  <td><?=$comunicacio_eval[$row_nota['recomanacio']]?></td>
                  <td>
                  	<?if($row['revisio']=='S'){?>
                  		<a href="comunicacions_revisio_show.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>">Ver</a>
                  	<?}else{?>
                  		<a href="comunicacions_show.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>">Ver</a>
                  	<?}?>
                  </td>
                </tr>
                <?
}
?>
              </tbody>
            </table>
        </div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
