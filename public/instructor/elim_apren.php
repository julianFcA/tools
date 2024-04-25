<?php   
require_once ("../../database/conn.php"); 
$db = new Database();
$conn = $db ->conectar();
session_start();

?>

<?php

if (isset($_GET['documento'])) {
    $documento = $_GET["documento"];

    // Eliminar filas en la tabla entrada_usu que hacen referencia al usuario que se va a eliminar
    $elim_entrada = $conn->prepare("DELETE FROM entrada_usu WHERE documento = :documento");
    $elim_entrada->bindParam(':documento', $documento);
    $elim_entrada->execute();

    // Luego eliminar el usuario de la tabla usuario
    $elim_usu = $conn->prepare("DELETE FROM usuario WHERE documento = :documento");
    $elim_usu->bindParam(':documento', $documento);
    $elim_usu->execute();

    echo '<script>alert("Se eliminó el usuario correctamente");</script>';
    echo '<script>window.location="./index.php"</script>';
} else {
    echo '<script>alert("Se eliminó el usuario correctamente");</script>';
    echo '<script>window.location="./index.php"</script>';
}


?>