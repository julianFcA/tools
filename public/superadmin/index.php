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

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.licencia, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre, usuario.documento, usuario.correo, usuario.codigo_barras FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE empresa.nit_empre > 0 AND usuario.id_rol = 2 AND licencia != '65e5b3e7a66b7'
";

$result = $conn->query($query);

// Definir el número de resultados por página y la página actual
$porPagina = 20; // Puedes ajustar esto según tus necesidades
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$empieza = ($pagina - 1) * $porPagina;

// Inicializa la variable $resultado_pagina
$resultado_pagina = $result->fetchAll(PDO::FETCH_ASSOC);


?>
    <!DOCTYPE html>
    <html>

    <!DOCTYPE html>
    <html>

    <head>
    <!-- Basic -->
    <title>Index | <?php echo $_SESSION['nombre'] ?></title>
    <link rel="icon" href="./../../images/licencia.png">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />


    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="./css/responsive.css" rel="stylesheet" />
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
                    <li class="nav-item ">
                    <a class="nav-link" href="./crear.php"> Asignar y Activar licencia</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="./licencia.php"> Licencias </a>
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

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Licencia</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <div class="content-body container-table">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Actividad de Empresas| Estado de Licencia</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Tabla HTML para mostrar los resultados -->
                                <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nit Empresa</th>
                                            <th>Nombre de Empresa</th>
                                            <th>Direccion de Empresa</th>
                                            <th>Telefono de Empresa</th>
                                            <th>Correo de Empresa</th>
                                            <th>Nombre de Administrador</th>
                                            <th>Numero de Identificación</th>
                                            <th>Correo de Administrador</th>
                                            <th>Codigo de Barras de Administrador</th>
                                            <th>Numero de Licencia</th>
                                            <th>Fecha de Inicio de Licencia</th>
                                            <th>Fecha de Fin de Licencia</th>
                                            <th>Estado Actual</th>
                                            <th colspan="3">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultado_pagina as $entrada) { ?>
                                            <?php
                                            // Determinar la clase CSS y el estado del botón según el estado_servi
                                            $estadoClase = '';
                                            $color = '';
                                            $mensaje = '';
                                            $botonInactivo = '';
                                            $botonCancelar = '';
                                            $activo = '';

                                            $horaFinalizacionPasada = strtotime($entrada["fecha_fin"]) > strtotime("now");

                                            if ($entrada["esta_licen"] == 'inactivo' && $horaFinalizacionPasada) {
                                                $estadoClase = 'table-warning';
                                                $botonInactivo = 'disabled';
                                                $color = 'orange';
                                                $mensaje = 'Bloqueado';
        
                                                // Actualizar el estado en la base de datos
                                                // if ($horaFinalizacionPasada) 
                                                // {
                                                //     $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = :licencia");
                                                //     $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                                //     $updateEstado->execute();

                                                // } 
                                                // else {
                                                //     // Si la hora de finalización no ha pasado, pero el estado es 'inactivo', cambia a 'activo'
                                                //     $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'activo' WHERE licencia = :licencia");
                                                //     $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                                //     $updateEstado->execute();
                                                // }
        
                                                    // Actualiza las variables para reflejar el nuevo estado
                                                    $estadoClase = 'table-success';
                                                    $activo = 'activo';
                                                    $color = 'green';
                                                    $mensaje = 'Disponible';
                                                }

                                            if ($entrada["esta_licen"] == 'inactivo') {
                                                $estadoClase = '';
                                                $botonInactivo = 'disabled';
                                                $color = 'orange';
                                                $mensaje = 'Esta inactivo';
                                            } elseif ($entrada["esta_licen"] == 'cancelado') {
                                                $estadoClase = '';
                                                $botonCancelar = 'disabled';
                                                $color = 'red';
                                                $mensaje = 'Esta cancelado';
                                            } elseif ($entrada["esta_licen"] == 'activo') {
                                                $estadoClase = '';
                                                $activo = 'disabled';
                                                $color = 'green';
                                                $mensaje = 'activo';
                                            }
                                            ?>
                                            <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                <td><?= $entrada["nit_empre"] ?></td>
                                                <td><?= $entrada["nom_empre"] ?></td>
                                                <td><?= $entrada["direcc_empre"] ?></td>
                                                <td><?= $entrada["telefono"] ?></td>
                                                <td><?= $entrada["correo_empre"] ?></td>
                                                <td><?= $entrada["nombre"] ?></td>
                                                <td><?= $entrada["documento"] ?></td>
                                                <td><?= $entrada["correo"] ?></td>
                                                <td><img src="../../images/<?= $entrada["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barras"] ?></td>
                                                <td><?= $entrada["licencia"] ?></td>
                                                <td><?= $entrada["fecha_ini"] ?></td>
                                                <td><?= $entrada["fecha_fin"] ?></td>
                                                <td><?= $entrada["esta_licen"] ?></td>
                                                <!-- revisar bien este form -->
                                                <td>
                                                    <form method="GET" action="activar_licencia.php">
                                                        <input type="hidden" name="licencia" value="<?= $entrada["licencia"] ?>">
                                                        <button class="btn btn-success" type="submit" name="acti" <?= $activo ?>>Activar</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="GET" action="actu_licen.php">
                                                        <input type="hidden" name="nit_empre" value="<?= $entrada["nit_empre"] ?>">
                                                        <button class="btn btn-primary" type="submit" name="actu" >Actualizar Datos de Empresa</button>
                                                    </form>
                                                </td>
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
    <br><br><br>

        <section class="container-fluid footer_section">
        <p>
        Licencia de Software 
        <a href=""> Centro de Licenciamiento</a>
        </p>
    </section>
    </body>

    </html>