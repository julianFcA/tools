<?php
require_once 'template.php';

$docu = $_SESSION['documento'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificamos que se haya enviado un formulario POST

    $action = $_POST['action'];

    // Comprobamos la acción que se está realizando
    switch ($action) {
        case 'Devolver Herramienta':
            // Verificamos que se hayan especificado tanto 'cantidad' como 'herramienta'
            if (isset($_POST['cantidad'], $_POST['herramienta'])) {
                foreach ($_POST['cantidad'] as $id_deta_presta => $cantidad_devuelta) {
                    $codigo_herramienta = $_POST['herramienta'];

                    // Obtenemos la cantidad prestada de la herramienta
                    $query_cantidad_prestada = "SELECT cant_herra FROM detalle_prestamo WHERE id_deta_presta = ?";
                    $stmt_cantidad_prestada = $conn->prepare($query_cantidad_prestada);
                    $stmt_cantidad_prestada->execute([$id_deta_presta]);
                    $cantidad_prestada = $stmt_cantidad_prestada->fetchColumn();

                    // Calculamos la nueva cantidad prestada después de la devolución
                    $nueva_cantidad_prestada = $cantidad_prestada - $cantidad_devuelta;

                    $query_actualizar_herramienta = "UPDATE herramienta SET cantidad = cantidad + $cantidad_devuelta WHERE codigo_barra_herra = ?";
                    $stmt_actualizar_herramienta = $conn->prepare($query_actualizar_herramienta);
                    $stmt_actualizar_herramienta->execute([$codigo_herramienta]);

                    // Actualizamos la cantidad devuelta y el estado en la tabla 'detalle_prestamo'
                    $query_actualizar_detalle_prestamo = "UPDATE detalle_prestamo SET cant_devolucion = ?, cant_herra = ?, estado_presta = ? WHERE id_deta_presta = ?";
                    $estado = ($nueva_cantidad_prestada == 0) ? 'devuelto' : 'incompleto';
                    $stmt_actualizar_detalle_prestamo = $conn->prepare($query_actualizar_detalle_prestamo);
                    $stmt_actualizar_detalle_prestamo->execute([$cantidad_devuelta, $nueva_cantidad_prestada, $estado, $id_deta_presta]);
                }
                redirectToPrestamoPage("Herramientas devueltas con éxito.");
            } else {
                redirectToPrestamoPage("Error: No se han especificado herramientas para devolver o no se ha proporcionado el código de barras de la herramienta.");
            }
            break;
        case 'Reportar Herramienta':
            if (isset($_POST['motivo'], $_POST['cantidad'])) {
                $codigo_herramienta = $_POST['herramienta'];
                $documento = $_POST['documento'];
                $motivo = $_POST['motivo'];

                foreach ($_POST['cantidad'] as $id_deta_presta => $cantidad_devuelta) {

                    $query_insert_reporte = "INSERT INTO reporte (id_deta_presta, descripcion, documento, fecha) VALUES (?, ?, ?, NOW())";
                    $stmt_insert_reporte = $conn->prepare($query_insert_reporte);
                    $stmt_insert_reporte->execute([$id_deta_presta, $motivo, $documento]);
                    $id_reporte = $conn->lastInsertId();

                    $query_cantidad_prestada = "SELECT cant_herra FROM detalle_prestamo WHERE id_deta_presta = ?";
                    $stmt_cantidad_prestada = $conn->prepare($query_cantidad_prestada);
                    $stmt_cantidad_prestada->execute([$id_deta_presta]);
                    $cantidad_prestada = $stmt_cantidad_prestada->fetchColumn();

                    if ($cantidad_prestada == $cantidad_devuelta) {
                        $nueva_cantidad_prestada = $cantidad_prestada - $cantidad_devuelta;

                        $query_actualizar_detalle_prestamo = "UPDATE detalle_prestamo SET  cant_herra = ?, estado_presta = 'reportado' WHERE id_deta_presta = ?";
                        $stmt_actualizar_detalle_prestamo = $conn->prepare($query_actualizar_detalle_prestamo);
                        $stmt_actualizar_detalle_prestamo->execute([$nueva_cantidad_prestada, $id_deta_presta]);

                    } elseif ($cantidad_prestada >= $cantidad_devuelta) {
                        $nueva_cantidad_prestada = $cantidad_prestada - $cantidad_devuelta;

                        $query_actualizar_detalle_prestamo = "UPDATE detalle_prestamo SET  cant_herra = ?, estado_presta = 'Reportado una parte' WHERE id_deta_presta = ?";
                        $stmt_actualizar_detalle_prestamo = $conn->prepare($query_actualizar_detalle_prestamo);
                        $stmt_actualizar_detalle_prestamo->execute([$nueva_cantidad_prestada, $id_deta_presta]);

                    }
                    $query_insert_detalle_reporte = "INSERT INTO deta_reporte (id_reporte, codigo_barra_herra) VALUES (?, ?)";
                    $stmt_insert_detalle_reporte = $conn->prepare($query_insert_detalle_reporte);
                    $stmt_insert_detalle_reporte->execute([$id_reporte, $codigo_herramienta]);

                    redirectToPrestamoPage("Herramienta reportada con éxito.");
                }
            } else {
                redirectToPrestamoPage("Error: Falta información para reportar la herramienta.");
            }
            break;

        default:
            redirectToPrestamoPage("Acción no reconocida.");
            break;
    }
} else {
    redirectToPrestamoPage("Debes enviar el formulario.");
}

function redirectToPrestamoPage($message)
{
    echo "<script>alert('$message');</script>";
    echo '<script>window.location="./index.php"</script>';
    exit();
}
?>