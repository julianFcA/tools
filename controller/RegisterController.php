<?php
require_once '../database/conn.php';
require_once './funciones/funciones.php';

function isAnyFieldEmpty($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true;
        }
    }
    return false;
}

function handleSQLError($stmt, $message) {
    error_log("SQL Error: " . $stmt->errorInfo()[2]);
    showErrorAndRedirect($message, "../auth/registro.php");
}

$database = new Database();
$conn = $database->conectar();

date_default_timezone_set('America/Bogota');

function generateBarcode() {
    return uniqid();
}

function handleDatabaseError($e, $location) {
    error_log("Database Error: " . $e->getMessage());
    showErrorAndRedirect("Error en la base de datos.", $location);
}

function registerUser($conn, $documento, $id_tp_docu, $nombre, $apellido, $contrasena, $correo, $id_forma, $ficha, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre) {
    $documento = filter_var($documento, FILTER_SANITIZE_STRING);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

    if (!empty($contrasena)) {
        $user_password = password_hash($contrasena, PASSWORD_DEFAULT);

        if ($user_password === false) {
            return false;
        }

        $fecha_registro = date("Y-m-d H:i:s");

        $stmtCheckTypeDoc = $conn->prepare("SELECT COUNT(*) as count FROM tp_docu WHERE id_tp_docu = ?");
        $stmtCheckTypeDoc->bindParam(1, $id_tp_docu, PDO::PARAM_STR);
        $stmtCheckTypeDoc->execute();
        $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

        if ($resultCheckTypeDoc['count'] === 0) {
            return false;
        }

        $codigo_barras = generateBarcode();

        $query = "INSERT INTO usuario (documento, id_tp_docu, nombre, apellido, contrasena, correo, id_forma, ficha, codigo_barras, fecha_registro, terminos, id_rol, id_esta_usu, nit_empre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(1, $documento, PDO::PARAM_STR);
        $stmt->bindParam(2, $id_tp_docu, PDO::PARAM_STR);
        $stmt->bindParam(3, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(4, $apellido, PDO::PARAM_STR);
        $stmt->bindParam(5, $user_password, PDO::PARAM_STR);
        $stmt->bindParam(6, $correo, PDO::PARAM_STR);
        $stmt->bindParam(7, $id_forma, PDO::PARAM_STR);
        $stmt->bindParam(8, $ficha, PDO::PARAM_STR);
        $stmt->bindParam(9, $codigo_barras, PDO::PARAM_STR);
        $stmt->bindParam(10, $fecha_registro, PDO::PARAM_STR);
        $stmt->bindParam(11, $terminos, PDO::PARAM_INT);
        $stmt->bindParam(12, $id_rol, PDO::PARAM_STR);
        $stmt->bindParam(13, $id_esta_usu, PDO::PARAM_STR);
        $stmt->bindParam(14, $nit_empre, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error al registrar el usuario: " . $e->getMessage());
            return false;
        }
    } else {
        return false;
    }
}

function showErrorAndRedirect($message, $location) {
    echo "<script>alert('$message');</script>";
    echo "<script>window.location = '$location';</script>";
}

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $documento = isset($_POST['documento']) ? $_POST['documento'] : "";
    $id_tp_docu = isset($_POST['id_tp_docu']) ? $_POST['id_tp_docu'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";
    $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
    $id_forma = isset($_POST['id_forma']) ? $_POST['id_forma'] : "";
    $fecha_registro = isset($_POST['fecha_registro']) ? $_POST['fecha_registro'] : "";
    $ficha = isset($_POST['ficha']) ? $_POST['ficha'] : "";
    $terminos = isset($_POST['terminos']) ? 1 : 0;
    $id_esta_usu = isset($_POST['id_esta_usu']) ? $_POST['id_esta_usu'] : "";
    $id_rol = isset($_POST['id_rol']) ? $_POST['id_rol'] : "";
    $nit_empre = isset($_POST['nit_empre']) ? $_POST['nit_empre'] : "";

    $userRegistered = registerUser($conn, $documento, $id_tp_docu, $nombre, $apellido, $contrasena, $correo, $id_forma, $ficha,$fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre);

    if ($userRegistered) {
        showErrorAndRedirect("Registro exitoso. Gracias por registrarte", "../auth/inicio_sesion.php");
    } elseif (isAnyFieldEmpty([$documento, $id_tp_docu, $nombre, $apellido, $contrasena, $correo, $id_forma, $ficha, $fecha_registro ,$terminos, $id_esta_usu, $id_rol, $nit_empre])) {
        showErrorAndRedirect("Existen campos vacíos en el formulario.", "../auth/registro.php");
    } else {
        if (strlen($documento) !== 10 || !is_numeric($documento)) {
            showErrorAndRedirect("Documento debe tener 10 dígitos numéricos.", "../auth/registro.php");
        } elseif (strlen($nombre) < 6 || strlen($nombre) > 12) {
            showErrorAndRedirect("Nombre debe tener entre 6 y 12 caracteres.", "../auth/registro.php");
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            showErrorAndRedirect("Correo electrónico no válido.", "../auth/registro.php");
        } else {
            showErrorAndRedirect("Error al registrar el usuario. Por favor, inténtalo de nuevo.", "../auth/registro.php");
        }
    }
}
?>
