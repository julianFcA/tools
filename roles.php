<?php
require_once './database/conn.php';
$database = new Database();
$conn = $database->conectar();

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

  <title>TOOLS</title>

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
            height: 1050px;
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

        .icon-img {
            width: 200px; /* Ajusta el tamaño de acuerdo a tus preferencias */
            height: auto; /* Mantiene la proporción original */
            margin-right: 5px; /* Espaciado a la derecha del icono */
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
          <a class="navbar-brand" href="./index.html">
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
                  <a class="nav-link" href="./index.html#nosotros"> Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./index.html#servicios"> Servicios </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./index.html#usuarios"> Usuarios </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./index.html#recomendacion"> Recomendación </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./auth/inicio_sesion.php">Iniciar Sesion</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./roles.php">Registro</a>
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
    <div class="botones-container d-flex justify-content-center align-items-center">
        <div class="redirecciones mr-2">
            <a href="./auth/registro_instru.php" class="btn btn-primary">
                <img src="./images/instructor.png" alt="Icono Instructor" class="icon-img"> Registro Instructor
            </a>
        </div>
        <div class="redirecciones ml-2">
            <a href="./auth/registro.php" class="btn btn-primary">
                <img src="./images/aprendiz.png" alt="Icono Aprendiz" class="icon-img"> Registro Aprendiz
            </a>
        </div>
    </div>


    <br>
    <br>
    
    <!-- Bootstrap JS y Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                      
    <!--========================================
       Mis Scripts
    ==========================================-->
    <script src="../assets/js/register.js"></script>


    <script>

    document.addEventListener('DOMContentLoaded', function () {
        // Obtén el formulario
        var form = document.forms['formRegister'];

        // Agrega un evento de escucha al formulario
        form.addEventListener('submit', function (event) {
            // Validaciones adicionales
            if (!validateForm()) {
                event.preventDefault(); // Evita que el formulario se envíe si hay errores
            }
        });

        function validateForm() {
            var documento = form['documento'].value;
            var nombre = form['nombre'].value;
            var correo = form['correo'].value;
            var contrasena = form['contrasena'].value;

            // Aplica las funciones de validación específicas
            mayuscula(form['nombre']); // Convierte a mayúsculas el nombre
            espacios(form['documento']); // Elimina espacios en el documento

            // Realiza tus validaciones aquí y muestra mensajes de error si es necesario

            // Ejemplo de validación para el documento
            if (documento.length !== 10 || isNaN(documento)) {
                showError('Documento debe tener 10 dígitos numéricos');
                return false;
            }

            // Ejemplo de validación para el nombre
            if (nombre.length < 6 || nombre.length > 12) {
                showError('Nombre debe tener entre 6 y 12 caracteres');
                return false;
            }

            // Ejemplo de validación para el correo
            if (!validateEmail(correo)) {
                showError('Correo electrónico no válido');
                return false;
            }

            // Más validaciones según sea necesario...

            return true; // Si todas las validaciones pasan, retorna true
        }
        function validarLetras(input) {
            // Obtener el valor actual del campo
            var valor = input.value;

            // Eliminar caracteres no alfabéticos
            var letras = valor.replace(/[^a-zA-Z]/g, '');

            // Actualizar el valor del campo con solo letras
            input.value = letras;
        }

        function showError(message) {
            var errorText = form.querySelector('.error-text');
            errorText.textContent = message;
        }

        function validateEmail(email) {
            // Utiliza una expresión regular para validar el formato del correo electrónico
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Función que permite poner el texto en mayúscula
        function mayuscula(e) {
            e.value = e.value.toUpperCase();
        }

        // Función que no permite ingresar espacios
        function espacios(e) {
            e.value = e.value.replace(/ /g, '');
        }

        // Función de JavaScript que permite ingresar solo el número de dígitos requeridos
        function maxlengthNumber(obj) {
            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el número de dígitos requeridos");
            }
        }

        // Función de JavaScript que permite ingresar solo números en el formulario asignado
        function multiplenumber(e) {
            key = e.keyCode || e.which;
            teclado = String.fromCharCode(key).toLowerCase();
            numeros = "1234567890";
            especiales = "8-37-38-46-164-46";
            teclado_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial = true;
                    alert("Debe ingresar solo números en el formulario");
                    break;
                }
            }

            if (numeros.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
                alert("Debe ingresar solo números en el formulario");
            }
        }

        // Función de JavaScript que permite ingresar solo letras, números y guiones bajos para la contraseña
        function validarPassword(event) {
            var key = event.keyCode || event.which;
            var char = String.fromCharCode(key);
            var regex = /[0-9a-zA-Z_]/;

            if (!regex.test(char)) {
                event.preventDefault();
                return false;
            }
        }
    });


    function openOverlayTerminos() {
        document.getElementById('overlay-terminos').style.display = 'flex';
    }

    function closeOverlayTerminos() {
        document.getElementById('overlay-terminos').style.display = 'none';
    }

    // Agrega un evento de cambio al checkbox dentro de la ventana de términos y condiciones
    document.getElementById('checkboxTerminos').addEventListener('change', function () {
        // Si el checkbox está marcado, cierra la ventana de términos y condiciones
        if (this.checked) {
            closeOverlayTerminos();
        }
    });

</script>
<br>
<br>
<br>
<br>
<section class="container-fluid footer_section">
    <p>
    Sena. Ibagué - Tolima 
    <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
    </p>
</section>
</body>

</html>