<?
include('login.php');
error_reporting(E_ALL);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD']=="POST"){
	// Els params surten del require_once del login.php => /vars.php
    $l = new Login($DBHost, $DBUser, $DBPass, $DBName, SESSIO_CONTROL);

	if ($l->initSession($_POST['usuari'],$_POST['password']))  //si existeix el login de l'usuari es pot continuar
		header("Location: ".$_GET['page']);

}

?>
<!DOCTYPE html>
<html lang="ca">
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<TITLE><?=$titol_congres;?></title>


	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="development-bundle/ui/jquery.validate.min.js"></script>
	<script src="js/jquery.form.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<!--[if lt IE 9]>
	<script src="/dist/html5shiv.js"></script>
	<![endif]-->
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>

</HEAD>

<body>
	<div class="container">
		<H1 align="center">Administraci&oacute;</H1>

		<form method="post">

			<div class="jumbotron">
				<center>
          <table>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td><div align="right"><strong>Usuari: </strong></div></td>
							<td><INPUT NAME="usuari" TYPE="text" SIZE="10" MAXLENGTH="15" /></td>
						</tr>
						<tr>
							<td><div align="right"><strong>Contrasenya: </strong></div></td>
							<td><INPUT NAME="password" TYPE="password" SIZE="10" MAXLENGTH="15" /></td>
						</tr>
						<tr>
							<td colspan="2"> <div align="center"><INPUT NAME="enviar" TYPE="submit" VALUE="enviar" /></td>
	      		</tr>
					</table>
        </center>
			</div>
		</form>
	</div>
</body>
</html>
