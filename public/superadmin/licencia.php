<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');


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

    $lista = $conn->prepare("SELECT * FROM licencia, empresa WHERE licencia.nit_empre = empresa.nit_empre AND esta_licen  AND empresa.nit_empre != '65e5b3e7a66b7' IN ('activo', 'inactivo')");

    $lista->execute();
    $listas = $lista->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <link rel="icon" href="./../../images/licencia.png">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Lista de Licencias</title>


  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
    <style>
  
        /* Agrega estos estilos al archivo css/style.css */

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            padding-bottom: 40px;
        
        }

        /* Estilos para el formulario de inicio de sesión y registro */
        .registro_container {
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('../images/') center/cover no-repeat; /* Agregado */
        }

        .registro_form {
            background-color: rgba(255, 255, 255, 0.8); /* Modificado para hacerlo semi-transparente */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px; /* Modificado para un ancho fijo */
            height: 950px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .overlay-terminos {
            background: rgba(255, 165, 0, 0.8); /* Naranja semi-transparente */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .container-terminos {
            width: 60%;
            background-color: #ffa500; /* Naranja */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .close-btn-terminos {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #fff; /* Texto en blanco */
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: orangered;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: orange;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

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
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
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
                  <a class="nav-link" href="./licencia.php"> Licencias   </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./registro_admin.php"> Registro de Administrador  </a>
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
    <br>
    <br>
    <br>
</head>
<body>

    <div class="content-body container-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Actividad de Empresas| Activación y Desactivación de Licencia</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Tabla HTML para mostrar los resultados -->
                            <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Licencia</th>
                                        <th>Nombre de Empresa</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Fin</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($listas as $lista) { ?>
                                            <?php
                                            // Determinar la clase CSS y el estado del botón según el estado_servi
                                            $estadoClase = '';
                                        $color = '';
                                        $mensaje = '';
                                        $botonInactivo = '';
                                        $botonCancelar = '';
                                        $activo = '';

                                        // Comprobar si la hora de finalización ha pasado
                                        $horaFinalizacionPasada = strtotime($lista["fecha_fin"]) > strtotime("now");

                                        // Si la licencia está inactiva y la hora de finalización ha pasado
                                        if ($lista["esta_licen"] == 'inactivo' && $horaFinalizacionPasada) {
                                            // Actualizar el estado de la licencia en la base de datos a 'inactivo'
                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = :licencia");
                                            $updateEstado->bindParam(':licencia', $lista["licencia"], PDO::PARAM_INT);
                                            $updateEstado->execute();

                                            // Actualizar las variables para reflejar el nuevo estado
                                            $estadoClase = 'table-warning';
                                            $botonInactivo = 'disabled';
                                            $color = 'orange';
                                            $mensaje = 'Bloqueado';
                                        } elseif ($lista["esta_licen"] == 'activo') {
                                            // Si la licencia está activa
                                            $estadoClase = 'table-success';
                                            $activo = 'disabled';
                                            $color = 'green';
                                            $mensaje = 'Disponible';
                                        } elseif ($lista["esta_licen"] == 'cancelado') {
                                            // Si la licencia está cancelada
                                            $estadoClase = '';
                                            $botonCancelar = 'disabled';
                                            $color = 'red';
                                            $mensaje = 'Cancelado';
                                        } elseif ($lista["esta_licen"] == 'inactivo') {
                                            // Si la licencia está inactiva pero la hora de finalización no ha pasado
                                            $color = 'orange';
                                            $mensaje = 'Inactivo';
                                        }
                                        else {
                                            // Si la hora de finalización no ha pasado, pero el estado es 'inactivo', cambia a 'activo'
                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'activo' WHERE licencia = :licencia");
                                            $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                            $updateEstado->execute();
                                        }


                                            ?>
                                            <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                            <td><?= $lista["licencia"] ?></td>
                                            <td><?= $lista["nom_empre"] ?></td>
                                            <td><?= $lista["fecha_ini"] ?></td>
                                            <td><?= $lista["fecha_fin"] ?></td>
                                            <td><?= $lista["esta_licen"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<section class="container-fluid footer_section">
    <p>
        Licencia de Software 
        <a href=""> Centro de Licenciamiento</a>
        </p>
</section>

    <!-- Botón de Cerrar Sesión -->
</body>
</html>
