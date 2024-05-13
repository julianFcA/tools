<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');


// Función para contar la cantidad de préstamos reportados por usuario
function updateUsersStatus($conn) {
    try {
        // Query para seleccionar los documentos de los usuarios que cumplen las condiciones
        $query = "SELECT usuario.documento
                  FROM usuario 
                  INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento 
                  INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta
                  INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
                  INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
                  INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu
                  WHERE usuario.id_rol = 3 AND usuario.id_esta_usu = 1 AND detalle_prestamo.estado_presta = 'reportado'
                  GROUP BY usuario.documento
                  HAVING COUNT(*) = 3";

        // Preparar la consulta
        $statement = $conn->prepare($query);
        // Ejecutar la consulta
        $statement->execute();
        // Obtener los documentos de los usuarios que cumplen las condiciones
        $documents = $statement->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($documents)) {
            // Query para actualizar el estado de los usuarios
            $update_query = "UPDATE usuario SET id_esta_usu = 2 WHERE documento IN (SELECT documento FROM (" . $query . ") AS temp)";
            // Preparar la consulta de actualización
            $update_statement = $conn->prepare($update_query);
            // Ejecutar la consulta de actualización
            $update_statement->execute();
            
            // Imprimir el número de filas afectadas
            $affected_rows = $update_statement->rowCount();
            echo "Se actualizaron $affected_rows fila(s).";
        }
    } catch (PDOException $e) {
        // Manejar cualquier excepción PDO
        echo "Error: " . $e->getMessage();
    }
}

// Ejecutar la función para actualizar el estado del usuario
updateUsersStatus($conn);




?>
