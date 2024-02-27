<?php
session_start();
require_once "../database/conn.php";
$db = new Database(); // Asumiendo que "Database" es la clase para la conexión.
$conn = $db->conectar();

if (isset($_POST["iniciarSesion"])) {
    $documento = $_POST["documento"];
    $contrasena = $_POST['contrasena'];

    // Realiza la consulta de autenticación
    $consultaauten = $conn->prepare("SELECT * FROM usuario WHERE documento = :documento AND id_esta_usu = 1");
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
        $registroEntrada = $conn->prepare("INSERT INTO entrada_usu(fecha_entrada, documento) VALUES (NOW(), :documento)");
        $registroEntrada->bindParam(':documento', $_SESSION['documento']);
        $registroEntrada->execute();

        if ($_SESSION['rol'] == 1) {
            header("Location:../public/superadmin/index.php");
            exit;

        } elseif ($_SESSION['rol'] == 2) {
            header("Location:../public/admin/index.php");
            exit;
        }
        elseif ($_SESSION['rol'] == 3) {
            header("Location:../public/instructor/index.php");
            exit;
        }
        elseif ($_SESSION['rol'] == 4) {
            header("Location:../public/aprendiz/index.php");
            exit;
        }
    } else {
        // Autenticación fallida
        session_destroy();
        echo '<script>alert("Los datos ingresados son incorrectos.");</script>';
        echo '<script>window.location="../auth/error.php"</script>';
    }
}
?>
