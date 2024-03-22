<?php
session_start();
require_once "./../database/conn.php";
$db = new Database(); // Asumiendo que "Database" es la clase para la conexión.
$conn = $db->conectar();

if (isset($_POST["iniciarSesion"])) {
    $documento = $_POST["documento"];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    // Realiza la consulta de autenticación
    $consultaauten = $conn->prepare("SELECT * FROM usuario JOIN licencia ON licencia.nit_empre = usuario.nit_empre WHERE documento = :documento AND id_esta_usu = 1 AND esta_licen = 'activo'");
    $consultaauten->bindParam(':documento', $documento);
    $consultaauten->execute();
    $sesionAutenticada = $consultaauten->fetch();

    if ($sesionAutenticada && password_verify($contrasena, $sesionAutenticada['contrasena'])) {
        // Autenticación exitosa
        $_SESSION['documento'] = $sesionAutenticada['documento'];
        $_SESSION['contrasena'] = $sesionAutenticada['contrasena'];
        $_SESSION['rol'] = $sesionAutenticada['id_rol'];
        $_SESSION['nombre'] = $sesionAutenticada['nombre'];

        date_default_timezone_set("America/Bogota");

        // Registro de entrada
        $registroEntrada = $conn->prepare("INSERT INTO entrada_usu (fecha_entrada, documento) VALUES (NOW(), :documento)");
        $registroEntrada->bindParam(':documento', $_SESSION['documento']);
        $registroEntrada->execute();

        // Redireccionar según el rol
        switch ($_SESSION['rol']) {
            case 1:
                header("Location:../public/superadmin/index.php");
                exit;
            case 2:
                header("Location:../public/admin/index.php");
                exit;
            case 3:
                header("Location:../public/instructor/index.php");
                exit;
            case 4:
                header("Location:../public/aprendiz/index.php");
                exit;
            default:
                header("Location:../index.php");
                exit;
        }
    } else {
        // Autenticación fallida
        header('<script>alert("El Usuario No Esta Activo o Necesita Compra la Licencia.");</script>');
        header('Location:../auth/error.php');
        

    }
}
?>
