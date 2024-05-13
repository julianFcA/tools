<?php
require_once 'template.php';
if (isset($_POST["documento"])) {
    $id = $_POST["documento"];

    // Verificar si el usuario existe
    $consulta_usuario = $conn->prepare("SELECT documento FROM usuario WHERE documento = ?");
    $consulta_usuario->execute([$id]);
    $usuario = $consulta_usuario->fetch(PDO::FETCH_ASSOC);

    // Si el usuario existe
    if ($usuario) {
        // Activar al usuario y eliminar los tres reportados anteriores
        $estado_usuario = 1; // Estado activado
        $fecha_activacion = date('Y-m-d'); // Obtener la fecha actual

        // Actualizar el estado del usuario y la fecha de activación
        $actualizar_usuario = $conn->prepare("UPDATE usuario SET id_esta_usu = ? WHERE documento = ?");
        $actualizar_usuario->execute([$estado_usuario, $id]);

        // Eliminar los tres reportados anteriores del usuario
        $eliminar_reportados = $conn->prepare("DELETE FROM detalle_prestamo WHERE id_deta_presta IN (SELECT id_deta_presta FROM detalle_prestamo INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta  INNER JOIN deta_reporte ON reporte.id_reporte = deta_reporte.id_reporte INNER JOIN prestamo_herra ON detalle_prestamo.id_presta = prestamo_herra.id_presta WHERE prestamo_herra.documento = ? ORDER BY detalle_prestamo.id_deta_presta DESC LIMIT 3)");
        $eliminar_reportados->execute([$id]);        


        // Mostrar mensaje de éxito y redirigir
        echo '<script>alert("Aprendiz activado y reportados anteriores eliminados.");</script>';
        echo '<script>window.location="./index.php"</script>';
    } else {
        // Mostrar mensaje de error si el usuario no existe
        echo '<script>alert("El usuario no existe.");</script>';
        echo '<script>window.location="./index.php"</script>';
    }
}


