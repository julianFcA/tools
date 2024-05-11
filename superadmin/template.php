<?php
require_once '../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');


// Cerrar sesión
if (isset($_POST['btncerrar'])) {
  session_destroy();
  header("Location:../index.php");
  exit();
}

// // Verifica si hay una marca de tiempo de última actividad
// if (isset($_SESSION['last_activity'])) {
//   // Obtiene la diferencia de tiempo en segundos
//   $inactive = 300; // 5 minutos en segundos
//   $session_life = time() - $_SESSION['last_activity'];

//   // Si ha pasado el tiempo de inactividad, cierra la sesión
//   if ($session_life > $inactive) {
//     session_unset();     // Elimina todas las variables de sesión
//     session_destroy();   // Finaliza la sesión actual
//     header("Location: ../index.php"); // Redirige a la página de inicio de sesión
//     exit();
//   }
// }

// // Actualiza la marca de tiempo de última actividad
// $_SESSION['last_activity'] = time();

?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <title>Index | Superadministrador</title>
  <link rel="icon" href="./../images/licencia.png">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="./css/style.css" rel="stylesheet" />
  <link href="./css/estilos.css" rel="stylesheet" />

  <!-- responsive style -->
  <link href="/.css/responsive.css" rel="stylesheet" />


  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"></script>


</head>

<!-- <div class="modal" id="modal">
    <div class="modal-content">
        <span id="close" class="close">&times;</span>
        <h2>Ingrese su Contraseña de Confirmación:</h2>
        <input type="password" id="passwordInput" placeholder="Contraseña">
        <button onclick="validarCodigo()">Aceptar</button>
    </div>
</div> -->
<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="./index.php">
            <span>
              Licenciamiento
            </span>
          </a>
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item ">
                  <a class="nav-link" href="./index.php"> Actividad de Empresas</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="./registro_empre.php"> Registrar Empresa<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./crear.php"> Asignar y Activar licencia</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./licencia.php"> Licencias </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./registro_admin.php"> Registro de Administrador </a>
                </li>
                <form method="POST" action="">
                  <span class="ms-2">
                    <input class="btn btn-outline-danger my-2 my-sm-0" type="submit" value="Cerrar sesion" id="btn_quote" name="btncerrar" />
                  </span>
                </form>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
</body>

<section class="container-fluid footer_section">
  <p>
    Licencia de Software
    <a href=""> Centro de Licenciamiento</a>
  </p>
</section>

<!-- Bootstrap JS y otros scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Your existing scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery-nice-select@1.1.0/dist/jquery.nice-select.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>



<!-- Tus scripts personalizados -->
<script src="../assets/js/register.js"></script>
<script src="./../js/valida.js"></script>

<script src="./../node_modules/crypto-js.js"></script>


</html>