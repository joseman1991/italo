<?php
include_once 'dbconfig.php';
if (isset($_POST['btn-save'])) {
    $dni = $_POST['dni'];
    $lnombre1 = $_POST['n1'];
    $nombre2 = $_POST['n2'];
    $apellido1 = $_POST['a1'];
    $apellido2 = $_POST['a2'];
    $provinci = $_POST['idprovincia'];
    $canton = $_POST['idcanton'];
    if ($crud->insertarAlumnos($dni, $lnombre1, $nombre2, $apellido1, $apellido2, $provinci, $canton)) {       
        header("Location: add-estudiante?inserted");
    } else {
        echo $crud->error;
        header("Location: add-estudiante?failure");
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
                <td>Seleccione Provincia</td>
                <td> 
                    <select name='idprovincia' class='form-control' required> 
                        <?php
                        $query = "select idprovincia,nombreprovincia from provincias";
                        $data = $DB_con->prepare($query);    // Prepare query for execution
                        $data->execute(); // Execute (run) the query

                        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['idprovincia'] . '">' . $row['nombreprovincia'] . '</option>';
                        }
                        ?>
                    </select >
                </td>
            </tr>
            <tr>
                <td>Seleccione Canton</td>
                <td> 
                    <select name='idcanton' class='form-control' required> 
                        <?php
                        $query = "select idcanton,nombrecanton from cantones";
                        $data = $DB_con->prepare($query);    // Prepare query for execution
                        $data->execute(); // Execute (run) the query

                        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['idcanton'] . '">' . $row['nombrecanton'] . '</option>';
                        }
                        ?>
                    </select >
                </td>
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