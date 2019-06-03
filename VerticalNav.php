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
            <a href="index.php"><span><i class="fas fa-home"  > </i></span> Inicio  </a>
        </li>
        <li class>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <span><i class="fas fa-address-book"  > </i></span> Citas</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="citas.php">Reservar una cita</a>
                </li>
                <li>
                    <a href="estado-citas.php">Ver estado de citas</a>
                </li>                
            </ul>          
        </li>
        <li>             
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Consultas</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="diagnostico.php">Diagnostico</a>
                </li>
                <li>
                    <a href="receta.php">Crear Receta</a>
                </li>
                <li>
                    <a href="verReceta.php">Ver Receta</a>
                </li>

            </ul>
        </li>

    </ul>
    <ul class="list-unstyled CTAs">
        <li>
            <a></a>
        </li>
        <li>
            <a ></a>
        </li>
    </ul>
</nav>