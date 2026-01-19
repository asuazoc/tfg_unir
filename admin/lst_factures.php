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

<h2>Llistado de facturas</h2>
			<div class="clear"></div> <!-- End .clear -->

			<div class="content-box"><!-- Start Content Box -->

				<div class="content-box-header">

					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Facturas</a></li> <!-- href must be unique and match the id of target div -->
					</ul>

					<div class="clear"></div>

				</div> <!-- End .content-box-header -->

				<div class="content-box-content">


			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recuerda:</b> Puedes utilizar las cabeceras de la tabla para ordenar los datos de forma ascendent o descendent.
</div>
			</div>


					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

							<!-- Page Head -->

<table id="pagerTable" cellspacing="1" class="tablesorter">
	<thead>
<tr>
<th>id</th>
<th>Data</th>
<th>Factura</th>
<th>Ordenant</th>
<th>NIF ordenant</th>
<th>cg1</th>
<th>cg2</th>
<th>nom</th>
<th>NIF</th>
<th>metodo</th>
<th>id pago</th>
<th>import base</th>
<th>import IVA</th>
<th>import total </th>
</tr>

</thead>
	<tfoot>
<tr>
<th>id</th>
<th>Data</th>
<th>Factura</th>
<th>Ordenant</th>
<th>NIF ordenant</th>
<th>cg1</th>
<th>cg2</th>
<th>nom</th>
<th>NIF</th>
<th>metodo</th>
<th>id pago</th>
<th>import base</th>
<th>import IVA</th>
<th>import total </th>
</tr>
	</tfoot>

<tbody>
<?
$res="SELECT * FROM inscripcions
where numero_factura<>0
and estat='OK'
ORDER BY numero_factura ";

foreach ($con->query($res) as $row){

$subtotal=(float)truncate($row['total']/1.21);
$total=(float)truncate($row['total']);
$pos = strrpos($total, '.');
if ($pos === false) { // note: three equal signs
   $total.='.00';
}
$iva=(($row['total'])-$subtotal);

?>



     <tr>
      <td><?='I'.$row['id'];?></td>
      <td><?=canvia_normal($row['data_factura']);?></td>
      <td><?=$codi_facturacio.'-'.$row['numero_factura'];?></td>
      <td><?=$row['nom_facturacio'];?></td>
       <td><?=$row['nif_facturacio'];?></td>
      <td><?=$row['cg1'];?></td>
      <td><?=$row['cg2'];?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['nif'];?></td>
      <td><?=$row['metode_pagament'];?></td>
      <td><?=$row['id_pagament'];?></td>
      <td><?=$subtotal?></td>
      <td><?=$iva?></td>
      <td><?=$row['total'];?></td>
     </tr>
<?
}
?>
<?/*FACTURES taller PRECONGRES*/
$res="SELECT * FROM tallerpre
where numero_factura<>0
and estat='OK'
ORDER BY numero_factura ";

foreach ($con->query($res) as $row){

$subtotal=(float)truncate($row['total']/1.21);
$total=(float)truncate($row['total']);
$pos = strrpos($total, '.');
if ($pos === false) { // note: three equal signs
   $total.='.00';
}
$iva=(($row['total'])-$subtotal);

?>
     <tr>
      <td><?='T'.$row['id'];?></td>
      <td><?=canvia_normal($row['data_factura']);?></td>
      <td><?=$codi_facturacio.'-'.$row['numero_factura'];?></td>
      <td><?=$row['nom_facturacio'];?></td>
       <td><?=$row['nif_facturacio'];?></td>
      <td><?=$row['cg1'];?></td>
      <td><?=$row['cg2'];?></td>
      <td><?=$row['nom'];?></td>
      <td><?=$row['nif'];?></td>
      <td><?=$row['metode_pagament'];?></td>
      <td><?=$row['id_pagament'];?></td>
      <td><?=$subtotal?></td>
      <td><?=$iva?></td>
      <td><?=$row['total'];?></td>
     </tr>
<?
}
?>

<?/*VISITA*/
$res="SELECT * FROM extres e
where numero_factura<>0
and estat='OK'
ORDER BY numero_factura ";

foreach ($con->query($res) as $row){

$subtotal=(float)truncate($row['total']/1.21);
$total=(float)truncate($row['total']);
$pos = strrpos($total, '.');
if ($pos === false) { // note: three equal signs
   $total.='.00';
}
$iva=(($row['total'])-$subtotal);

?>
     <tr>
      <td><?='V'.$row['id'];?></td>
      <td><?=canvia_normal($row['data_factura']);?></td>
      <td><?=$codi_facturacio.'-'.$row['numero_factura'];?></td>
      <td><?=$row['nom_facturacio'];?></td>
      <td><?=$row['nif_facturacio'];?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?=$row['metode_pagament'];?></td>
      <td><?=$row['id_pagament'];?></td>
      <td><?=$subtotal?></td>
      <td><?=$iva?></td>
      <td><?=$row['total'];?></td>
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
