<?php
require_once 'template.php';

// Verifica si se ha enviado un formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se han recibido las herramientas y sus cantidades
    if (isset($_POST['cantidad']) && is_array($_POST['cantidad'])) {
        // Inicia una transacción para asegurar la integridad de los datos
        $conn->beginTransaction();

        $dias = $_POST['dias'];
        $documento = $_POST['MM_register'];
        $fecha_adqui = date('Y-m-d'); // Obtiene la fecha actual del servidor

        try {
            // Calcula la fecha de entrega sumando los días al la fecha de adquisición
            $fecha_entrega = date('Y-m-d', strtotime($fecha_adqui . " +$dias days"));

            // Inserta el préstamo en la tabla de préstamos
            $query = "INSERT INTO prestamo_herra (fecha_adqui, dias, fecha_entrega, documento) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$fecha_adqui, $dias, $fecha_entrega, $documento]);
            $prestamo_id = $conn->lastInsertId(); // Obtiene el ID del préstamo insertado

            // Itera sobre las herramientas prestadas y sus cantidades
            foreach ($_POST['cantidad'] as $codigo_barra => $cantidad) {
                // Inserta la herramienta prestada en la tabla de detalle de préstamos
                $query = "INSERT INTO detalle_prestamo (id_presta, codigo_barra_herra, cant_herra) 
                          VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$prestamo_id, $codigo_barra, $cantidad]);

                // Actualiza la cantidad disponible de la herramienta en la tabla de herramientas
                $query = "UPDATE herramienta SET cantidad = cantidad - ? 
                          WHERE codigo_barra_herra = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$cantidad, $codigo_barra]);
            }

            // Confirma la transacción
            $conn->commit();

            echo "<script>alert('El préstamo se ha registrado exitosamente.');</script>";
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
