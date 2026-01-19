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
			<p id="page-intro">Resumen comunicaciones</p>
			
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3 style="cursor: s-resize;">Comunicaciones</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab current">Tabla</a></li> <!-- href must be unique and match the id of target div -->
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
		
			<div class="notification information png_bg">
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
                  <th>RE</th>
                  <th>OC</th>
                  <th>DM</th>
                  <th>RP</th>
                  <th>RT</th>
                  <th>OC</th>
                  <th>TOTAL</th>
                  <th>Preferencia Autor</th>
		  <th>Recomendación</th>
                  <th>Evaluaci&oacute;n</th>
                </tr>              
 
              </thead>
              <tbody>
               
                <?
$c=0;
$sql = 'select * from comunicacions where removed="N" order by id';
foreach ($con->query($sql) as $row){

//check if is visible
$comunicacions=explode_trim($_SESSION['comunicacions_visibles'],",");
if (!in_array("*", $comunicacions)){
	if (!in_array($row['id'], $comunicacions)){
		continue;
	}		
}


$c++;
$sql_nota ="select * from comunicacions_nota where id='".$row['id']."' and user='".$user."'";
$result = $con->query($sql_nota);
$row_nota = $result->fetch(PDO::FETCH_ASSOC);

$nota1= ($row_nota['nota1']=='') ? '-' : $row_nota['nota1'];
$nota2= ($row_nota['nota2']=='') ? '-' : $row_nota['nota2'];
$nota3= ($row_nota['nota3']=='') ? '-' : $row_nota['nota3'];
$nota4= ($row_nota['nota4']=='') ? '-' : $row_nota['nota4'];
$nota5= ($row_nota['nota5']=='') ? '-' : $row_nota['nota5'];
$nota6= ($row_nota['nota6']=='') ? '-' : $row_nota['nota6'];
$notatotal= ($row_nota['notatotal']=='') ? '-' : $row_nota['notatotal'];

?>
                <tr>
                  <th class="sub"><?=$row['id']?></th>
                  <td><?=$row['titol']?></td>
		  <td><?=$nota1?></td>
		  <td><?=$nota2?></td>
		  <td><?=$nota3?></td>
		  <td><?=$nota4?></td>
		  <td><?=$nota5?></td>
		  <td><?=$nota6?></td>
		  <td><?=$notatotal?></td>
                  <td><?=$comunicacio_eval[$row['comunicacio']]?></td>
		  <td><?=$comunicacio_eval[$row_nota['recomanacio']]?></td>
                  <td><a href="comunicacions_show.php?accio=A&id=<?=$row['id']?>&num=<?=$c;?>" target="_blank">Ver</a></td>
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
