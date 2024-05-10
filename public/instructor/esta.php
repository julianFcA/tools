<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

// Función para contar la cantidad de préstamos reportados por usuario
function countReportedLoansByUser($conn, $documento) {
    $count_query = "SELECT COUNT(*) AS total 
                    FROM usuario 
                    INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento 
                    INNER JOIN detalle_prestamo ON detalle_prestamo.id_presta = prestamo_herra.id_presta
                    INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
                    INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
                    WHERE usuario.documento = :documento AND detalle_prestamo.estado_presta = 'reportado'";
    $count_statement = $conn->prepare($count_query);
    $count_statement->bindParam(':documento', $documento, PDO::PARAM_STR);
    $count_statement->execute();
    $count_result = $count_statement->fetch(PDO::FETCH_ASSOC);
    return $count_result['total'];
}

// Función para actualizar el estado del usuario
function updateUsersStatus($conn) {
    $query = "SELECT usuario.documento
              FROM usuario 
              INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento 
              INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta
              INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
              INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
              WHERE usuario.id_rol = 3 AND detalle_prestamo.estado_presta = 'reportado'
              GROUP BY usuario.documento
              HAVING COUNT(*) >= 3";

    $statement = $conn->query($query);
    $documents = $statement->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($documents)) {
        $placeholders = rtrim(str_repeat('?,', count($documents)), ',');
        $update_query = "UPDATE usuario SET id_esta_usu = 2 WHERE documento IN ($placeholders)";
        $update_statement = $conn->prepare($update_query);
        $update_statement->execute($documents);
    }
}

// Ejecutar la función para actualizar el estado del usuario
updateUsersStatus($conn);

// Definir el número de resultados por página y la página actual
$porPagina = 20;
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$empieza = ($pagina - 1) * $porPagina;

// Consulta SQL original
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
WHERE ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3 AND detalle_prestamo.estado_presta = 'reportado'
LIMIT :empieza, :porPagina"; // Agregamos límite de resultados por página

// Preparar y ejecutar la consulta principal
$statement = $conn->prepare($query);
$statement->bindParam(':empieza', $empieza, PDO::PARAM_INT);
$statement->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
$statement->execute();

// Obtener resultados por página
$resultado_pagina = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
