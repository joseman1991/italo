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
        ?>
        <?php
        if (isset($_GET['inserted'])) {
            ?>
            <div class="container">
                <div class="alert alert-info">
                    <strong>Exito! </strong> Te has registrado <a href="index.php">IR A INICIO</a>!
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
            $dni = $_POST['ci'];
            $clave = $_POST['clave'];
            $lnombre1 = $_POST['n1'];
            $nombre2 = $_POST['n2'];
            $apellido1 = $_POST['a1'];
            $apellido2 = $_POST['a2'];
            $dir = $_POST['dir'];
            $tel = $_POST['tel'];
            $correo = $_POST['correo'];
            $canton = $_POST['idcanton'];
            $fn = $_POST['fn'];
            if ($crud->insertarPaciente($dni, $correo, $clave, $lnombre1, $nombre2, $apellido1, $apellido2, $dir, $tel, $canton, $fn)) {
                header("Location: registro.php?inserted");
            } else {
                echo '<h1>'.$crud->error-'</h1>';
                //header("Location: registro.php?failure");
            }
        }
            ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php
                include './HorizontalNav.php';
                ?>
                <h2>Registro de pacientes</h2>
                <div class="form-group">
                    <form  method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Correo Electrónico</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Correo Electrónico" required="" name="correo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Contraseña</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Contraseña" required name="clave">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Primer Nombre</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Primer Nombre" required="" name="n1">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Segundo Nombre</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Segundo Nombre" required name="n2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Primer Apellido</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Primer Apellido" required="" name="a1">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Segundo Apellido</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Segundo Apellido" required name="a2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Cédula de Ciudadanía</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Cédula de Ciudadanía" required="" name="ci">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Teléfono</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Teléfono" required name="tel">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Fecha de Nacimiento</label>
                                <input   class="form-control" id="datepicker" placeholder="Fecha de Nacimiento" name="fn">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Dirección</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="Dirección" name="dir">
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
        include './BodyImports.php';
        ?>
        <script src="assets/js/scriptregistro.js">
        </script>
    </body>
</html>
<?php
ob_end_flush();
?>