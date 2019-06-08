<?php
ob_start();
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
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
                    <strong>Exito! </strong> Medicamento registrado con éxito <a href="index.php">IR A INICIO</a>!
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
                $idcategoria = $_POST['idcategoria'];
                $descripcion = $_POST['$descripcion'];              

                if ($crud->insertarMedicamento($idcategoria, $descripcion)) {
                    header("Location: medicamentos.php?inserted");
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
                        <h2>Registro de Medicamentos</h2>
                        <div class="form-group">
                            <form  method="post">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="inputState">Categoría</label>
                                        <select name='idcategoria' class='form-control' required  id="canton"> 
                                            <?php
                                            $query = "select idcategoria,descripcion from categorias";
                                            $data = $DB_con->prepare($query);    // Prepare query for execution
                                            $data->execute(); // Execute (run) the query

                                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $row['idcategoria'] . '">' . $row['descripcion'] . '</option>';
                                            }
                                            ?>
                                        </select >
                                    </div> 
                                    <div class="form-group col-md-4">
                                        <label for="inputState">Descripción</label>
                                        <input type="text" class="form-control" id="inputPassword4" placeholder="Descripción" required name="$descripcion">
                                    </div>
                                </div> 
                                <button type="submit" class="btn btn-primary" name="btn-save">Registrar medicamento</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            header("location: login.php");
        }
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