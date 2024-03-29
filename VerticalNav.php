<?php
include './dbconfig.php';
include './session.php';
if ($session_uid > 0) {
    $userDetails = $crud->userDetails($session_uid);
}
?>
<nav id="sidebar">
    <div class="sidebar-header">
        <h4>Sistema Médico Carlos Luis Rivera </h4>
    </div>
    <div class="text-center profile-userpic ">
        <img src="http://downloadicons.net/sites/default/files/business-user-icon-44613.png" class="img-responsive" alt="">
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">
            <?php
            if (!empty($userDetails)) {
                echo $userDetails->nombre1 . " " . $userDetails->apellido1;
            }
            ?>            
        </div>
        <div class="profile-usertitle-job">
            <?php
            if (!empty($userDetails)) {
                $perfil = $crud->getPerfil($userDetails->idperfil);
            }
            if (!empty($perfil)) {
                echo $perfil->descripcion;
            }
            ?>            
        </div>
    </div>
    <ul class="list-unstyled components">  
        <li class="active">
            <a href="index.php"><span><i class="fas fa-home"  > </i></span> Inicio     </a>
        </li>
        <?php
        if (!empty($userDetails)) {
            ?>   
            <li class>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span><i class="fas fa-address-book"  > </i></span> Citas</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <?php
                    if ($perfil->idperfil == 1 || $perfil->idperfil == 3) {
                        ?>   
                        <li>                       
                            <a href="citas.php">Reservar una cita</a>
                        </li>
                        <?php
                    }
                    ?>  
                    <li>
                        <a href="estado-citas.php">Ver estado de citas</a>
                    </li> 

                </ul>          
            </li>
            <li>             
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span><i class="fas fa-ambulance"></i></span> Consultas</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="diagnostico.php">Historia Clínica</a>
                    </li>
                    <?php 
                    if($perfil->idperfil ==2){
                    ?>
                    <li>
                        <a href="receta.php">Crear Receta</a>
                    </li>
                    
                    <?php
                    }
                    ?>
                    <li>
                        <a href="verReceta.php">Ver Receta</a>
                    </li>

                </ul>
            </li>
            
            <?php
            
             if($perfil->idperfil ==2 || $perfil->idperfil ==3){
                 
             
            ?>
            <li>             
                <a href="#medSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span><i class="fas fa-prescription-bottle-alt"></i></span> Medicinas</a>
                <ul class="collapse list-unstyled" id="medSubmenu">
                    
                    <?php
                    if($perfil->idperfil !=2 ){
                    ?>
                    <li>
                        <a href="medicamentos.php">Registrar medicinas</a>
                    </li>
                   <?php
                    }
                   ?>
                    <li>
                        <a href="listaMedicamentos.php">Ver medicinas</a>
                    </li>
                   
                </ul>
            </li>
             <?php }}
        ?>  
    </ul>

</nav>