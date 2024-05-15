<?php
require_once '../database/conn.php';

$nit_empre = $_POST['nit_empre'] ?? '';

try {
    $servername = "localhost";
    $username = "root";
    $password = "123456";
    $dbname = "herramientas";
    
    $conn = new PDO("mysql:host=$servername;dbname=herramientas", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT nom_empre FROM empresa WHERE nit_empre = :nit_empre");
    $stmt->bindParam(':nit_empre', $nit_empre);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode(array('acceso_permitido' => true, 'nombre_empresa' => $resultado['nom_empre']));
    } else {
        echo json_encode(array('acceso_permitido' => false));
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Error de base de datos: ' . $e->getMessage()));
}

?>
