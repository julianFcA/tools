<?php
require_once './../../database/conn.php';  // Asegura que la ruta es correcta según la ubicación del archivo

$database = new Database();
$conn = $database->conectar();  // Obtiene la conexión a la base de datos

header('Content-Type: application/json'); // Asegura que la respuesta es tratada como JSON

if (isset($_POST['id_forma'])) {
    $id_forma = $_POST['id_forma'];
    $stmt = $conn->prepare("SELECT ficha.ficha FROM ficha WHERE ficha.id_forma = ?");
    $stmt->execute([$id_forma]);
    $fichas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($fichas);  // Devuelve las fichas como JSON
    exit;
} else {
    echo json_encode(['error' => 'No se proporcionó id_forma']);
    exit;
}
?>
