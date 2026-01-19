<?
include('../vars.inc.php');
include('control.php');
ini_set('display_errors', 0);

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

<h2>Notes Comunicació/Avaluadors</h2>
			<p id="page-intro">Notes agrupades per comunicació</p>

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<h3 style="cursor: s-resize;">Comunicacions</h3>

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Taula</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recorda:</b> Pots utilitzar les capçaleres de la taula per ordenar les dades de forma ascendent o descendent.
</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->
<?$sql="SELECT usuari FROM users where comunicacions_revisio!='' and revisio='S' ORDER BY usuari";
$result = $con->query($sql);
$rows = $result->rowCount();
?>
<table id="pagerTable" cellspacing="1" class="tablesorter">
   <thead>
   	<tr>
   		<th></th>
   		<th></th>
		<th></th>
		<th></th>
   		<th colspan="<?=$rows*2?>">users</th>
   		<th></th>
   	</tr>

	<tr>
		<th>Ordre</th>
	        <th>ID</th>
        	<th>Títol</th>
		<th>Tipus</th>
<?
foreach ($con->query($sql) as $row_usuaris){?>
        <th><?=$row_usuaris['usuari']?> nota</th>
        <th><?=$row_usuaris['usuari']?> recom.</th>
<?}?>
			<th>Nota final</th>
      </tr>
    </thead>
    <tbody>
<?
$c=0;
$sql="SELECT *
FROM
comunicacions as c where
c.removed='N'
group by c.id,
autor,
titol,
tematica,
comunicacio
order by c.id";
foreach ($con->query($sql) as $row){
$c++;?>
                <tr>
                  <th><?=$c?></th>
                  <td><?=$row['id']?></td>
                  <td><?=$row['titol']?></td>
		  <td><?=$comunicacio[$row['comunicacio']]['es']?></td>
							<?
							$sql_usuaris="SELECT usuari,comunicacions_revisio FROM users where comunicacions_revisio!='' and revisio='S' ORDER BY usuari";
							$notes=0;
							$sum_notes=0;
							foreach ($con->query($sql_usuaris) as $row_usuaris2){
							   $tComunicacionV = explode(',',$row_usuaris2['comunicacions_revisio']);
							   $aSql = "SELECT notatotal,recomanacio FROM comunicacions_nota WHERE id =".$row['id']." AND user='".$row_usuaris2['usuari']."' and revisio='S' ";
							   $result = $con->query($aSql);
							   if($row_nota = $result->fetch(PDO::FETCH_ASSOC)){?>
							         <td><?=number_format($row_nota['notatotal'], 2, ',', '')?></td>
								 <td><?=$comunicacio_eval[$row_nota['recomanacio']]?></td>
							         <?$notes++;
							         $sum_notes = $sum_notes + $row_nota['notatotal'];
								}else{?>
									<td>
										<?php if(in_array($row['id'], $tComunicacionV)){?>
											<span style="color:red">Pendiente evaluar</span>
										<?}?>
									</td>
									<td></td>
								<?
								}
							}?>
						<td><?=($notes!=0)?number_format(($sum_notes/$notes), 2, ',', ''):'';?></td>
                </tr>
<?
}?>
              </tbody>
            </table>
        </div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
