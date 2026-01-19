<?
include('../vars.inc.php');
include('control.php');

/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");

*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

if ($_SERVER['REQUEST_METHOD']=="POST"){
	$key = array_keys($_POST)[0];
	$sort= $_POST[$key];
    $id = intval(str_replace("edit-order-","",$key));
    
    if (empty($id)) {
    	die("Id error");
    }

    $sql='UPDATE comunicacions SET sort="'.$sort.'" where id="'.$id.'"';
    //mysqli_query($con,$sql);
    $con->query($sql);
    echo $sort;
}