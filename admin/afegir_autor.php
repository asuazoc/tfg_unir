<?php
	$num_autor=$_POST['autors'];
	$res='<table><tr><td colspan="2"><b>Autor/a '.($num_autor+1).'</b></td></tr>
	<tr>           
		<td><div align="left"><span class="normal">Nom i Cognoms:</span></div></td>           
		<td><input name="autor'.$num_autor.'" id="autor'.$num_autor.'" size="20" class="required" type="text" />           
			</td>         
	</tr>          
	<tr>          
		<td><div align="left"><span class="normal">Centre de treball:</span></div></td>           
		<td><input name="centre'.$num_autor.'" id="centre'.$num_autor.'" size="40" class="required" type="text" />             
			</td>         
	</tr>         
	</table><div id="nou_autor'.($num_autor+1).'"></div>';
	echo $res;
?>
