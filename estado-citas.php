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
                $hora = $_POST['appt-time'];
                $nombreuser = $session_uid;

                if ($crud->insertarCita($fn, $hora, $canton, $nombreuser)) {
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
                ?>
                <h2>Estado de citas</h2>
                <div class="form-group">
                    <table class='table table-bordered table-responsive table-striped table-hover'>
                        <?php
                        if (!empty($userDetails)) {
                            if ($userDetails->idperfil == 3) {
                                ?>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Canton</th>
                                    <th>Estado</th>
                                </tr>
                                <?php
                                $query = "SELECT * FROM citas where codusuario='$session_uid'";
                                $records_per_page = 3;
                                $newquery = $crud->paging($query, $records_per_page);
                                $crud->getGridCitas($newquery);
                                ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="pagination-wrap">
                                            <?php $crud->paginglink($query, $records_per_page); ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php } else {
                                ?>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Canton</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                <?php
                                $query = "SELECT * FROM citas where idestado<>3";
                                $records_per_page = 3;
                                $newquery = $crud->paging($query, $records_per_page);
                                $crud->getGridCitas2($newquery);
                                ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="pagination-wrap">
                                            <?php $crud->paginglink($query, $records_per_page); ?>
                                        </div>
                                    </td>
                                     
                                </tr>
                                <?php
                                }
                                }
                                ?>

                            </table>
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