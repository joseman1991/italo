<?php
session_start();
ob_start();
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
                    <strong>Exito! </strong> Historial Guardado <a href="index.php">IR A INICIO</a>!
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
            $diagnostico = $_POST['diag'];
            $observacion = $_POST['obser'];
            $idcita = $_POST['idcita'];
            $fecha = $_POST['fecha'];
            $idestado = $_POST['idestado'];
            $apellido2 = $_POST['a2'];
            $codusuario = $_POST['codu'];            
            if ($crud->diagnosticar($diagnostico, $fecha, $idcita, $observacion, $codusuario, $idestado)) {
                header("Location: estado-citas.php?inserted");
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
                <h2>Registro de Historial</h2>
                <div class="form-group">
                    <form  method="post">                         
                        <div class="form-group">
                            <label for="inputAddress">Nombre</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="Nombre" value="<?php echo $_GET['nombre']; ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Diagnostico</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="Diagnostico" name="diag">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Observacion</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="Obervacion" name="obser">
                        </div>
                        <input type="hidden" name="idcita" value="<?php echo $_GET['idcita']; ?>">
                        <input type="hidden" name="idestado" value="3">
                        <input type="hidden" name="fecha" value="<?php echo $_GET['fecha']; ?>">
                        <input type="hidden" name="codu" value="<?php echo $_GET['codu']; ?>">
                                           
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