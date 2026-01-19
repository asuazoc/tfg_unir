<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
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

<h2>Listado Reservas</h2>

			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Reservas</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">



					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->




<?

foreach ($a_hotel as $hotel => $desc) {

?>


<table id="pagerTable" cellspacing="1" class="tablesorter">

			<thead>
				<tr>
				<th colspan="29">(<?= $hotel ?>) <?= $desc ?></th>
				</tr>
			</thead>
			<tbody>
			<tr>
	<th>Apellidos</th>
	<th>Nombre</th>
	<th>Hotel</th>
	<th>t.habitaci&oacute;n</th>
	<th>Fecha entrada</th>
	<th>Fecha salida</th>
	<th>Noches</th>
	<th>Importe hotel</th>
	<th>Importe hotel pagado</th>
</tr>

<?


$sql    = 'select
cg1,
cg2,
nom ,
hotel ,
dataentrada ,
datasortida,
nits,
total_allotjament ,
pagat_allotjament,
habitacio
from inscripcions where hotel=\''.$hotel.'\' and nits!=0 order by cg1, cg2,nom ';
foreach ($con->query($sql) as $row){
?>
<tr>
	<td><?=$row['cg1']?> <?=$row['cg2']?></td>
	<td><?=$row['nom']?></td>
	<td><?=$row['hotel']?></td>
	<td><?=$row['habitacio']?></td>
	<td><?=canvia_normal($row['dataentrada'])?></td>
	<td><?=canvia_normal($row['datasortida'])?></td>
	<td><?=$row['nits']?></td>
	<td><?=$row['total_allotjament']?></td>
	<td><?=$row['pagat_allotjament']?></td>

</tr>
<?
}
?>

		</tbody>
		  </table>

<?
}
?>

</div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
<? include('footer.php') ?>
