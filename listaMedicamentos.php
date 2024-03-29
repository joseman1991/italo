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
                <h2>Lista de Medicamentos</h2>
                <div class="form-group">
                    <table class='table table-bordered table-responsive table-striped table-hover'>
                        <?php
                        if (!empty($userDetails)) {
                            if ($userDetails->idperfil == 3 ||$userDetails->idperfil == 2) {
                                ?>
                                <tr>
                                    <th>Codigo</th>                                    
                                    <th>Medicina</th>
                                    <th>Categoria</th>
                                   
                                </tr>
                                <?php
                                $query = "SELECT idmedicina,descripcion,idcategoria FROM medicinas";
                                $records_per_page = 10;
                                $newquery = $crud->paging($query, $records_per_page);
                                $crud->verReceta2($newquery);
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
                        } else {
                            header("location: login.php");
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