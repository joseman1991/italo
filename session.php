<?php
$session_uid=0;
if (!empty($_SESSION['codusuario'])) {
    $session_uid = $_SESSION['codusuario'];    
}
//if (empty($session_uid)) {    
//    header("Location: index.php");
//}
?>
