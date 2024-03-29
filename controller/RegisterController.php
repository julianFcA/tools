<?php
require_once '../database/conn.php';
// require_once './funciones/funciones.php';
require_once '../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$database = new Database();
$conn = $database->conectar();

date_default_timezone_set('America/Bogota');

$isAnyFieldEmpty = false;
foreach ($_POST as $value) {
    if (empty($value)) {
        $isAnyFieldEmpty = true;
        break;
    }
}

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    if ($isAnyFieldEmpty) {
        echo '<script>alert("Existen campos vacíos en el formulario.");</script>';
        echo '<script>window.location = "../auth/registro.php";</script>';
    } else {
        $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
        $id_tp_docu = filter_input(INPUT_POST, 'id_tp_docu', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
        $contrasena = $_POST['contrasena']; // No es necesario filtrar la contraseña
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        // $id_forma = filter_input(INPUT_POST, 'id_forma', FILTER_VALIDATE_INT);
        $ficha = filter_input(INPUT_POST, 'ficha', FILTER_SANITIZE_STRING);
        $terminos = isset($_POST['terminos']) ? 1 : 0;
        $id_esta_usu = filter_input(INPUT_POST, 'id_esta_usu', FILTER_VALIDATE_INT);
        $id_rol = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);
        $nit_empre = filter_input(INPUT_POST, 'nit_empre', FILTER_SANITIZE_STRING);

        // Validaciones adicionales en el lado del servidor
        if (strlen($documento) !== 10 || !is_numeric($documento)) {
            echo '<script>alert("Documento debe tener 10 dígitos numéricos.");</script>';
            echo '<script>window.location = "../auth/registro.php";</script>';
        } elseif (strlen($nombre) < 6 || strlen($nombre) > 12) {
            echo '<script>alert("Nombre debe tener entre 6 y 12 caracteres.");</script>';
            echo '<script>window.location = "../auth/registro.php";</script>';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Correo electrónico no válido.");</script>';
            echo '<script>window.location = "../auth/registro.php";</script>';
        } else {
            // Prepara y ejecuta la consulta para verificar si el tipo de documento existe
            $stmtCheckTypeDoc = $conn->prepare("SELECT id_tp_docu FROM usuario WHERE id_tp_docu = ?");
            $stmtCheckTypeDoc->bindParam(1, $id_tp_docu, PDO::PARAM_INT);
            $stmtCheckTypeDoc->execute();
            $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

            $codigo_barras = uniqid() . rand(1000, 9999);
            $generator = new BarcodeGeneratorPNG();
            $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);
            file_put_contents(__DIR__ . '/../images/' . $codigo_barras . '.png', $codigo_barras_imagen);

            $user_password = password_hash($contrasena, PASSWORD_DEFAULT);
            if ($user_password === false) {
                echo '<script>alert("Error al hashear la contraseña.");</script>';
                echo '<script>window.location = "../auth/registro.php";</script>';
            } else {
                // Se define la variable $fecha_registro
                $fecha_registro = date("Y-m-d H:i:s");
                // Se elimina NOW() de los valores
                $stmt = $conn->prepare("INSERT INTO usuario (documento, id_tp_docu, nombre, apellido, contrasena, correo, ficha, codigo_barras, fecha_registro, terminos, id_rol, id_esta_usu, nit_empre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Asegúrate de que el número de parámetros coincide con el número de '?' en la consulta
                $stmt->execute([$documento, $id_tp_docu, $nombre, $apellido, $user_password, $correo, $ficha, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre]);

                echo '<script>alert("Registro exitoso.");</script>';
                echo '<script>window.location = "../auth/registro.php";</script>';
            }
        }
    }
}
?>
