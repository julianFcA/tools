<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

// Validamos la sesión del usuario
// require_once "../../auth/validationSession.php";

// Verificamos si el usuario está logueado
if (!isset($_SESSION['documento'])) {
    header("Location: ./../../index.php"); // Redirigir a la página de inicio si no está logueado
    exit();
}

// Cerrar sesión
if (isset($_POST['btncerrar'])) {
    session_destroy();
    header("Location:../../index.php");
    exit();
}

$nit = $_SESSION['nit_empre'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Index |Administrador <?php echo $_SESSION['nombre'] ?></title>
    <link rel="icon" href="./../../images/icono.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">
    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="./../../assets/icon/themify-icons/themify-icons.css">
    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="./../../assets/icon/icofont/css/icofont.css">
    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="./../../assets/icon/simple-line-icons/css/simple-line-icons.css">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="./../../assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="./../../assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">
    <!-- Weather css -->
    <link href="./../../assets/css/svg-weather.css" rel="stylesheet">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="./../../assets/css/main.css">
    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="./../../assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./../../assets/css/responsives.css">
    <link rel="stylesheet" type="text/css" href="./../../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->


</head>
<body class="sidebar-mini fixed ">

<div class="wrapper">
    <!-- Navbar-->
    <header class="main-header-top hidden-print" style="background-color: #ff7c02">
        <a class="logo" href="./index.php">
            <span>
                Administrador
            </span>
        </a>
        <nav class="navbar navbar-static-top" style="background-color: #ff7c02">
            <!-- Sidebar toggle button-->
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
            <ul class="top-nav lft-nav">
            </ul>
            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu f-right">
                <ul class="top-nav">
                    <li class="pc-rheader-submenu ">
                    </li>
                    <!-- window screen -->
                    <li class="pc-rheader-submenu">
                        <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                            <i class="icon-size-fullscreen"></i>
                        </a>
                    </li>
                    <!-- User Menu-->
                    <li class="dropdown">
                        <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                            <span><img class="img-circle " src="./../../assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                            <?php echo $_SESSION['nombre'] ?> <i class=" icofont icofont-simple-down"></i></span>

                        </a>
                        <ul class="dropdown-menu settings-menu">
                            <li><a href="./datos.php"><i class="icon-user"></i> Perfil</a></li>
                            <li class="p-0">
                                <div class="dropdown-divider m-0"></div>
                            </li>
                            <li><a href="./cambio_contra.php"><i class="icon-settings"></i> Cambio de Contraseña</a></li>
                            <li class="p-0">
                                <div class="dropdown-divider m-0"></div>
                            </li>
                            <form method="POST" action="">
                                <li>
                                    <button class="logout-button" type="submit" name="btncerrar">
                                        <span class="icon-logout"></span>
                                        Cerrar sesión
                                    </button>
                                </li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Side-Nav-->
    <aside class="main-sidebar hidden-print ">
        <section class="sidebar" id="sidebar-scroll">
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">

                <li class="active treeview"><a style="background-color:rgba(255, 165, 0, 0.8);" class="waves-effect waves-dark" href="#!"><i class="icon-briefcase" href="#!"></i><span>MENÚ</span><i class="icon-arrow-down"></i></a>

                    <ul class="treeview-menu">
                        <li><a class="waves-effect waves-dark" href="index.php"><i class="icon-arrow-right"></i>Instructores</a></li>
                        <li><a class="waves-effect waves-dark" href="formacion.php"><i class="icon-arrow-right"></i>Formaciones</a></li>
                        <li><a class="waves-effect waves-dark" href="registro_forma.php"><i class="icon-arrow-right"></i> Registrar Formación</a></li>
                        <li><a class="waves-effect waves-dark" href="formacion_asig.php"><i class="icon-arrow-right"></i>Formaciones Asignadas</a></li>
                        <li><a class="waves-effect waves-dark" href="registro_instru.php"><i class="icon-arrow-right"></i> Registrar Instructor</a></li>
                        <li><a class="waves-effect waves-dark" href="regis_marca.php"><i class="icon-arrow-right"></i> Registrar Marca de Herramienta</a></li>
                        <li><a class="waves-effect waves-dark" href="regis_tp_herra.php"><i class="icon-arrow-right"></i> Registrar Tipo de Herramienta</a></li>
                        <li><a class="waves-effect waves-dark" href="registro_herra.php"><i class="icon-arrow-right"></i> Registrar Herramienta</a></li>
                        <li><a class="waves-effect waves-dark" href="herramienta.php"><i class="icon-arrow-right"></i> Herramienta</a></li>
                        <li><a class="waves-effect waves-dark" href="reporte.php"><i class="icon-arrow-right"></i> Reporte de Aprendices</a></li>
                        <li><a class="waves-effect waves-dark" href="ingreso_instru.php"><i class="icon-arrow-right"></i> Entrada de Instructores</a></li>
                        <li><a class="waves-effect waves-dark" href="ingreso_apren.php"><i class="icon-arrow-right"></i> Entrada de Aprendices</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
</div>


<section class="container-fluid footer_section">
    <p>
        Sena. Ibagué - Tolima
        <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
    </p>
</section>

<!-- Required Jqurey -->
<script src="./../../assets/plugins/Jquery/dist/jquery.min.js"></script>
<script src="./../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="./../../assets/plugins/tether/dist/js/tether.min.js"></script>

<!-- Required Fremwork -->
<script src="./../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Scrollbar JS-->
<script src="./../../assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="./../../assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

<!--classic JS-->
<script src="./../../assets/plugins/classie/classie.js"></script>

<!-- notification -->
<script src="./../../assets/plugins/notification/js/bootstrap-growl.min.js"></script>

<!-- Sparkline charts -->
<script src="./../../assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

<!-- Counter js  -->
<script src="./../../assets/plugins/waypoints/jquery.waypoints.min.js"></script>
<script src="./../../assets/plugins/countdown/js/jquery.counterup.js"></script>

<!-- Echart js -->
<script src="./../..assets/plugins/charts/echarts/js/echarts-all.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>

<!-- custom js -->
<script type="text/javascript" src="./../../assets/js/main.min.js"></script>
<script type="text/javascript" src="./../../assets/pages/dashboard.js"></script>
<script type="text/javascript" src="./../../assets/pages/elements.js"></script>
<script src="./../../assets/js/menu.min.js"></script>

<script src="./../../js/public.js"></script>

<!-- Bootstrap JS y otros scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<!-- Tus scripts personalizados -->
<script src="../assets/js/register.js"></script>


</body>
</html>