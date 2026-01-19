<?php
include('../vars.inc.php');
include('control.php');

$aResultat = array("error"=>0);
try {
	$res=mysqli_query($con,"SELECT * FROM inscripcions ORDER BY cg1,cg2, nom");
	while($row=mysqli_fetch_assoc($res)){
		$id = $row['id'];
		if($_POST['certificat_'.$id]){
			$certificat = 'S';
		}else{
			$certificat = 'N';
		};
		$update = "UPDATE inscripcions SET certificat_assist='".$certificat."' WHERE id='".$id."' ";
		mysqli_query($con,$update);
	}
} catch (Exception $e) {
	$aResultat['error'] = 1;
    $aResultat['txterror'] = $e->getMessage();
}
echo json_encode($aResultat);
?>
