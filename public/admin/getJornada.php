<?php

// getJornada.php
require_once '../../database/conn.php';  // Ajusta según la ubicación real y método de inclusión

$database = new Database();
$conn = $database->conectar();

header('Content-Type: application/json');

if (isset($_POST['id_ficha'])) {
    $id_ficha = $_POST['id_ficha'];
    // Asegúrate de que tu consulta SQL esté correcta y corresponda a la estructura de tu base de datos
    $stmt = $conn->prepare("SELECT j.id_jornada, j.tp_jornada FROM jornada j JOIN ficha f ON j.id_jornada = f.id_jornada WHERE f.ficha = ?");
    $stmt->execute([$id_ficha]);
    $jornadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($jornadas);
} else {
    echo json_encode(['error' => 'No se proporcionó id_ficha']);
}
?>