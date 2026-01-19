<?
ob_start();
session_start();  
if(isset($_COOKIE['docs_cookname']) && isset($_COOKIE['docs_cookpass'])){
      $_SESSION['user'] = $_COOKIE['docs_cookname'];
      $_SESSION['pass'] = $_COOKIE['docs_cookpass'];
      $_SESSION['name'] = $_COOKIE['docs_cookreal_name'];
}


// Si l'usuari i password no existeixen tornem al login
if (!$_SESSION['user'] || !$_SESSION['pass']) { 
	
	header('Location: login.php'); 
	die(); 

// En cas contrari busquem que existeixi l'usuari i el password
} else { 
	/*$db = mysql_connect($DBHost,$DBUser,$DBPass) or die("Impossible connectar amb el servidor de base de dades"); 
	mysql_select_db($DBName) or die("Impossible obrir la base de dades"); 
	mysql_set_charset('utf8');*/
	$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);
	// Busquem l'usuari i password'
	$sql = "SELECT * FROM inscripcions WHERE password='$_SESSION[pass]' AND usuari='$_SESSION[user]'";
	$result = $con->query($sql); 
	$num = $result->rowCount();
	// Si no existeix
	if (!$num) { 
		header('Location: login.php'); 
		die(); 
		} 
} 
ob_end_clean();
session_id();
?>
