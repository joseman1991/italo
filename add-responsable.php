<?php
include_once 'dbconfig.php';
if (isset($_POST['btn-save'])) {
    $dni = $_POST['dni'];
    $lnombre1 = $_POST['n1'];
    $nombre2 = $_POST['n2'];
    $apellido1 = $_POST['a1'];
    $apellido2 = $_POST['a2'];
    $tel = $_POST['tel'];
    $mail = $_POST['corr']; 
    if ($crud->insertarResponsable($dni, $lnombre1, $nombre2, $apellido1, $apellido2, $tel, $mail)) {
        header("Location: add-responsable?inserted");
    } else {
        echo $crud->error;
       // header("Location: add-responsable?failure");
    }
}
?>
<?php include_once 'header.php'; ?>
<div class="clearfix"></div>
<?php
if (isset($_GET['inserted'])) {
    ?>
    <div class="container">
        <div class="alert alert-info">
            <strong>WOW!</strong> Record was inserted successfully <a href="index.php">HOME</a>!
        </div>
    </div>
    <?php
} else if (isset($_GET['failure'])) {
    ?>
    <div class="container">
        <div class="alert alert-warning">
            <strong>SORRY!</strong> ERROR while inserting record !
        </div>
    </div>
    <?php
}
?>
<div class="clearfix"></div><br />
<div class="container">
    <form method='post'>
        <table class='table table-bordered'>
            <tr>
                <td>Cedula</td>
                <td><input type='text' name='dni' class='form-control' required></td>
            </tr>
            <tr>
                <td>Primer Nombre</td>
                <td><input type='text' name='n1' class='form-control' required></td>
            </tr>
            <tr>
                <td>Segundo Nombre</td>
                <td><input type='text' name='n2' class='form-control' required></td>
            </tr>
            <tr>
                <td>Primer Apellido</td>
                <td><input type='text' name='a1' class='form-control' required></td>
            </tr>
            <tr>
                <td>Segundo Apellido</td>
                <td><input type='text' name='a2' class='form-control' required></td>
            </tr>
            <tr>
                <td>Telefono</td>
                <td><input type='text' name='tel' class='form-control' required></td>
            </tr>  
            <tr>
                <td>Email</td>
                <td><input type='email' name='corr' class='form-control' required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <span class="glyphicon glyphicon-plus"></span> Guardar el Registro
                    </button>  
                    <a href="index.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Retornar a la lista</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include_once 'footer.php'; ?>