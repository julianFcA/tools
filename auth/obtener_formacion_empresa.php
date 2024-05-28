<?php
require_once '../database/conn.php'; // Asegúrate de que esta ruta es correcta

$nit_empre = $_POST['nit_empre'] ?? '';

try {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "herramientas";
    
    $conn = new PDO("mysql:host=$servername;dbname=herramientas", $username, $password);

    $stmt = $conn->prepare("SELECT id_forma, nom_forma FROM formacion WHERE nit_empre = :nit_empre");
    $stmt->bindParam(':nit_empre', $nit_empre);
    $stmt->execute();
    $formaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array('formaciones' => $formaciones));
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Error de base de datos: ' . $e->getMessage()));
}
?>
