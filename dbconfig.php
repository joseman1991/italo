<?php
//session_start();
$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "mariadb";
$DB_name = "medicina";
$DB_port = "3307";
try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name};port=3307;charset=utf8", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    include_once 'class.crud.php';

    $crud = new crud($DB_con);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>