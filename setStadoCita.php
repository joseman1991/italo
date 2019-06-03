<?php
session_start();
ob_start();
?>
<?php
include './dbconfig.php';
if ($_GET['idcita']) {
    echo "Es uno";
    $idcita = $_GET['idcita'];
    $idestado = $_GET['idestado'];
    if($crud->updateEstado($idcita,$idestado)){
        header("Location: estado-citas.php");
    }
} 
?>
<?php
ob_end_flush();
?>