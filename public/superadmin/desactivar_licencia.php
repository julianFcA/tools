<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();


if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $nitQuery = $conn->prepare("SELECT licencia FROM licencia WHERE licencia=?");
    $nitQuery->execute([$id]);
    $nit = $nitQuery->fetch(PDO::FETCH_ASSOC); // Cambiado a fetch


    if ($nit) {

        // Se actualiza el estado de la licencia
        $updateSql = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = ?");
        $updateSql->execute([$id]);
        echo '<script>alert ("licencia desactivada con exito");</script>';
        echo '<script> window.location= "licencia.php"</script>';
    }
}
?>
