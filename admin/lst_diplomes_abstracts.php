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
			<p id="page-intro">Diplomes Abstracts</p>
			
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
                  <th width="10%">id</th>
                  <th>Títol</th>
                  <th>Autor signant</th>
                  <th>Altres autors</th>
                </tr>
              </thead>
              <tbody>
                
                <?
$c=0;
$aSql='select id,desti,autor,centre,categoria,direccio,poblacio,provincia,cp,tel,fax,email,titol,resum,comunicacio,tema,paraules_clau from abstracts  order by id';
	foreach ($con->query($aSql) as $row){
	/*foreach($row as $k => $v) {
		$row[$k]=utf8_decode( $v );
	}*/

	$c++;
	?>
		        <tr>
		          <td ><?=$c;?></td>
		          <td><?=$row['titol'];?></td>
		          <td><?=$row['autor'];?></td>
			  <?$res2=mysqli_query($con,'select autor from autors_abstract where id='.$row['id'].'');?>				
		          <td>
				<?if($res2){
					while($row2=mysqli_fetch_assoc($res2)){
						echo $row2['autor'].'<br>';
					}
				}?>
			  </td>
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
