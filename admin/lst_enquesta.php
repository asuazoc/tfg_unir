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
			

<h2>Comunicacions</h2>
			<p id="page-intro">Resum Enquesta</p>
			
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

				<h1>Contingut</h1>
				<p>
				Q1 - Els continguts han cobert les seves expectatives<br>
				Q2 - Els temes s'han tractat amb la profunditat que esperava<br>
				</p>
				
				<h1>Metodologia i Organització</h1>
				<p>
				Q3 - La duració del congrés ha estat adequada al programa<br>
				Q4 - La metodologia s'ha adequat als continguts<br>
				Q5 - Les condicions ambientals (auditori, recursos utilitzats) han estat adequades per facilitar el congrés<br>
				</p>
				
				<h1>Taules rodones</h1>
				<p>
				Q6 - Els ponents dominaven la matèria<br>
				Q7 - Els continguts s'han exposat amb la deguda claredat<br>
				Q8 - Motiven i desperten interès als assistents<br>
				Q9 - Han complert l’horari establert<br>
				</p>
				
				<h1>Valoració i suggerències</h1>
				<p>
				Q10 - El congrés ha estat útil per a mi<br>
				Q11 - En general, l'organització ha estat apropiada<br>
				</p>
		
		
			<div class="notification information png_bg">
				<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
				<div>
<b>Recorda:</b> Pots utilitzar les capçaleres de la taula per ordenar les dades de forma ascendent o descendent.
</div>
			</div>
			

					<div style="display: block;" class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
							<!-- Page Head -->
							<h2>Congr&eacute;s</h2>
			<br>
			
<table id="pagerTable" cellspacing="1" class="tablesorter">
              <thead>
 <tr>
                  	<th>ID</th>
                  	<th>Q1</th>
       				<th>Q2</th>
       				<th>Q3</th>
       				<th>Q4</th>
       				<th>Q5</th>
       				<th>Q6</th>
       				<th>Q7</th>
       				<th>Q8</th>
       				<th>Q9</th>       				       				       				       		
       				<th>Q10</th>
       				<th>Q11</th>
       				<th>S</th>
                </tr>              
 
              </thead>
              <tbody>
               
   <?
$c=0;
$aSql='select * from enquesta';
foreach ($con->query($aSql) as $row){
$c++;
?>
                <tr>
                  	<td><?=$row['id']?></td>
                  	<td><?=$row['opcio_contingut']?></td>
       				<td><?=$row['opcio_temes']?></td>
       				<td><?=$row['opcio_duracio']?></td>
       				<td><?=$row['opcio_metodologia']?></td>
       				<td><?=$row['opcio_condicions']?></td>
       				<td><?=$row['opcio_ponents']?></td>
       				<td><?=$row['opcio_claretat']?></td>
       				<td><?=$row['opcio_motivacio']?></td>
       				<td><?=$row['opcio_horari']?></td>
       				<td><?=$row['opcio_util']?></td>
       				<td><?=$row['opcio_organizacio']?></td>
       				<td><?=$row['aportacions']?></td>
                </tr>
                <?
}
?>
              </tbody>
              <tbody>               
<?
$res='select avg(opcio_contingut) opcio_contingut, avg(opcio_temes) opcio_temes, avg(opcio_duracio) opcio_duracio, avg(opcio_metodologia) opcio_metodologia, avg(opcio_condicions) opcio_condicions, avg(opcio_ponents) opcio_ponents, avg(opcio_claretat) opcio_claretat, avg(opcio_motivacio) opcio_motivacio, avg(opcio_horari) opcio_horari, avg(opcio_util) opcio_util, avg(opcio_organizacio) opcio_organizacio from enquesta';
$result = $con->query($res);
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
                <tfoot>
                  	<th><?=$row['id']?></th>
                  	<th><?=$row['opcio_contingut']?></th>
       				<th><?=$row['opcio_temes']?></th>
       				<th><?=$row['opcio_duracio']?></th>
       				<th><?=$row['opcio_metodologia']?></th>
       				<th><?=$row['opcio_condicions']?></th>
       				<th><?=$row['opcio_ponents']?></th>
       				<th><?=$row['opcio_claretat']?></th>
       				<th><?=$row['opcio_motivacio']?></th>
       				<th><?=$row['opcio_horari']?></th>
       				<th><?=$row['opcio_util']?></th>
       				<th><?=$row['opcio_organizacio']?></th>
       				<th><?=$row['aportacions']?></th>
                </tfoot>
              </tbody>              
            </table>
            
            </table>
        </div> <!-- end tab1 -->
</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>

<? include('footer.php') ?>
