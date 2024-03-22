<?php
session_start();
require_once("../../database/conn.php");
$db = new database();
$conn = $db->conectar();

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

$columnas = [];

if (isset($_GET['nit_empre'])) {
    $consulta_tipo = $conn->prepare("SELECT * FROM empresa WHERE nit_empre = :nit_empre");
    $consulta_tipo->bindParam(':nit_empre', $_GET['nit_empre']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch();
}

if (isset($_POST["MM_insert"]) && ($_POST["MM_insert"] == "formreg")) {
    $nit_empre = $_POST['nit_empre'];
    $nom_empre = $_POST['nom_empre'];
    $direcc_empre = $_POST['direcc_empre'];
    $telefono = $_POST['telefono'];
    // Imagen debe manejarse como archivo, no como texto plano
    $correo_empre = $_POST['correo_empre'];

    // Validación de campos vacíos
    if (empty($nit_empre) || empty($non_empre) || empty($direcc_empre) || empty($telefono) || empty($correo_empre)) {
        echo '<script>alert("Existen datos vacíos");</script>';
        echo '<script>window.location="actu_licen.php"</script>';
    } else {
        // Verificar si se cargó un nuevo archivo de imagen
        // Verificar si se ha subido una nueva imagen

        // Actualización de registros
        $actu_update = $conn->prepare("UPDATE empresa SET nit_empre = :nit_empre, nom_empre = :nom_empre, direcc_empre = :direcc_empre, telefono = :telefono, correo_empre = :correo_empre WHERE nit_empre = :nit_empre");

        $actu_update->bindParam(':nit_empre', $nit_empre);
        $actu_update->bindParam(':nom_empre', $nom_empre);
        $actu_update->bindParam(':direcc_empre', $direcc_empre);
        $actu_update->bindParam(':telefono', $telefono);
        $actu_update->bindParam(':correo_empre', $correo_empre);

        $actu_update->execute();
        // $actu = $actu_update->fetch();

        echo '<script>alert("Actualización Exitosa ");</script>';
        echo '<script>window.location="./index.php"</script>';
        exit;
    }
}
?>


<!-- Resto del código HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
<title>Actualizar | <?php echo $_SESSION['nombre'] ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<!DOCTYPE html>
    <html>

    <!DOCTYPE html>
    <html>

    <head>
    <!-- Basic -->
    <title>Actualizar Datos de Empresa <?php echo $_SESSION['nombre'] ?></title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .registro_form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            height: 100%; /* Ajusta la altura según tus necesidades */
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
    
    <div class="registro_container">
            <!-- Formulario de Registro -->
        <form class="registro_form" action="registro_empre.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">
                
            <h1>Registro de Empresa</h1>
            <div class="form-group">
                    <label >Nit de Empresa</label>
                    <input type="varchar" placeholder="Ingrese Nit de Empresa" class="form-control"
                    value="<?php echo $columnas['nit_empre']?>" name="nit_empre" title="Debe ser de 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength=" 9 a 10" required readonly>
                </div>

                <div class="form-group">
                    <label >Nombre de Empresa</label>
                    <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control"value="<?php echo $columnas['nom_empre']?>" name="nom_empre" title="Debe ser de 15 letras" required oninput="validarLetras(this)" minlength="6" maxlength="12">
                </div>

                <div class="form-group">
                    <label >Direeción de Empresa</label>
                    <input type="varchar" placeholder="Ingrese Direccion de Empresa" class="form-control" value="<?php echo $columnas['direcc_empre']?>" name="direcc_empre" title="Debe ser de 30 letras" required oninput="validarLetras(this)" minlength="6" maxlength="30">
                </div> 

                <div class="form-group">
                    <label > Telefono de Empresa</label>
                    <input type="number" placeholder="Ingrese Telefono de Empresa" class="form-control" value="<?php echo $columnas['telefono']?>" name="telefono" required onkeyup="espacios(this)" minlength="8" maxlength="12">
                </div>

                <div class="form-group">
                    <label > Correo de Empresa</label>
                    <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" value="<?php echo $columnas['correo_empre']?>" name="correo_empre" required onkeyup="espacios(this)" minlength="6" maxlength="25">
                </div>
                <input type="submit" name="MM_register" value="Registro" class="btn-primary"></input>
                <input type="hidden" name="MM_register" value="formRegister">
        </form>
    </div>
    <br>
    <section class="container-fluid footer_section">
    <p>
        Licencia de Software 
        <a href=""> Centro de Licenciamiento</a>
    </p>
    </section>

        <!-- Bootstrap JS y otros scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Tus scripts personalizados -->
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
                function espacios(input) {
                    // Reemplazar los espacios en blanco
                    var texto = input.value;
                    texto = texto.replace(/\s/g, '');
                    input.value = texto;
                }

                function showError(message) {
                    // Muestra un mensaje de error en el contenedor designado
                    var errorContainer = document.querySelector('.error-text');
                    errorContainer.textContent = message;
                }
                // Agrega más funciones de validación según sea necesario

                function validateEmail(email) {
                    // Expresión regular para validar un correo electrónico
                    var regex =
                        /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                    // Prueba la validez del correo electrónico
                    return regex.test(email);
                }

                function mayuscula(input) {
                    // Convierte el valor a mayúsculas
                    input.value = input.value.toUpperCase();
                }
            });

            function openOverlayTerminos() {
                document.getElementById('overlay-terminos').style.display = 'flex';
            }

            function closeOverlayTerminos() {
                document.getElementById('overlay-terminos').style.display = 'none';
            }
        </script>

</body>
</html>

