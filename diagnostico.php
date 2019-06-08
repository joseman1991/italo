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
           
            ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php
                include './HorizontalNav.php';
                ?>
                <h2>Historial Clínico</h2>
                <div class="form-group">
                    <table class='table table-bordered table-responsive table-striped table-hover'>
                        <?php
                        if (!empty($userDetails)) {
                            if ($userDetails->idperfil == 1) {
                                ?>
                                <tr>
                                    <th>Código</th>
                                    <th>Diagnostico</th>
                                    <th>Fecha</th>
                                    <th>Observación</th>                                  
                                </tr>
                                <?php
                                $query = "SELECT idhistorial,diagnostico,fecha,observacion FROM historial where codusuario='$session_uid'";
                                $records_per_page = 10;
                                $newquery = $crud->paging($query, $records_per_page);
                                $crud->getHistorial($newquery);
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
                                    <td colspan="4">
                                        <form method="post">
                                            <div class="form-group">

                                                <label for="paciente">Paciente</label>
                                                <datalist id="pacientes">                              
                                                </datalist>
                                                <input type="text" class="form-control" id="paciente" placeholder="Paciente" list="pacientes"  autocomplete="off" required="">
                                                <input type="hidden" class="form-control" id="iu" name="codusuario" >                            
                                                <br><button type="submit" class="btn btn-info" id="iu" name="btn-save" >Buscar</button>                            
                                            </div>
                                        </form>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Código</th>
                                    <th>Diagnostico</th>
                                    <th>Fecha</th>
                                    <th>Observación</th>  
                                </tr>
                                <?php
                                if (isset($_POST['btn-save'])) {
                                    $codusuario = $_POST['codusuario'];
                                    $query = "SELECT idhistorial,diagnostico,fecha,observacion FROM historial where codusuario='$codusuario'";
                                    $records_per_page = 10;
                                    $newquery = $crud->paging($query, $records_per_page);
                                    $crud->getHistorial($newquery);
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
        <script src="assets/js/busca.js"></script>
    </body>
</html>
<?php
ob_end_flush();
?>