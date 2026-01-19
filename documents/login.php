<?PHP 
// inicialització de variables
require("../vars.inc.php");
if($_GET['lang']=='en'){
	include('../lang_en.php');
	$lang = 'en';
}else{
	include('../lang_es.php');
	$lang = 'es';
}
$pag="index.php";

// realitzem la connexió
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName, $DBUser,$DBPass);

//s'ha detectat algun error
$error=0;

// si hem entrat ja les dades comprovem que estiguin bé
if ($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "SELECT * FROM inscripcions WHERE password='$_POST[pass]' AND usuari='$_POST[user]' ";
	$result = $con->query($sql); 

// si la consulta és fallida tornem a mostrar els camps d'entrada
if ($result->rowCount()==0) { 
	$error=1;
// en cas contrari inicialitzem la sessió
} else { 
	
	$row = $result->fetch(PDO::FETCH_ASSOC);
	session_start(); 
	$_SESSION['ID'] = $row["ID"]; 
	$_SESSION['user'] = $row["usuari"]; 
	$_SESSION['pass'] = $row["password"]; 
	$_SESSION['name'] = $row["nom"].' '.$row["cg1"].' '.$row["cg2"];
	$_SESSION['tipus_usuari'] = 'documents'; 

	   /**
	    * This is the cool part: the user has requested that we remember that
    	    * he's logged in, so we set two cookies. One to hold his username,
	    * and one to hold his md5 encrypted password. We set them both to
	    * expire in 100 days. Now, next time he comes to our site, we will
	    * log him in automatically.
	    */
   if(isset($_POST['remember'])){
      setcookie("docs_cookname", $_SESSION['usuari'], time()+60*60*24*100, "/");
      setcookie("docs_cookpass", $_SESSION['password'], time()+60*60*24*100, "/");
      setcookie("docs_cookreal_name", $_SESSION['name'], time()+60*60*24*100, "/");
      setcookie("docs_cooktipus", $_SESSION['tipus'], time()+60*60*24*100, "/");
   }



	header("Location: $pag");
} 
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>


 
	
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<title><?=$titol_congres?></title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="style/reset.css" type="text/css" media="screen">
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen">
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="style/invalid.css" type="text/css" media="screen">	
		
		
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="style/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
	  
		<!-- jQuery -->
		<script type="text/javascript" src="js/jquery-1.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="js/simpla.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="js/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="js/jquery.js"></script>
		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="js/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
		
	</head><body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1><?=TXT_VALIDACIO?></h1>
				<!-- Logo (221px width) -->
				<!-- <img id="logo" src="images/logo.png" alt="Admin logo"> -->
			</div> <!-- End #logn-top -->
			
			<div id="login-content">
				
				<form action="login.php" method="post" >
					<?
						if ($error){
 
					?>
				<div class="notification error png_bg">
					<a href="#" class="close"><img src="images/cross_grey_small.png" title="Close this notification" alt="close"></a>
					<div><?=TXT_ERROR_VALIDACIO_LOGIN?></div>
				</div>
				
					<?
						}					
					?>					
					<p>
						<label><?=TXT_USUARI?></label>
						<input name="user" class="text-input" type="text" >
					</p>
					<div class="clear"></div>
					<p>
						<label><?=TXT_CONTRASENYA?></label>
						<input name="pass" class="text-input" type="password">
					</p>
					<div class="clear"></div>
					<p id="remember-password">
						<input name="remember" type="checkbox"><?=TXT_RECORDAR?>
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" value="<?=TXT_INICIAR?>" type="submit">
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
	      <div id="facebox" style="display: none;">       
	      	<div class="popup">         
	      		<table>           
	      			<tbody>             
	      				<tr>               
	      					<td class="tl"></td><td class="b"></td><td class="tr"></td>             
	      				</tr>             
	      				<tr>               
	      					<td class="b"></td>               
	      					<td class="body">                 
	      						<div class="content"></div>                 
	      						<div class="footer">                   
	      							<a href="#" class="close">                     
	      								<img src="images/closelabel.gif" title="close" class="close_image">
	      							</a>
	      						</div>               
	      					</td>               
	      					<td class="b"></td>             
	      				</tr>             
	      				<tr>               
	      					<td class="bl"></td><td class="b"></td><td class="br"></td>             
	      				</tr>           
	      			</tbody>         
	      		</table>       
	      	</div>     
	      </div>
		</body>
	</html>
