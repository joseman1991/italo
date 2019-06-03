<?php
ob_start();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Iniciar Sesión</title> 
<?php
include'./HeadImports.php';
$errorMsgLogin = '';
?>
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body> 
<?php
if (isset($_GET['inserted'])){
?>
<div class="container">
<div class="alert alert-info">
<?php
header('Location: index.php');
?>
</div>
</div>
<?php
} else if (isset($_GET['failure'])) {
?>
<div class="container">
<div class="alert alert-warning">
<strong>Lo sentimos!</strong> Error de inicio de sesion !
</div>
</div>
<?php
echo$errorMsgLogin;
}
?>
<div class="wrapper">
<?php
include './VerticalNav.php';
if (isset($_POST['loginSubmit'])) {
$usernameEmail = $_POST['usernameEmail'];
$password = $_POST['password'];
if ($crud->login($usernameEmail, $password)){
header("Location: login.php?inserted");
} else {
$errorMsgLogin = $crud->error;
echo '<h1>' . $crud->error - '</h1>';
}
} 
?>
<!-- Page Content Holder -->
<div id="content">
<?php
include './HorizontalNav.php';
?>
<h2>Iniciar Sesión</h2>
<div class="form-group">
<div id="login">
<form method="post" action="" name="login">
<label>Username or Email</label>
<input type="text" name="usernameEmail" autocomplete="on" />
<label>Password</label>
<input type="password" name="password" autocomplete="off"/>
<div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
<input type="submit" class="button" name="loginSubmit" value="Login">
</form>
</div>
</div>
</div>
</div>
<?php
include './BodyImports.php';
?>
<script src="assets/js/scriptlogin.js">
</script>
</body>
</html>
<?php
ob_end_flush();
?>