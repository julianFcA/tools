<?php
require_once 'template.php';

$docu = $_SESSION['documento'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    switch ($action) {
        case 'Devolver Herramienta':
            if (isset($_POST['cantidad'])) {
                foreach ($_POST['cantidad'] as $id_deta_presta => $cantidad_devuelta) {
                    if (isset($_POST['herramienta'][$id_deta_presta])) {
                        // Obtener el código de barras de la herramienta devuelta
                        $codigo_herramienta = $_POST['herramienta'][$id_deta_presta];

                        // Resto del código para devolver la herramienta
                        $query_cantidad_prestada = "SELECT cant_herra FROM detalle_prestamo WHERE id_deta_presta = ?";
                        $stmt_cantidad_prestada = $conn->prepare($query_cantidad_prestada);
                        $stmt_cantidad_prestada->execute([$id_deta_presta]);
                        $cantidad_prestada = $stmt_cantidad_prestada->fetchColumn();

                        $nueva_cantidad_prestada = $cantidad_prestada - $cantidad_devuelta;

                        $query_actualizar_cantidad = "UPDATE detalle_prestamo SET cant_devolucion = ?, cant_herra = ?, estado_presta = ? WHERE id_deta_presta = ?";
                        $estado = ($nueva_cantidad_prestada == 0) ? 'devuelto' : 'incompleto';
                        $stmt_actualizar_cantidad = $conn->prepare($query_actualizar_cantidad);
                        $stmt_actualizar_cantidad->execute([$cantidad_devuelta, $nueva_cantidad_prestada, $estado, $id_deta_presta]);

                        $query_herramienta = "UPDATE herramienta SET cantidad = cantidad + ? WHERE codigo_barra_herra = ?";
                        $stmt_herramienta = $conn->prepare($query_herramienta);
                        $stmt_herramienta->execute([$cantidad_devuelta, $codigo_herramienta]);
                    }
                }
                redirectToPrestamoPage("Herramientas devueltas con éxito.");
            } else {
                redirectToPrestamoPage("Error: No se han especificado herramientas para devolver o no se ha proporcionado el código de barras de la herramienta.");
            }
            break;
        case 'Reportar Herramienta':
            $codigo_herramienta = $_POST['herramienta'];
            $documento = $_POST['documento'];
            $motivo = $_POST['motivo'];
            if (isset($_POST['motivo']) && isset($_POST['cantidad'])) {


                foreach ($_POST['cantidad'] as $id_deta_presta => $cantidad_devuelta) {
                    $query_insert_reporte = "INSERT INTO reporte (id_deta_presta, descripcion,documento, fecha) VALUES (?, ?,?, NOW())";
                    $stmt_insert_reporte = $conn->prepare($query_insert_reporte);
                    $stmt_insert_reporte->execute([$id_deta_presta, $motivo, $documento]);

                    $id_reporte = $conn->lastInsertId();

                    $query_update_detalle_prestamo = "UPDATE detalle_prestamo SET estado_presta = 'reportado' WHERE id_deta_presta = ?";
                    $stmt_update_detalle_prestamo = $conn->prepare($query_update_detalle_prestamo);
                    $stmt_update_detalle_prestamo->execute([$id_deta_presta]);

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