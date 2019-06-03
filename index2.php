<?php
include_once 'dbconfig.php';
?>
<?php include_once 'header.php'; ?>
<div class="clearfix"></div>
<div class="container">
    <a href="add-estudiante.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir Alumno</a>
    <a href="add-docente" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir Docente</a>
    <a href="add-responsable" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir Responsable</a>
</div>
<div class="container">
</div>
<div class="clearfix"></div><br />
<div class="container">
    <table class='table table-bordered table-responsive table-striped table-hover'>
        <tr>
            <th>Num</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Numero Contacto</th>
            <th>Pais</th>
            <th colspan="2" align="center">Actions</th>
        </tr>
    </table>
</div>
<?php include_once 'footer.php'; 
?>