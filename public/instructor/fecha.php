<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

$query = "SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, tp_docu.nom_tp_docu, deta_ficha.ficha, prestamo_herra.*, detalle_prestamo.*, herramienta.*, reporte.*, deta_reporte.*
FROM usuario 
INNER JOIN rol ON usuario.id_rol = rol.id_rol 
INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento 
INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha 
INNER JOIN formacion ON ficha.id_forma = formacion.id_forma 
INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada  
INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento 
INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta
INNER JOIN herramienta ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra  
INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
WHERE ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3 AND detalle_prestamo.estado_presta = 'reportado'";


try {
    // Consulta SQL para actualizar el estado de los préstamos
    $updateSql = "UPDATE detalle_prestamo AS dp
                  INNER JOIN prestamo_herra AS ph ON dp.id_presta = ph.id_presta
                  SET dp.estado_presta = 'reportado'
                  WHERE ph.fecha_entrega < NOW() AND dp.estado_presta = 'prestado'";
    
    // Preparar y ejecutar la consulta de actualización
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute();
    
    // Obtener el número de filas afectadas
    $rowCount = $updateStmt->rowCount();
    
    echo "Se han actualizado $rowCount registros correctamente.";

    // Consulta SQL para insertar en la tabla 'reporte'
    $insertReporteSql = "INSERT INTO reporte (descripcion, id_deta_presta, documento, fecha) 
                         SELECT 'tarde', id_deta_presta, :documento , NOW() 
                         FROM detalle_prestamo 
                         WHERE estado_presta = 'reportado'";
    
    // Preparar y ejecutar la consulta de inserción en 'reporte'
    $insertReporteStmt = $conn->prepare($insertReporteSql);
    $insertReporteStmt->execute();

    // Obtener el ID de reporte generado
    $lastInsertId = $conn->lastInsertId();

    // Consulta SQL para insertar en la tabla 'deta_reporte'
    $insertDetaReporteSql = "INSERT INTO deta_reporte (id_reporte, codigo_barra_herra) 
                             VALUES (:id_reporte, :codigo_barra_herra)";
    
    // Preparar la consulta de inserción en 'deta_reporte'
    $insertDetaReporteStmt = $conn->prepare($insertDetaReporteSql);
    $insertDetaReporteStmt->bindParam(':id_reporte', $lastInsertId, PDO::PARAM_INT);

    // Ejecutar la consulta de inserción en 'deta_reporte'
    foreach ($detalle_prestamo_ids as $id_deta_presta) {
        // Supongamos que tienes un array llamado $detalle_prestamo_ids con los IDs de detalle_prestamo
        $insertDetaReporteStmt->bindParam(':codigo_barra_herra', $id_deta_presta, PDO::PARAM_INT);
        $insertDetaReporteStmt->execute();
    }

    echo "Se han insertado los registros en las tablas 'reporte' y 'deta_reporte' correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
