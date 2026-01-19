<?
include('../vars.inc.php');
session_start(); 

/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['sistem_cookname']) && isset($_COOKIE['sistem_cookpass'])){
   setcookie("sistem_cookname", "", time()-60*60*24*100, "/");
   setcookie("sistem_cookpass", "", time()-60*60*24*100, "/");
   setcookie("sistem_cookreal_name", "", time()-60*60*24*100, "/");
}

   unset($_SESSION['username']);
   unset($_SESSION['password']);
   unset($_SESSION['name']);
   unset($_SESSION['revisio']);
   unset($_SESSION['comunicacions_visibles']);
   unset($_SESSION['comunicacions_revisio']);
   unset($_SESSION['comunicacions_revisio2']);

 
   $_SESSION = array(); // reset session array
   session_destroy();   // destroy session.
header("Location: login.php");
?>
