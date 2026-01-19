<?
include('../vars.inc.php');
session_start(); 

/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['docs_cookname']) && isset($_COOKIE['docs_cookpass'])){
   setcookie("docs_cookname", "", time()-60*60*24*100, "/");
   setcookie("docs_cookpass", "", time()-60*60*24*100, "/");
   setcookie("docs_cookreal_name", "", time()-60*60*24*100, "/");
   setcookie("docs_cooktipus", "", time()-60*60*24*100, "/");
}

   unset($_SESSION['username']);
   unset($_SESSION['password']);
   unset($_SESSION['name']);
   unset($_SESSION['tipus_usuari']);

 
   $_SESSION = array(); // reset session array
   session_destroy();   // destroy session.
header("Location: login.php");
?>
