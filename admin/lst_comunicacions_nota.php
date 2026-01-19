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

<h2>Notas agrupadas de las Comunicaciones</h2>
			<p id="page-intro">Resumen de las notas de cada comunicación</p>

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Evaluadors</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Evaluaciones</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">

					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->

<table id="pagerTable" cellspacing="1" class="tablesorter">
              <thead>
 		<tr>
 		  	<th></th>
            <th>ID</th>
            <th>Autor</th>
		  	<th>Título</th>
		  	<th>Presentación</th>
		  	<th>Evaluaciones</th>
            <th>Suma</th>
       </tr>

              </thead>
              <tbody>

                <?
/*
'SELECT
c.id,
autor,
titol,
tematica,
comunicacio,
recomanacio,
count(*) evaluaciones,
sum(notatotal) media
FROM `comunicacions_nota` as cn,
comunicacions as c where
cn.id=c.id
group by c.id,
autor,
titol,
tematica,
comunicacio,
recomanacio
order by c.id'
*/

$c=0;
$aSql='SELECT
c.id,
autor,
titol,
comunicacio,
count(*) evaluaciones,
sum(notatotal) media
FROM `comunicacions_nota` as cn,
comunicacions as c where
cn.id_comunicacion=c.id
and cn.revisio="N"
group by c.id,
autor,
titol,
comunicacio
order by c.id';
foreach ($con->query($aSql) as $row){

$c++;

?>
                <tr>
                  <th><?=$c?></th>
                  <td><?=$row['id']?></td>
                  <td><?=$row['autor']?></td>
                  <td><?=$row['titol']?></td>
                  <td><?=$row['comunicacio']?></td>
                  <td><?=$row['evaluaciones']?></td>
                  <td><?=number_format($row['media'], 2, ',', '');?></td>

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
