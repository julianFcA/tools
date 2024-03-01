<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();

$empresa = $conn->prepare("SELECT * FROM empresa");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nit_empre = isset($_POST['nit_empre']) ? $_POST['nit_empre'] : "";
    $nom_empre = isset($_POST['nom_empre']) ? $_POST['nom_empre'] : "";
    $direcc_empre = isset($_POST['direcc_empre']) ? $_POST['direcc_empre'] : "";
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
    $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
    
    
    if ($nit_empre == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="crear.php"</script>';
    } 
    else {
        $insertsql = $conn->prepare("INSERT INTO empresa ( nit_empre, nom_empre, direcc_empre, telefono, correo) VALUES (?, ?, ?, ?, ?)");
        $insertsql->execute([$nit_empre, $nom_empre, $direcc_empre, $telefono, $correo]);
        echo '<script>alert ("Registro exitoso");</script>';
        echo '<script> window.location= "licencia.php"</script>';

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <div class="form-group">
            <h1>Registro de Empresa</h1>
            <div class="form-group">
                    <label >Nit de Empresa</label>
                    <input type="varchar" placeholder="Ingrese Nit de Empresa" class="form-control" name="nit_empre" title="Debe ser de 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength=" 9 a 10" required>
                </div>

                <div class="form-group">
                    <label >Nombre de Empresa</label>
                    <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" name="nom_empre" title="Debe ser de 15 letras" required oninput="validarLetras(this)" minlength="6" maxlength="12">
                </div>

                <div class="form-group">
                    <label >Direeción de Empresa</label>
                    <input type="varchar" placeholder="Ingrese Direccion de Empresa" class="form-control" name="direcc_empre" title="Debe ser de 30 letras" required oninput="validarLetras(this)" minlength="6" maxlength="30">
                </div> 

                <div class="form-group">
                    <label > Telefono de Empresa</label>
                    <input type="number" placeholder="Ingrese Telefono de Empresa" class="form-control" name="telefono" required onkeyup="espacios(this)" minlength="8" maxlength="12">
                </div>

                <div class="form-group">
                    <label > Correo de Empresa</label>
                    <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" name="correo" required onkeyup="espacios(this)" minlength="6" maxlength="25">
                </div>
            <input type="hidden" name="MM_insert" value="formreg">
            <button type="submit">registrar</button>
        </div>
    </form>


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
