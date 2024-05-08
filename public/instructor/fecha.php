<?php
require_once './../../database/conn.php'; // Reemplaza con la ruta correcta a tu archivo de conexión
$database = new Database();
$conn = $database->conectar(); // Establece la conexión PDO

try {
    // Consulta SQL para actualizar el estado de los préstamos
    $sql = "UPDATE detalle_prestamo AS dp
            INNER JOIN prestamo_herra AS ph ON dp.id_presta = ph.id_presta
            SET dp.estado_presta = 'reportado'
            WHERE ph.fecha_entrega < NOW() AND dp.estado_presta = 'prestado'";
    
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el número de filas afectadas
    $rowCount = $stmt->rowCount();
    
    echo "Se han actualizado $rowCount registros correctamente.";
} catch (PDOException $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}


?>
