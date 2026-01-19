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
		
<h2>Abstracts</h2>
			<p id="page-intro">Resum d'abstracts</p>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Abstracts</h3>
					
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
			
<table id="pagerTable" cellspacing="1" class="tablesorter">
              <thead>
 <tr>
                  <th>ID</th>
                  <th>Dest&iacute;</th>
                  <th>Autor</th>
                  <th>Titol</th>
                  <th>Privat</th>
                  <th>Avaluaci&oacute;</th>
                </tr>              
 
              </thead>
              <tbody>
               
                <?
$c=0;
$res= 'select id,desti,autor,centre,categoria,direccio,poblacio,provincia,cp,tel,fax,email,titol,resum,comunicacio,tema,paraules_clau from abstracts where desti ="Jornada" order by id';

foreach ($con->query($res) as $row){
$c++;
?>
                <tr>
                  <th class="sub"><?=$c;?></th>
                  <!--<td><?=utf8_decode($row['desti']);?></td>-->
                  <td><?=$row['desti']?></td>
                  <!--<td><?=utf8_decode($row['autor']);?> </td>-->
                  <td><?=$row['autor']?> </td>
                  <!--<td><?=utf8_decode($row['titol']);?></td>-->
                  <td><?=$row['titol']?></td>
                  <td><a href="abstracts_privat_show.php?accio=P&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Veure</a></td>
                  <!--<td><a href="../upload/<?=$row['resum']?>" target="_blank">Veure</a></td>-->
                  <td><a href="abstracts_show.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Veure</a></td>
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
