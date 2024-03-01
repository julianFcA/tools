<?php
require_once '../database/conn.php';
$database = new Database();
$conn = $database->conectar();

// $consulta2 = $conn->prepare("SELECT * FROM genero");
// $consulta2->execute();
// $consulll=$consulta2->fetch();

$consulta4 = $conn->prepare("SELECT * FROM rol");
$consulta4->execute();
$consullll=$consulta4->fetch();

$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll=$consulta5->fetch();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TOOLS - Iniciar Sesión</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../css/styles.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

  <style>
    /* Agrega estos estilos al archivo css/style.css */

    body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            padding-bottom: 40px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
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

        .btn {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: orange;
        }

    /* Estilos para el formulario de inicio de sesión y registro */
    .login_container,
    .registro_container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 73vh;
      background: url('images/img_login.jpg') center/cover no-repeat; /* Agregado */
    }

    .login_form,
    .registro_form {
      background-color: rgba(255, 255, 255, 0.8); /* Modificado para hacerlo semi-transparente */
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 500px; /* Modificado para un ancho fijo */
      height: 400px;

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
                    <a class="nav-link" href="./registro.php">Registro</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>

<body>

    <div class="login_container">
        <form class="login_form">
            <br>
            <h2>Error<br> Iniciar Sesión</h2>
            <div class="form-group">
                  <!-- Tabs -->

                  <!-- Formulario -->
                <form action="../controller/AuthController.php" autocomplete="off" method="POST" id="formLogin" class="formulario active">

                    <br>

                    <input type="number" placeholder="Ingrese documento" class="input-text" name="documento" title="Debe tener de 8 a 10 digitos" required onkeyup="espacios(this)" minlength="8" maxlength="11" required autocomplete="off">

                    <div class="grupo-input">
                        <input type="password" placeholder="Ingresa tu Contraseña" name="contrasena" class="input-text clave" title="Debe tener de 8 a 10 digitos" required onkeyup="espacios(this)" minlength="8" maxlength="20">
                        
                    </div>
                    <br>
                    <input class="btn" type="submit" name="iniciarSesion" value="Iniciar Sesión">

                    <div class="redirecciones">
                        <a href="../index.php" class="link return">Regresar</a>
                    </div>
                    <div class="botones-container">
                        <div class="redirecciones">
                            <a href="./registro.php" class="link return">Registro</a>
                        </div>
                        <div class="redirecciones">
                            <a href="../correo.php" class="link return">¿Olvido su contraseña?</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

      <!-- Bootstrap JS y Popper.js -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




    <!--========================================
       Mis Scripts
    ==========================================-->
    <script src="../assets/js/register.js"></script>


    <script>
        // FUNCION QUE PERMITE PONER EL TEXT EN MAYUSCULA
        function mayuscula(e) {
            e.value = e.value.toUpperCase();
        }

        // FUNCION QUE PERMITE PONER EL TEXT EN MINUSCULA
        function minuscula(e) {
            e.value = e.value.toLowerCase();
        }

        // FUNCION QUE NO PERMITE INGRESAR ESPACIOS
        function espacios(e) {
            e.value = e.value.replace(/ /g, '');
        }

        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO EL NUMERO VALORES REQUERIDOS DE ACUERDO A LA LONGITUD MAXLENGTH DEL CAMPO -->
        function maxlengthNumber(obj) {

            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el numeros de digitos requeridos");
            }
        }

        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO NUMEROS EN EL FORMULARIO ASIGNADO -->
        function multiplenumber(e) {
            key = e.keyCode || e.which;

            teclado = String.fromCharCode(key).toLowerCase();

            numeros = "1234567890";

            especiales = "8-37-38-46-164-46";

            teclado_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial = true;
                    alert("Debe ingresar solo numeros en el formulario");
                    break;
                }
            }

            if (numeros.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
                alert("Debe ingresar solo numeros en el formulario ");
            }
        }


        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO LETRAS. NUMEROS Y GUIONES BAJOS PARA LA CONTRASEÑA   -->
        function validarPassword(event) {
            // Obtenemos la tecla que se ha presionado
            var key = event.keyCode || event.which;

            // Convertimos el código de la tecla a su respectivo carácter
            var char = String.fromCharCode(key);

            // Definimos una expresión regular que solo permita números, letras y guiones bajos
            var regex = /[0-9a-zA-Z_]/;

            // Validamos si el carácter ingresado cumple con la expresión regular
            if (!regex.test(char)) {
                // Si no cumple, cancelamos el evento de ingreso de datos
                event.preventDefault();
                return false;
            }
        }
    </script>

  <section class="container-fluid footer_section">
      <p>
      Sena. Ibagué - Tolima 
      <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
      </p>
  </section>

</body>

</html>
