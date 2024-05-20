<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'template.php';

$docu = $_SESSION['documento'];

// Verifica si se ha enviado un formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración: Verifica si los datos POST se están recibiendo
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // Verifica si se han recibido las herramientas y sus cantidades
    if (isset($_POST['cantidad']) && is_array($_POST['cantidad']) && isset($_POST['dias']) && isset($_POST['MM_register'])) {
        // Inicia una transacción para asegurar la integridad de los datos
        $conn->beginTransaction();

        $dias = (int)$_POST['dias'];
        $docu = $_POST['MM_register'];
        $fecha_adqui = date('Y-m-d'); // Obtiene la fecha actual del servidor
        $fecha_entrega = date('Y-m-d', strtotime($fecha_adqui . " +$dias days"));

        try {
            // Inserta un nuevo préstamo
            $query = "INSERT INTO prestamo_herra (documento, fecha_adqui, fecha_entrega) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$docu, $fecha_adqui, $fecha_entrega]);
            
            // Obtiene el ID del préstamo recién insertado
            $id_presta = $conn->lastInsertId();

            // Itera sobre las herramientas prestadas y sus cantidades
            foreach ($_POST['cantidad'] as $codigo_barra => $cantidad) {
                // Verifica si el código de barra existe en la tabla herramienta
                $query = "SELECT COUNT(*) FROM herramienta WHERE codigo_barra_herra = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$codigo_barra]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    // Inserta la herramienta prestada en la tabla de detalle de préstamos
                    $query = "INSERT INTO detalle_prestamo (id_presta, codigo_barra_herra, cant_herra) 
                              VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$id_presta, $codigo_barra, $cantidad]);

                }
            }

            // Confirma la transacción
            $conn->commit();

            echo "<script>alert('Se ha dado más tiempo del préstamo exitosamente.');</script>";
            echo '<script>window.location="./index.php"</script>';
        } catch (Exception $e) {
            // Si ocurre algún error, revierte la transacción y muestra un mensaje de error
            $conn->rollBack();
            echo "Error al registrar el préstamo: " . $e->getMessage();
        }
    } else {
        // Si no se recibió la información adecuada, muestra un mensaje de error
        echo "No se recibió la información adecuada de las herramientas y sus cantidades.";
    }
} else {
    // Si no se recibió un formulario POST, muestra un mensaje de error
    echo "No se recibió un formulario POST.";
}
?>
