<?php
ob_start();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Sistema Médico</title> 
        <?php
        include './HeadImports.php';
        ?>
    </head>
    <body>
        <?php
        if (isset($_GET['inserted'])) {
            ?>
            <div class="container">
                <div class="alert alert-info">
                    <strong>Exito! </strong> Cita reservada con éxito <a href="index.php">IR A INICIO</a>!
                </div>
            </div>
            <?php
        } else if (isset($_GET['failure'])) {
            ?>
            <div class="container">
                <div class="alert alert-warning">
                    <strong>SORRY!</strong> Error mientras se insertaban los datos !
                </div>
            </div>
            <?php
        }
        ?>
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php
            include './VerticalNav.php';
            if (isset($_POST['btn-save'])) {               
                $canton = $_POST['idcanton'];
                $fn = $_POST['fn'];
                $hora=$_POST['appt-time'];
                $nombreuser=$session_uid;

                if ($crud->insertarCita($fn, $hora, $canton, $nombreuser) ) {
                    header("Location: citas.php?inserted");
                } else {
                    echo '<h1>' . $crud->error - '</h1>';
                    //header("Location: citas.php?failure");
                }
            }
            ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php
                include './HorizontalNav.php';
                  if (!empty($userDetails)) {
                            if ($userDetails->idperfil == 3) {
                ?>
                <h2>Registro de Citas</h2>
                <div class="form-group">
                    <form  method="post">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Correo Electrónico</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Correo Electrónico" required="" name="correo" value="<?php echo $userDetails->email ?>" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Fecha de Cita</label>
                                <input   class="form-control" id="datepicker" placeholder="Fecha de Cita" name="fn">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="appt-time">Hora</label>
                                <input class="form-control" type="time" id="appt-time" name="appt-time"
                                    value="09:00"   min="09:00" max="18:00" required />                                
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Primer Nombre</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Primer Nombre" required="" name="n1" value="<?php echo $userDetails->nombre1 ?>" readonly="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Segundo Nombre</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Segundo Nombre" required name="n2" value="<?php echo $userDetails->nombre2 ?>" readonly="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Primer Apellido</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Primer Apellido" required="" name="a1" value="<?php echo $userDetails->apellido1 ?>" readonly="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Segundo Apellido</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Segundo Apellido" required name="a2" value="<?php echo $userDetails->apellido2 ?>" readonly="">
                            </div>
                        </div>
                        <?php
                        ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Provincia</label>
                                <select name='idprovincia' class='form-control' required id="provincia"> 
                                    <?php
                                    $query = "select idprovincia,nombreprovincia from provincias";
                                    $data = $DB_con->prepare($query);    // Prepare query for execution
                                    $data->execute(); // Execute (run) the query

                                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['idprovincia'] . '">' . $row['nombreprovincia'] . '</option>';
                                    }
                                    ?>
                                </select >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Canton</label>
                                <select name='idcanton' class='form-control' required  id="canton"> 
                                    <?php
                                    $query = "select idcanton,nombrecanton from cantones where idprovincia='01'";
                                    $data = $DB_con->prepare($query);    // Prepare query for execution
                                    $data->execute(); // Execute (run) the query

                                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['idcanton'] . '">' . $row['nombrecanton'] . '</option>';
                                    }
                                    ?>
                                </select >
                            </div>                             
                        </div>                        
                        <button type="submit" class="btn btn-primary" name="btn-save">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
                  }} else {
    header("location: login.php");
    
}
        include './BodyImports.php';
        ?>
        <script src="assets/js/scriptregistro.js">
        </script>
    </body>
</html>
<?php
ob_end_flush();
?>