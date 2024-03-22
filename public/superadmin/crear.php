<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();

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

$empresa = $conn->prepare("SELECT nit_empre, nom_empre FROM empresa WHERE nit_empre > 1");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formreg") {
    // Obtener datos del formulario
    $nit_empre = $_POST["nit_empre"];
    $licencia = uniqid();

    $fecha_ini = date('Y-m-d H:i:s');

    $fecha_fin = date('Y-m-d H:i:s', strtotime('+1 year'));

    $validar_nit = $conn->prepare("SELECT * FROM licencia WHERE nit_empre = ?");
    $validar_nit->execute([$nit_empre]);
    

    if ($nit_empre == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="crear.php"</script>';
    } 
    else {
      $insertsql = $conn->prepare("INSERT INTO licencia (licencia, esta_licen, fecha_ini, fecha_fin, nit_empre) VALUES (?, 'activo', ?, ?, ?)");
      $insertsql->execute([$licencia, $fecha_ini, $fecha_fin, $nit_empre]); // Solo se pasan $licencia y $nit_empre
      echo '<script>alert("Registro exitoso");</script>';
      echo '<script>window.location = "licencia.php";</script>';


    }
}
?>

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
  <title>Asignar Licencia</title>


  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Estilos para el formulario de inicio de sesión y registro */
        .registro_container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .registro_form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 100%;
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

        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
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
</head>


<body>
  <div class="registro_container">
      <form method="post" class="registro_form">
        <div class="form-group">
            <label for="empresa">Empresa:</label>
            <select class="form-control" id="nit" name="nit_empre" required>
                <option value="" disabled selected>Selecciona la empresa</option> <!-- Placeholder -->
                <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo $empresa['nit_empre']; ?>"><?php echo $empresa['nom_empre']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <input type="hidden" name="MM_insert" value="formreg">
            <button type="submit">Asignar</button>
        </div>
    </form>
  </div>
</body>
<br><br><br><br><br>
<section class="container-fluid footer_section" >
<p>
        Licencia de Software 
        <a href=""> Centro de Licenciamiento</a>
        </p>
</section>

</html>
