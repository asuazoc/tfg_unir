<?
include('vars.inc.php');
/*if($_GET['lang']=='en'){
	include('lang_en.php');
	$lang = 'en';
}else{
	include('lang_es.php');
	$lang = 'es';
}*/
//include('classes/JSON.php');
include('classes/disponiblitat.php');

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors',0);
// create a new instance of Services_JSON
//$json = new Services_JSON();

/* calculats Hotel */
$hotel_habitacio=explode('|',$_POST['hotel_habitacio']);
$id_hotel=$hotel_habitacio[0];
$id_habitacio=$hotel_habitacio[1];

/*Acompanyant Sopar*/
if($_POST['acomp_sopar']=='Si'){
	$preu_acomp=$preu_sopar_acomp;
}else{
	$preu_acomp=0;
}

$id_inscripcio=$_POST['id_inscripcio'];
$preu_taller=0;
if($_POST['tallerpre']=='Si'){
	if(($id_inscripcio=='ES')||($id_inscripcio=='EA')||($id_inscripcio=='EN')){
		$preu_taller=0;
	}else{
		$preu_taller=$preu_taller_preCongres;
	}
}



/* Preus */
$data=mktime(0,0,0,date('m'),date('d'),date('Y'));
if($data<$datatall_inscripcions)
	$tall=1;
else
	$tall=2;

/* Calculats */

if (!empty($_POST['dataentrada']) && !empty($_POST['datasortida'])){
$dini=explode('/',$_POST['dataentrada']);
$dfi=explode('/',$_POST['datasortida']);

$ini=mktime(0,0,0,$dini[1],$dini[0],$dini[2]);
$fi=mktime(0,0,0,$dfi[1],$dfi[0],$dfi[2]);

if ($fi < $ini) {
    $t = $ini;
    $ini = $fi;
    $fi = $t;
}


$nits =round((($fi-$ini)/ 86400 ));
$t_allotjament=$allotjament[$id_hotel][$id_habitacio]*$nits;
}

$t_inscripcio= $inscripcio[$id_inscripcio][$tall];
$total=$t_inscripcio+$t_allotjament+$preu_acomp+$preu_taller;


//comprobem la disponibilitat
$disponibilitat=  new Disponibilitat();

$resultat_disp=$disponibilitat->ComprovacioDisponibilitatHabitacio($_POST['dataentrada'],$_POST['datasortida'],$id_hotel,null); //$id_habitacio); NO MIRA EL TIPUS D'HABITACIÓ
$resultat_disp=explode('#',$resultat_disp);
$valid=$resultat_disp[0];
$missatge=$resultat_disp[1];

//sanejem les variables
if ($t_inscripcio=='')
	$t_inscripcio=0;
if ($t_allotjament=='')
	$t_allotjament=0;
if ($nits=='')
	$nits=0;
if ($total=='')
	$total=0;


$total = round($total, 2);
// convert a complexe value to JSON notation, and send it to the browser
$value = array('inscripcio'=>$t_inscripcio,'allotjament'=>$t_allotjament,'nits'=>$nits,'total'=>$total,'valid'=>$valid,'missatge'=>$missatge);
$output = json_encode($value); //$json->encode($value);
print($output);
/*
<h1> Codi d'exemple:</h1>
<pre>

include('disponiblitat.php');
$disponibilitat=  new Disponibilitat();
echo "<b>Test Inscripci� OK:</b>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('29/05/2008','30/05/2008','Hotel Golf Fontanals');
echo "<b>Test data no disponible:</b>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('28/05/2008','30/05/2008','Hotel Park Puigcerd�');
echo "<b>Test data mal posada:</b>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('30/05/2008','28/05/2008','Hotel Park Puigcerd�');
echo "<b>Test format data erroni:</b>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('30/05/08','28/05/08','Hotel Park Puigcerd�');

</pre>

<h1>Sortida:</h1>


include('disponiblitat.php');
$disponibilitat=  new Disponibilitat();
echo "<b>Test Inscripci� OK:</b><br>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('29/05/2008','30/05/2008','Hotel Golf Fontanals').'<br>';
echo "<b>Test data no disponible:</b><br>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('28/05/2008','30/05/2008','Hotel Park Puigcerd�').'<br>';
echo "<b>Test data mal posada:</b><br>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('30/05/2008','28/05/2008','Hotel Park Puigcerd�').'<br>';
echo "<b>Test format data erroni:</b><br>";
echo $disponibilitat->ComprovacioDisponibilitatHabitacio('30/05/08','28/05/08','Hotel Park Puigcerd�').'<br>';
*/
?>
