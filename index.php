<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title> Sistema Médico</title> 
<?php include './HeadImports.php'; ?>
</head>
<body>
<div class="wrapper">
<!-- Sidebar Holder -->
<?php
include './VerticalNav.php';
?>
<!-- Page Content Holder -->
<div id="content">
<?php
include './HorizontalNav.php';
 if(!empty($userDetails)){
 echo '<h3>Bienvenido al sistema</h3>';
 }else{
echo '<a href="login.php" class="btn btn-primary">Ir a iniciar sesion</a>';
 }
?>
</div>
</div>
<?php
include './BodyImports.php';
?>
</body>
</html>