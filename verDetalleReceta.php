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
                <h2>Ver recetas</h2>
                <div class="form-group">
                    <table class='table table-bordered table-responsive table-striped table-hover'>
                        <?php
                        if (!empty($userDetails)) {
                            
                                ?>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Medicina</th> 
                                    <th>Cantidad</th>                                    
                                    <th>Dosis</th>
                                    <th>Obervacion</th>
                                </tr>
                                <?php
                                $idreceta = $_GET['idreceta'];
                                $query = "SELECT dr.idmedicina,m.descripcion,cantidad,dosis,observacion FROM detallereceta dr "
                                        . "inner join receta r on r.idreceta=dr.idreceta "
                                        . "inner join medicinas m on m.idmedicina = dr.idmedicina "
                                        . " where dr.idreceta=$idreceta"; /* where codusuario='$session_uid'"; */
                                $records_per_page = 1;
                                $newquery = $crud->paging($query, $records_per_page);
                                $crud->verDetalleReceta($newquery);
                                ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="pagination-wrap">
                                            <?php $crud->paginglink($query, $records_per_page); ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                           
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