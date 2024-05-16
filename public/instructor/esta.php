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
            $update_user_query = "UPDATE usuario SET id_esta_usu = 2 WHERE documento IN (" . implode(',', $documents) . ")";
            // Preparar la consulta de actualización
            $update_user_statement = $conn->prepare($update_user_query);
            // Ejecutar la consulta de actualización de usuarios
            $update_user_statement->execute();
            
            // Query para actualizar el estado de detalle_prestamo
            $update_detail_query = "UPDATE detalle_prestamo SET estado_presta = 'bloqueado' WHERE id_deta_presta IN (SELECT id_deta_presta FROM reporte WHERE id_deta_presta IN (SELECT id_deta_presta FROM detalle_prestamo WHERE estado_presta = 'reportado'))";
            // Preparar la consulta de actualización de detalle_prestamo
            $update_detail_statement = $conn->prepare($update_detail_query);
            // Ejecutar la consulta de actualización de detalle_prestamo
            $update_detail_statement->execute();
            
            // Imprimir el número de filas afectadas
            $affected_rows_users = $update_user_statement->rowCount();
            $affected_rows_detail = $update_detail_statement->rowCount();
            echo "Se actualizaron $affected_rows_users usuario(s) y $affected_rows_detail detalle(s) de prestamo.";
        } else {
            echo "No se encontraron usuarios para actualizar.";
        }
    } catch (PDOException $e) {
        // Manejar cualquier excepción PDO
        echo "Error: " . $e->getMessage();
    }
}

// Ejecutar la función para actualizar el estado del usuario
updateUsersStatus($conn);

?>
