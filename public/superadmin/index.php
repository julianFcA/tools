<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();

$consulta1 = $conn->prepare("SELECT terminos FROM usuario");
$consulta1->execute();
$consul = $consulta1->fetch(PDO::FETCH_ASSOC);

$consulta2 = $conn->prepare("SELECT nom_tp_docu FROM tp_docu WHERE id_tp_docu >= 1 ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = $conn->prepare("SELECT * FROM formacion");
$consulta3->execute();
$consulll=$consulta3->fetchAll(PDO::FETCH_ASSOC);

$consulta4 = $conn->prepare("SELECT nom_rol FROM rol WHERE id_rol >= 2 ");
$consulta4->execute();
$consullll=$consulta4->fetchAll(PDO::FETCH_ASSOC);

$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll=$consulta5->fetch();
?>


<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <link rel="icon" href="../images/icono.png">
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
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
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
          <a class="navbar-brand" href="../index.html">
            <span>
              Tools
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
                <li class="nav-item active">
                  <a class="nav-link" href="../index.html"> Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../index.html#nosotros"> Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../index.html#servicios"> Servicios </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../index.html#usuarios"> Usuarios </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../index.html#recomendacion"> Recomendación </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./inicio_sesion.php">Iniciar Sesion</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../roles.php">Registro</a>
                </li>
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
    <title>Activación de Licencia</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="activation-container">
        <form action="activar_licencia.php" method="post">
            <h2>Activación de Licencia</h2>

            <!-- Campo para ingresar la clave de licencia -->
            <div class="form-group">
                <label for="licencia">Clave de Licencia:</label>
                <input type="text" id="licencia" name="licencia" required>
            </div>

            <!-- Campo para ingresar el código de activación -->
            <div class="form-group">
                <label for="codigo_activacion">Código de Activación:</label>
                <input type="text" id="codigo_activacion" name="codigo_activacion" required>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit">Activar Licencia</button>
        </form>
    </div>



    <section class="container-fluid footer_section">
    <p>
    Sena. Ibagué - Tolima 
    <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
    </p>
</section>
</body>

</html>