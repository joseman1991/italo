<?php

include './dbconfig.php';
if (!empty($_POST["op"]== 1) ) {
    $datos = $crud->buscarPaciente();
} else {
    $datos = $crud->buscarMedicinas();
}
$json = json_encode($datos);
echo ($json);

