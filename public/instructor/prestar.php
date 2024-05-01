<?php
// require_once 'template.php';

require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

// Verifica si se ha enviado un formulario POST y si se han seleccionado herramientas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MM_register']) && $_POST['MM_register'] == "formRegister" && isset($_SESSION['herramientas']) && is_array($_SESSION['herramientas'])) {

    // Comprueba si el documento existe
    $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
    $stmtCheckDocument = $conn->prepare("SELECT * FROM usuario WHERE documento = ?");
    $stmtCheckDocument->execute([$documento]);
    $resultCheckDocument = $stmtCheckDocument->fetch();

    if ($resultCheckDocument) {
        // Inicia una transacción
        $conn->beginTransaction();

        // Fecha de registro
        $fecha_adqui = date("Y-m-d H:i:s");
        $dias = filter_input(INPUT_POST, 'dias', FILTER_VALIDATE_INT);
        $estado_prestamo = 'salvado'; // Suponiendo que 'salvado' es un estado válido
        $codigo_barra_herramientas = $_SESSION['herramientas'];

        // Insertar préstamo en la tabla prestamo_herra
        $stmt = $conn->prepare("INSERT INTO prestamo_herra (fecha_adqui, dias, estado_prestamo, documento) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fecha_adqui, $dias, $estado_prestamo, $documento]);

        // Obtener el ID del préstamo recién insertado
        $id_prestamo = $conn->lastInsertId();

        // Insertar detalles de préstamo en la tabla detalle_prestamo
        foreach ($codigo_barra_herramientas as $codigo_barra_herra) {
            $cant_herra = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT); // Mover la obtención de cantidad dentro del bucle
            // Suponiendo que la cantidad es 1 por cada herramienta seleccionada
            $stmt1 = $conn->prepare("INSERT INTO detalle_prestamo (cant_herra, codigo_barra_herra, id_presta) VALUES (?, ?, ?)");
            $stmt1->execute([$cant_herra, $codigo_barra_herra, $id_prestamo]);
        }

        // Confirma la transacción
        $conn->commit();

        echo '<script>alert("Préstamo exitoso.");</script>'; // Modificado el mensaje de éxito
        echo '<script>window.location = "./index.php";</script>';
    }
} else {
    // Redirige si no se cumple alguna de las condiciones
    redirectToPrestamoPage("Debes seleccionar al menos una herramienta del inventario.");
}

// Función para redireccionar con un mensaje
function redirectToPrestamoPage($message)
{
    echo "<script>alert('$message');</script>";
    echo '<script>window.location="./termino_prestamo.php"</script>';
    exit();
}
?>
