<?php
session_start();

// Reemplaza con la ruta correcta si es necesario
require_once "../database/conn.php";

try {
    // Asumiendo que "Database" es la clase para la conexión.
    $db = new Database();
    $conn = $db->conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["iniciarSesion"])) {
        $documento = $_POST["documento"];
        $contrasena = $_POST['contrasena'];

        // Realiza la consulta de autenticación
        $consultaauten = $conn->prepare("SELECT * FROM usuario 
                                         JOIN licencia ON licencia.nit_empresa = usuario.nit_empresa 
                                         WHERE documento = :documento AND id_esta_usu = 1");
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
            $registroEntrada = $conn->prepare("INSERT INTO entrada_usu(fecha_entrada, documento) VALUES (NOW(), :documento)");
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
                case 5:
                    echo "<script>alert('Error intente de nuevo');</script>";
                    header("Location:../auth/error.php");
                    exit;
                default:
                    echo "<script>alert('La contraseña no es correcta o expiró su licencia');</script>";
                    echo '<script>window.location="../index.php"</script>';
                    exit;
            }
        } else {
            // Autenticación fallida
            echo "<script>alert('La contraseña no es correcta o expiró su licencia');</script>";
            echo '<script>window.location="../index.php"</script>';
            exit();
        }
    }
} catch (PDOException $e) {
    // Manejar el error aquí (por ejemplo, loggearlo)
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}
?>
