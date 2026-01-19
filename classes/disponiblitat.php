<?
include('lang_es.php');
$lang = 'es';
include('../vars.inc.php');

error_reporting(E_ALL);
ini_set('display_errors', 0);
/*$con = new mysqli($DBHost, $DBUser, $DBPass, $DBName); $con->set_charset("utf8");
*/
/*$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);*/

//error_reporting(E_ALL);

/*
CREATE TABLE IF NOT EXISTS `hotel_habitacio_periodes` (
`hotel` varchar( 250 ) NOT NULL ,
`habitacio` varchar( 250 ) NOT NULL ,
`data_inici` date NOT NULL default '0000-00-00',
`data_final` date NOT NULL default '0000-00-00',
`places` int( 11 ) NOT NULL default '0',
KEY `hotel_habitacio_periodes_FI_1` ( `hotel` ) ,
KEY `hotel_habitacio_periodes_FI_2` ( `habitacio` )
)
 */

class Disponibilitat{

function ComprovacioDates($data_entrada,$data_sortida){
	// Comprovar les dates
	// retorns
	// ER#Intervals de data mal formats o invalids
	// OK#

	//dividem les dates en un array
	$adata_entrada=explode('/',$data_entrada);
	$adata_sortida=explode('/',$data_sortida);

	//el format de dates no es v�lid
	if(count($adata_entrada)!=3 || count($adata_sortida)!=3)
    	return "ERD#Format de les dates invalid";

	//fem els timestamps
	$tdata_entrada=mktime(0,0,0,$adata_entrada[1],$adata_entrada[0],$adata_entrada[2]);
    	if($tdata_entrada==FALSE ||  $tdata_entrada== -1)
        	return "ERD#Data d'entrada no vàlida";
	$tdata_sortida=mktime(0,0,0,$adata_sortida[1],$adata_sortida[0],$adata_sortida[2]);
    	if($tdata_sortida==FALSE ||  $tdata_sortida== -1)
        	return "ERD#Data sortida no vàlida";

	//comprovem que la data d'entrada es m�s petita que la de sortida
	if($tdata_entrada>$tdata_sortida)
    	return "ERD#La data d'entrada no pot ser més gran que la de sortida";

	return "OK#";
}


function CalculNits($data_entrada,$data_sortida){
    //Comprobem dates
    $res=$this->ComprovacioDates($data_entrada,$data_sortida);

    if ($res!="OK#")
            return explode('#',$res);

    //dividem les dates en un array
    $adata_entrada=explode('/',$data_entrada);
    $adata_sortida=explode('/',$data_sortida);

    //fem els time stamps
    $tdata_entrada=mktime(0,0,0,$adata_entrada[1],$adata_entrada[0],$adata_entrada[2]);
    $tdata_sortida=mktime(0,0,0,$adata_sortida[1],$adata_sortida[0],$adata_sortida[2]);

    //contem els dies
    $dies =(($tdata_sortida-$tdata_entrada)/ 86400 );

    //contruim una matriu en els dies
    $adies=array();
    for($i=0;$i<$dies;$i++){
        $adies[]=date('d/m/Y',$tdata_entrada+(86400*$i));
    }


    //retorns
    // OK -> array('01/01/2007','02/01/2007')
    // ER  -> array('ERR','rao')

    return $adies;
}


function  date2mysql($data){
    //ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $data, $mdata);
    $mdata = explode('/',$data);
    $fdata=$mdata[2]."-".$mdata[1]."-".$mdata[0];
    return $fdata;
}


//Comprovar que existeix un periode de l'habitacio demanada entre les dates indicades
//Comprovar que hi ha suficient capacitat per a tots els dies de la reserva
function ComprovacioDisponibilitatHabitacio($data_entrada,$data_sortida,$hotel,$habitacio=false,$idInscripcio=false){

	$DBHost="mysql.HOSTNAME.com";
	$DBUser="tfgunir";
	$DBPass="tfg2025u";
	$DBName="tfgunir25";
$con = new PDO('mysql:host='.$DBHost.';dbname='.$DBName.';charset=utf8', $DBUser,$DBPass);

//Calculem les nits entre les dates
if(($data_entrada!='')&&($data_sortida!='')&&($hotel!='null'))
	$nits=$this->CalculNits($data_entrada,$data_sortida);

//no  s'ha seleccionat cap nit
if (empty($nits))
        return "ERCN#No s'ha seleccioant cap nit";

//en cas d'error contruim una cadena amb ell i el retornem
if ($nits[0]=="ER")
        return implode($nits,'#');


//passem totes les nits

$preu_total=0;

$ocupacioResult = "OK#Ocupació";
foreach($nits as $nit){

    //convertim a format mysql
    $nitmy=$this->date2mysql($nit);

    //mirem si existeix alguna habitaci� per aquest periode

    $sql="select * from hotel_habitacio_periodes
    		where
    		DATA_INICI<= '$nitmy' and
    		DATA_FINAL>= '$nitmy' and
    		hotel='$hotel' ";

    //mirem si tamb� s'ha de tenir amb compte l'habitacio
    if ($habitacio!=false)
    	 //$sql.=" and habitacio='$habitacio' ";

	 //unicament en necessitem que n'existeixi un
	 $sql.=" limit 0,1 ";

    	$result = $con->query($sql);
	$num = $result->rowCount();

    if ($num==0)
        return "ERD#La habitación indicada no se puede contratar en este período ($nit)";
    else{
    	$row_hotel = $result->fetch(PDO::FETCH_ASSOC);
        //$preu=$hab->getPreu();
        //$preu_total+=$preu;

        $places=$row_hotel['places'];

    //mirem si l'habitacio ja esta amb totes les pla�es ocupades

    $sql="select count(*) ocupacio from inscripcions
    		where
    		dataentrada<= '$nitmy' and
    		datasortida> '$nitmy' and
    		hotel='$hotel'  and nits!=0";

    //mirem si tamb� s'ha de tenir amb compte l'habitacio
    if ($habitacio!=false)
    	 	$sql.=" and habitacio='$habitacio' ";

    //mirem de no contar la propia inscripcio en cas de modificar
    if($idInscripcio!=false)
        	$sql.=" and id<>$idInscripcio ";

    	$result = $con->query($sql);
	$row_ocupacio = $result->fetch(PDO::FETCH_ASSOC);

    $ocupacio = $row_ocupacio['ocupacio'];

    /*if($ocupacio<$places){
        	return "OK#Ocupació:".$ocupacio."(Lliure)";
        }
    else{
        	return "ER#".TXT_NO_HABITACIONS;
        }*/
    		if($ocupacio>=$places){
	    		return "ER#Ocupació: ".$nit." (No hi ha places suficients per fer la reserva)";
	    	}

		}
    }


}


}
?>
