<?php   
require_once ("../../database/conn.php"); 
$db = new Database();
$conn = $db ->conectar();
session_start();

?>

<?php


if ( isset($_GET['ficha']) ) {
    $ficha = $_GET["ficha"];

    // Luego eliminar el usuario de la tabla usuario
    $elim_usu = $conn->prepare("DELETE FROM deta_ficha WHERE  ficha = :ficha");
    $elim_usu->bindParam(':ficha', $ficha);
    $elim_usu->execute();

    echo '<script>alert("Se eliminó el usuario correctamente");</script>';
    echo '<script>window.location="./index.php"</script>';
} else {
    echo '<script>alert("Se eliminó el usuario correctamente");</script>';
    echo '<script>window.location="./index.php"</script>';
}


?>