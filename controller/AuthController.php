<?php
session_start();
require_once "./../database/conn.php"; // Asegúrate de que la ruta al archivo de conexión sea correcta
$db = new Database(); // Asumiendo que "Database" es la clase para la conexión.
$conn = $db->conectar();

// Verifica si se ha enviado un formulario y si se ha solicitado iniciar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["iniciarSesion"])) {
    // Obtiene los datos del formulario
    $documento = $_POST["documento"];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    // Realiza la consulta de autenticación
    $consultaauten = $conn->prepare("SELECT * FROM usuario JOIN licencia ON usuario.nit_empre = licencia.nit_empre JOIN empresa ON usuario.nit_empre = empresa.nit_empre WHERE usuario.documento = :documento AND usuario.id_esta_usu = 1 AND licencia.esta_licen = 'activo'");
    $consultaauten->bindParam(':documento', $documento);
    $consultaauten->execute();
    $sesionAutenticada = $consultaauten->fetch();

    if ($sesionAutenticada && password_verify($contrasena, $sesionAutenticada['contrasena'])) {
        // Comparar el nombre exactamente como está en la base de datos
        if ($nombre === $sesionAutenticada['nombre']) {
            // Autenticación exitosa
            $_SESSION['documento'] = $sesionAutenticada['documento'];
            $_SESSION['rol'] = $sesionAutenticada['id_rol'];
            $_SESSION['nombre'] = $sesionAutenticada['nombre'];
            $_SESSION['nit_empre'] = $sesionAutenticada['nit_empre'];
            $_SESSION['licencia'] = $sesionAutenticada['licencia'];

            date_default_timezone_set("America/Bogota");

            // Registro de entrada
            $registroEntrada = $conn->prepare("INSERT INTO entrada_usu (fecha_entrada, documento) VALUES (NOW(), :documento)");
            $registroEntrada->bindParam(':documento', $_SESSION['documento']);
            $registroEntrada->execute();

            // Redireccionar según el rol
            switch ($_SESSION['rol']) {
                case 1:
                    header("Location:../public/admin/index.php");
                    exit;
                case 2:
                    header("Location:../public/instructor/index.php");
                    exit;
                case 3:
                    header("Location:../public/aprendiz/index.php");
                    exit;
                default:
                    header("Location:../index.php");
                    exit;
            }
        } else {
            // Autenticación fallida debido a discrepancia en el nombre
            echo '<script>alert("Esta ingresando algun campo mal por favor verifique y vuelva a intentar");</script>';
            echo '<script>window.location="../auth/error.php"</script>';
        }
    } else {
        // Autenticación fallida debido a contraseña incorrecta o usuario no activo/licencia inactiva
        echo '<script>alert("El Usuario No Está Activo o Necesita Comprar la Licencia.");</script>';
        echo '<script>window.location="../auth/error.php"</script>';
    }
}
?>
