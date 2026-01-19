<?/*
 Connexió a mysql
 */
require_once('../vars.inc.php');


class Login {
    // De vars obtenim les variables de la BD. Però amb mysqli, per poder-les
    // passar a les funcions dels mètodes és necessari crear un constructor.
    // => new Login($DBHost, $DBPass, $DBName, $DBUser)
    protected $DBHost = '';
    protected $DBPass = '';
    protected $DBName = '';
    protected $DBUser = '';

    public function __construct($DBHost, $DBUser, $DBPass, $DBName, $SessionName) {
        $this->dbHost = $DBHost;
        $this->dbUser = $DBUser;
        $this->dbPass = $DBPass;
        $this->dbName = $DBName;
        $this->sessionName = $SessionName;
    }

    function Login(){}

    function initSession($usuari,$password){
        session_name($this->sessionName);
        session_start();

        $con    = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        $sql    = "SELECT * FROM users where usuari='$usuari' and password='".base64_encode($password)."'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result)!=0){
            $usr=mysqli_fetch_assoc($result);
            if ($usr['usuari']!=''){
                $_SESSION['login']    = $usr['usuari'];
                $_SESSION['password'] = $usr['password'];
                $_SESSION['nom']      = $usr['nom'];
                $_SESSION['rol']      = $usr['rol'];
                /*$_SESSION['rol']      = $usr['ROL'];*/
                return true;
            }else {
                return false;
            }
        }else{
            return false;
        }
    }


    function destroySession(){
        session_name($this->sessionName);
        session_start();
        session_destroy();
				session_commit();
    }

    function getLogin(){
        global $_SESSION;
        session_name($this->sessionName);
        session_start();
        if (isset($_SESSION['login'])){
            return ($_SESSION['login']);
        }else{
            return null;
        }

    }

    /*Retorna true si te la sessió iniciada. False en cas contrari*/
    function hasSession($area=""){
        session_name($this->sessionName);
        session_start();

        if (!isset($_SESSION['login']))  //si existeix el login de l'usuari es pot continuar
            return false;
        else
            return true;
    }
}
?>
