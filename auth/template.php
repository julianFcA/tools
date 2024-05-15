<?php
require_once '../database/conn.php';
$database = new Database();
$conn = $database->conectar();
date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="../images/icono.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TOOLS</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

    <!-- Fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet" />
    <!-- Responsive style -->
    <link href="../css/responsive.css" rel="stylesheet" />
    <link href="../css/estilos.css" rel="stylesheet" />
</head>

<body>

    <div class="hero_area">
        <!-- Header section starts -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="../index.php">
                        <span>
                            Tools
                        </span>
                    </a>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
                            <ul class="navbar-nav  ">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../index.php"> Inicio <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.php#nosotros"> Sobre Nosotros</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.php#servicios"> Servicios </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.php#usuarios"> Usuarios </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.php#recomendacion"> Recomendación </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./inicio_sesion.php">Iniciar Sesión</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./registro.php">Registro</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Bootstrap JS y Popper.js -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.3.1.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <!-- Mis Scripts -->
        <!-- <script src="../assets/js/register.js"></script> -->
        <script src="./../js/auth.js"></script>

        <section class="container-fluid footer_section">
            <p>
                Sena. Ibagué - Tolima
                <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
            </p>
        </section>
    </div>
</body>

</html>
