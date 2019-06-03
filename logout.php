<?php
session_start();
?>
<?php
include './dbconfig.php';
$session_uid='';
$_SESSION['codusuario']='';
if(empty($session_uid) && empty($_SESSION['codusuario'])){
header("Location: login.php");
}
?>
