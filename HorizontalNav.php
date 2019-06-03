<?php
//include './dbconfig.php';
//include './session.php';
if ($session_uid > 0) {
    $userDetails = $crud->userDetails($session_uid);
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="navbar-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <?php
                    if (!empty($userDetails)) {
                        echo '<a class="nav-link"><span><i class="fas fa-user" > </i></span> '.$userDetails->nombre1 . " " . $userDetails->apellido1.'</a>';
                    } else {
                        echo '<a class="nav-link" href="registro.php">Registrarse</a>';
                    }
                    ?>                    
                </li>
                <li class="nav-item">
                    <?php
                    if (!empty($userDetails)) {
                        echo '<a class="nav-link" href="logout.php">Cerrar sesión</a>';
                    } else {
                        echo '<a class="nav-link" href="login.php">Login</a>';
                    }
                    ?>                     
                </li>
            </ul>
        </div>
    </div>
</nav>