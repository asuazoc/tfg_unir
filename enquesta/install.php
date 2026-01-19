<?php
define('INSTALL_CHECK',"installed");
include('../vars.inc.php');
error_reporting(-1);
ini_set('display_errors', 'On');

date_default_timezone_set("Europe/Madrid");


if (file_exists(INSTALL_CHECK)) {
	exit("INSTALLED");
}

/*mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);

mysql_connect($DBHost,$DBUser,$DBPass);
mysql_select_db($DBName);
mysql_set_charset('utf8');*/
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

$create = "CREATE TABLE enquesta (
id int(11) NOT NULL auto_increment PRIMARY KEY,
opcio_contingut int NOT NULL,
opcio_temes int NOT NULL,
opcio_duracio int NOT NULL,
opcio_metodologia int NOT NULL,
opcio_condicions int NOT NULL,
opcio_ponents int NOT NULL,
opcio_claretat int NOT NULL,
opcio_motivacio int NOT NULL,
opcio_horari int NOT NULL,
opcio_util int NOT NULL,
opcio_organizacio int NOT NULL,
aportacions varchar(200) NOT NULL
)";

mysql_query($create) or die (mysql_error());


$f = fopen(INSTALL_CHECK, "w") or die("Unable to open file!");
$txt = "INSTALLED\n";
fwrite($f, $txt);
fclose($f);