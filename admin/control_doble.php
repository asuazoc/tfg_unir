<?
ob_start();
session_start();
if(isset($_COOKIE['sistem_cookname']) && isset($_COOKIE['sistem_cookpass'])){
      $_SESSION['user'] = $_COOKIE['sistem_cookname'];
      $_SESSION['pass'] = $_COOKIE['sistem_cookpass'];
      $_SESSION['name'] = $_COOKIE['sistem_cookreal_name'];
}else if(isset($_COOKIE['docs_cookname']) && isset($_COOKIE['docs_cookpass'])){
      $_SESSION['user'] = $_COOKIE['docs_cookname'];
      $_SESSION['pass'] = $_COOKIE['docs_cookpass'];
      $_SESSION['name'] = $_COOKIE['docs_cookreal_name'];
      $_SESSION['tipus_usuari'] = $_COOKIE['docs_cooktipus'];
}



// Si l'usuari i password no existeixen tornem al login
if (!$_SESSION['user'] || !$_SESSION['pass']) {
	header('Location: login.php');
	die();

// En cas contrari busquem que existeixi l'usuari i el password
} else {
	$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
	// Busquem l'usuari i password'
	if(isset($_SESSION['tipus_usuari']) && ($_SESSION['tipus_usuari']=='documents')){
		$result = mysqli_query($con,"SELECT count(id) FROM inscripcions WHERE password='".$_SESSION['pass']."' AND usuari='".$_SESSION['user']."'") or die("Couldn't query the user-database.");
	}else if(isset($_SESSION['user']) && isset($_SESSION['pass'])){
		$result = mysqli_query($con,"SELECT count(id) FROM users WHERE password='".$_SESSION['pass']."' AND usuari='".$_SESSION['user']."'") or die("Couldn't query the user-database.");
	}
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
