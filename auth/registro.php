<?php
require_once '../database/conn.php';

$database = new Database();
$conn = $database->conectar();
date_default_timezone_set('America/Bogota');

// Consulta 1
$consulta2 = $conn->prepare("SELECT nom_tp_docu, id_tp_docu FROM tp_docu WHERE id_tp_docu >= 1 ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$statement = $conn->prepare('SELECT * FROM ficha INNER JOIN formacion ON formacion.id_forma = ficha.id_forma AND formacion.id_forma > 1 INNER JOIN jornada ON jornada.id_jornada = formacion.id_jornada AND jornada.id_jornada > 1  WHERE ficha.id_forma = ?');

$cadena_formacion = "<label> Formacion</label><br>
<select id='id_forma' name='id_forma'>";

$cadena_jornada = "<label> Jornada</label><br>
<select id='id_jornada' name='id_jornada'>";

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $cadena_formacion .= "<option value=" . $row['ficha'] . ">" . $row['ficha'] . "</option>";
    $cadena_jornada .= "<option value=" . $row['id_jornada'] . ">" . $row['tp_jornada'] . "</option>";
}

$cadena_formacion .= "</select>"; // Cerrar la etiqueta select
$cadena_jornada .= "</select>"; // Cerrar la etiqueta select

// echo $cadena_formacion;
// echo $cadena_jornada;


// Consulta 3
$consulta4 = $conn->prepare("SELECT nom_rol, id_rol FROM rol WHERE id_rol >= 4 ");
$consulta4->execute();
$consullll = $consulta4->fetchAll(PDO::FETCH_ASSOC);

// Consulta 4
$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll = $consulta5->fetchAll(PDO::FETCH_ASSOC);

// Consulta 5
$consulta6 = $conn->prepare("SELECT nom_empre, nit_empre FROM empresa WHERE nit_empre > 0 ");
$consulta6->execute();
$consullllll = $consulta6->fetchAll(PDO::FETCH_ASSOC);

$consulta7 = $conn->prepare("SELECT terminos FROM usuario ");
$consulta7->execute();
$consult = $consulta7->fetch(PDO::FETCH_ASSOC);

$consulta8 = $conn->prepare("SELECT tp_jornada, id_jornada FROM jornada WHERE id_jornada > 1");
$consulta8->execute();
$cons = $consulta8->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

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
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet" />
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
            height: 1260px;
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

    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="../index.php">
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
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <div class="registro_container">
            <!-- Formulario de Registro -->
            <form class="registro_form" action="../controller/RegisterController.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">
                <h1>REGISTRO </h1>

                <!-- Contenedor para mostrar errores -->
                <div class="error-text"></div>

                <!-- Campos para registrar un nuevo usuario -->

                <div class="form-group">
                    <label >Tipo de Documento</label>
                    <select class="form-control" name="id_tp_docu" required>
                        <?php foreach ($consull as $row): ?>
                            <option value="<?php echo $row['id_tp_docu']; ?>"><?php echo $row['nom_tp_docu']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label >Documento</label>
                    <input type="number" placeholder="Ingrese Documento" class="form-control" name="documento" title="Debe ser de 10 dígitos" required minlength="7" maxlength="10">
                </div>

                <div class="form-group">
                    <label >Nombre</label>
                    <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" title="Debe ser de 15 letras" required minlength="6" maxlength="12">
                </div>

                <div class="form-group">
                    <label >Apellido</label>
                    <input type="text" placeholder="Ingrese apellido" class="form-control" name="apellido" title="Debe ser de 15 letras" required minlength="6" maxlength="12">
                </div> 

                <div class="form-group">
                    <label > Correo</label>
                    <input type="email" placeholder="Ingrese correo" class="form-control" name="correo" required minlength="6" maxlength="25">
                </div>

                <div class="form-group">
                    <label >Rol</label>
                    <select class="form-control" name="id_rol" required >
                        <?php foreach ($consullll as $row): ?>
                            <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nom_rol']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ficha</label>
                    <select class="form-control" name="ficha" id="ficha" required onchange="recargarLista()">
                        <?php
                        // Consulta para obtener las opciones de fichas
                        $statement = $conn->prepare("SELECT ficha FROM ficha WHERE ficha > 0");
                        $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $row['ficha'] . ">" . $row['ficha'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group" id="id_forma">
                    <label>Formación</label>
                    <select name="id_forma" id="id_forma" class="form-control" required>
                        <!-- Las opciones de formación se cargarán dinámicamente mediante JavaScript -->
                    </select>
                </div>

                <div class="form-group" id="id_jornada">
                    <label>Jornada</label>
                    <select name="id_jornada" id="id_jornada" class="form-control" required>
                        <!-- Las opciones de jornada se cargarán dinámicamente mediante JavaScript -->
                    </select>
                </div>


                <input type="hidden" placeholder="Estado" readonly class="form-control" value="1" name="id_esta_usu">

                <div class="group-material">
                    <label>Fecha de Registro</label>
                    <input type="text" name="fecha_registro" class="material-control tooltips-general" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

                <div class="form-group">
                    <label >Empresa</label>
                    <select class="form-control" name="nit_empre" required>
                        <?php foreach ($consullllll as $row): ?>
                            <option value="<?php echo $row['nit_empre']; ?>"><?php echo $row['nom_empre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contrase"> Contraseña</label>
                    <div class="input-group">
                        <input type="password" placeholder="Contraseña" name="contrasena" class="form-control clave" title="Debe tener de 6 a 12 dígitos" required minlength="6" maxlength="12">
                    </div>
                </div>

                <div class="form-group">
                    <div class="overlay-terminos" id="overlay-terminos">
                        <div class="container-terminos">
                            <span class="close-btn-terminos" onclick="closeOverlayTerminos()">X</span>
                            <h1>Términos y Condiciones</h1>
                            <p>Estos son los términos y condiciones para el uso de la aplicación de préstamos de herramientas:</p>
                            <ol>
                                <li><strong>Uso Aceptable:</strong> Al utilizar esta aplicación, aceptas utilizarla de manera ética y legal. No debes usar la aplicación con fines ilegales o dañinos.</li>
                                <li><strong>Registro:</strong> Para acceder a la funcionalidad completa de la aplicación, es posible que debas registrarte proporcionando información precisa y actualizada.</li>
                                <li><strong>Préstamos:</strong> El préstamo de herramientas está sujeto a disponibilidad y a las reglas establecidas por la aplicación. Asegúrate de cumplir con las fechas y condiciones acordadas.</li>
                                <li><strong>Responsabilidad:</strong> La aplicación y sus desarrolladores no se hacen responsables de cualquier daño o pérdida resultante del uso de la aplicación o de las herramientas prestadas.</li>
                            </ol>
                            <p>Al utilizar esta aplicación, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo con estos términos, por favor, no utilices la aplicación.</p>
                            <input type="checkbox" class="form-control" id="checkboxTerminos" name="terminos" <?php echo ($consult && $consult['terminos'] == '1') ? 'checked' : ''; ?> required>
                        </div>
                    </div>
                        <br>
                        <button type="button" onclick="openOverlayTerminos()" >Acepto Términos y Condiciones</button>
                    </div>

                <input type="submit" name="MM_register" value="Registrarme" class="btn"></input>
                <input type="hidden" name="MM_register" value="formRegister">

                <div class="botones-container">
                    <div class="redirecciones">
                        <a href="./../index.php" class="link return">Regresar</a>
                    </div>
                    <!-- <div class="redirecciones">
                        <a href="./inicio_sesion.php" class="link return">Inicio de Sesion</a>
                    </div> -->
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <section class="container-fluid footer_section">
            <p>
            Sena. Ibagué - Tolima 
            <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
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
            });

            function openOverlayTerminos() {
                document.getElementById('overlay-terminos').style.display = 'flex';
            }

            function closeOverlayTerminos() {
                document.getElementById('overlay-terminos').style.display = 'none';
            }
        </script>



<script type="text/javascript">
    $(formulario).ready(function () {
        // Cuando el documento esté listo, establecer el valor de la ficha en 0 y cargar la lista
        $('#ficha').val(0);
        recargarLista();
    })

    function recargarLista() {
        // Obtener el valor seleccionado de la ficha
        var fichaSeleccionada = $('#ficha').val();

        // Hacer una llamada AJAX para obtener las opciones de formación y jornada correspondientes a la ficha seleccionada
        $.ajax({
            type: "POST",
            url: "../controller/RegisterController.php",
            data:{"ficha": $('#ficha').val()},
            success: function (r) {
                // Actualizar el contenido de los select de formación y jornada con los datos devueltos por la llamada AJAX
                $('#id_forma').html(r);
                $('#id_jornada').html(r);
            }
        });
    }
</script>



</body>

</html>
