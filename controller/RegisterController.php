<?php
require_once '../database/conn.php';
require_once './funciones/funciones.php';

// Definición de la función isAnyFieldEmpty
function isAnyFieldEmpty($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true; // Retorna true si encuentra al menos un campo vacío
        }
    }
    return false; // Retorna false si todos los campos están llenos
}

$database = new Database();
$conn = $database->conectar();

// Configuración de la zona horaria
date_default_timezone_set('America/Bogota');

function registerUser($conn, $documento, $id_tp_docu, $nombre, $apellido, $contrasena, $correo, $id_forma, $ficha, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre) {
    // Sanitiza la entrada
    $documento = filter_var($documento, FILTER_SANITIZE_STRING);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

    // Comprueba si la contraseña no es nula o vacía
    if (!empty($contrasena)) {
        // Hash de la contraseña
        $user_password = password_hash($contrasena, PASSWORD_DEFAULT);

        if ($user_password === false) {
            // Error al generar el hash de la contraseña
            return false;
        }

        // Prepara la consulta SQL usando sentencias preparadas
        $query = "INSERT INTO usuario (documento, id_tp_docu, nombre, apellido, contrasena ,correo, id_forma, ficha, codigo_barras, fecha_registro, terminos, id_rol, id_esta_usu, nit_empre ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Ejecuta la consulta
        if ($stmt->execute([$documento, $id_tp_docu, $nombre, $apellido, $user_password, $correo, $id_forma, $ficha, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre])) {
            return true; // Registro exitoso
        } else {
            // Registra el error en un archivo de registro
            error_log("Error al registrar el usuario: " . $stmt->errorInfo()[2]);
            return false; // Error al registrar el usuario
        }
    } else {
        return false; // Contraseña nula o vacía, no se puede registrar
    }
}

function showErrorAndRedirect($message, $location) {
    echo "<script>alert('$message');</script>";
    echo "<script>window.location = '$location';</script>";
}

function checkExistingUser($conn, $documento, $nombre) {
    // Sanitiza la entrada
    $documento = filter_var($documento, FILTER_SANITIZE_STRING);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);

    // Prepara la consulta SQL usando sentencias preparadas con PDO
    $query = "SELECT COUNT(*) as count FROM usuario WHERE documento = :documento OR nombre = :nombre";
    $stmt = $conn->prepare($query);

    // Bind de los parámetros
    $stmt->bindParam(':documento', $documento);
    $stmt->bindParam(':nombre', $nombre);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene el resultado
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si count es mayor que 0, significa que el usuario ya existe
    return $result['count'] > 0;
}

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    // Obtener datos del formulario
    $documento = $_POST['documento'];
    $id_tp_docu = $_POST['id_tp_docu'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];
    $id_forma = $_POST['id_forma'];
    $ficha = $_POST['ficha'];
    $codigo_barras = $_POST['codigo_barras'];
    $terminos = isset($_POST['terminos']) ? 1 : 0;
    $id_esta_usu = $_POST['id_esta_usu'];
    $id_rol = $_POST['id_rol'];
    $nit_empre = $_POST['nit_empre'];

    // Obtener la fecha actual
    $fecha_registro = date("Y-m-d H:i:s");

    // CONSULTA SQL PARA VERIFICAR SI EL USUARIO YA EXISTE EN LA BASE DE DATOS
    $userExists = checkExistingUser($conn, $documento, $nombre);

    // Verificar si hay campos vacíos
    if (isAnyFieldEmpty([$documento, $id_tp_docu, $nombre, $apellido ,$contrasena, $correo, $id_forma, $ficha, $codigo_barras, $fecha_registro, $terminos, $id_esta_usu, $id_rol, $nit_empre])) {
        // CONDICIONAL DEPENDIENDO SI EXISTEN ALGUN CAMPO VACÍO EN EL FORMULARIO DE LA INTERFAZ
        showErrorAndRedirect("Existen campos vacíos en el formulario.", "../auth/registro.php");
    } else {
        // Validaciones adicionales en el lado del servidor
        // ... (tus validaciones adicionales)

        // Registrar el usuario en la base de datos
        $userRegistered = registerUser($conn, $documento, $id_tp_docu, $nombre, $apellido, $contrasena, $correo, $id_forma, $ficha, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre);

        // Verificar si el registro fue exitoso
        if ($userRegistered) {
            echo '<script>alert("Éxito: Registro exitoso. Gracias por registrarte, puedes iniciar sesión.");</script>';
            echo '<script>window.location= "../auth/inicio_sesion.php";</script>';
        } else {
            showErrorAndRedirect("Error al registrar el usuario.", "../auth/registro.php");
        }
    }
}
?>
