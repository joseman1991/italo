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
                    <strong>Exito! </strong> Receta Guardada <a href="index.php">IR A INICIO</a>!
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
                $cod = $_POST['cod'];
                $dosis = $_POST['dosis'];
                $cantidad = $_POST['cantidad'];
                $cobserv = $_POST['observ'];
                $descr = $_POST['descrip'];
                $idusuario = $_POST['idusuario'];




                if ($crud->insertarReceta($descr, $idusuario)) {
                    $id=$crud->id;
                    $b=true;
                    for ($index = 0; $index < count($dosis); $index++) {
                        if ($cobserv[$index] == null) {
                            $cobserv[$index] = 'n/a';
                        }
                       $b= $crud->insertarDetalle($id, $cod[$index], $dosis[$index], $cobserv[$index],$cantidad[$index]);
                       if(!$b){
                           break;
                       }
                    }
                    if($b){
                        header("Location: receta.php?inserted");
                    }else{
                          echo '<h1>' . $crud->error . '</h1>';
                    }
                    
                } else {
                    echo '<h1>' . $crud->error . '</h1>';
                    echo '<h1>' . $crud->id . '</h1>';
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
                            <label for="paciente">Paciente</label>
                            <datalist id="pacientes">                              
                            </datalist>
                            <input type="text" class="form-control" id="paciente" placeholder="Paciente" list="pacientes"  autocomplete="off" required="">
                            <input type="hidden" class="form-control" id="codusuario" name="codusuario" >                            
                        </div>



                        <div class="form-group">
                            <label for="Observacion">Descripcion</label>
                            <textarea style="resize: none;" class="form-control" id="Observacion" placeholder="Obervacion" name="descrip" cols="1"></textarea>  

                        </div>

                        <div >
                            <label for="Medicina">Medicinas</label>
                            <div class="input-group">  
                                <datalist id="medicinas">                              
                                </datalist>
                                <input type="text" class="form-control" id="medicina" placeholder="Medicina" list="medicinas" name="Medicina"> 
                                <span class="input-group-btn">
                                    <button class="btn btn-info" type="button" id="bton" value="agregar">Agregar</button>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group"> 
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>Descripcion</th>
                                <th>Dosis</th>
                                <th>Observacion</th>
                                </thead >
                                <tbody></tbody>
                                <tfoot>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>Descripcion</th>
                                <th>Dosis</th>
                                <th>Observacion</th>                             
                                </tfoot>
                            </table>
                        </div>
                        <input type="hidden" name="idusuario" id="iu">


                        <button type="submit" class="btn btn-primary" name="btn-save">Recetar</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include './BodyImports.php';
        ?>
        <script src="assets/js/scriptregistro.js"></script>
        <script src="assets/js/busca.js">
        </script>
    </body>
</html>
<?php
ob_end_flush();
?>