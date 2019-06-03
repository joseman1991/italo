<?php
include './dbconfig.php';
if (!empty($_POST["idprovincia"])) {
    $query = "select idcanton,nombrecanton from cantones where idprovincia='".$_POST["idprovincia"]."'";
    $data = $DB_con->prepare($query);    // Prepare query for execution
    $data->execute(); // Execute (run) the query  
    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['idcanton'] . '">' . $row['nombrecanton'] . '</option>';
    }
}