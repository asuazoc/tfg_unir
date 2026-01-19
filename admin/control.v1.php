<?
ob_start();
session_start();

if(isset($_COOKIE['sistem_cookname']) && isset($_COOKIE['sistem_cookpass'])){
      $_SESSION['user'] = $_COOKIE['sistem_cookname'];
      $_SESSION['userid'] = $_COOKIE['sistem_cookuserid'];
      $_SESSION['pass'] = $_COOKIE['sistem_cookpass'];
      $_SESSION['name'] = $_COOKIE['sistem_cookreal_name'];
}



// Si l'usuari i password no existeixen tornem al login
if (!$_SESSION['user'] || !$_SESSION['pass']) {
	header('Location: login.php');
	die();

// En cas contrari busquem que existeixi l'usuari i el password
} else {
	$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
	// Busquem l'usuari i password'
  $sql = "SELECT count(id) FROM users WHERE password='$_SESSION[pass]' AND usuari='$_SESSION[user]'";
	$result = mysqli_query($con,$sql) or die("Couldn't query the user-database.");
	$num = mysqli_fetch_assoc($result);
	// Si no existeix
	if ($num['count(id)']==0) {
		header('Location: login.php');
		die();
		}
}
ob_end_clean();
session_id();
?>
