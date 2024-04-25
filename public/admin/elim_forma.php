<?php   
require_once ("../../database/conn.php"); 
$db = new Database();
$conn = $db ->conectar();
session_start();

?>

<?php

if (isset($_GET['id_forma']) && !empty($_GET['id_forma'])) {
    $id_forma = $_GET['id_forma'];

    $elim_usu = $conn->prepare("DELETE FROM formacion WHERE id_forma = ?");
    if ($elim_usu->execute([$id_forma])) {
        $num_filas_afectadas = $elim_usu->rowCount();
        if ($num_filas_afectadas > 0) {
            echo '<script>alert("Se eliminó la formación correctamente.");</script>';
        } else {
            echo '<script>alert("No se encontró formación para eliminar.");</script>';
        }
    } else {
        echo '<script>alert("Ocurrió un error al intentar eliminar la formación.");</script>';
    }
} else {
    echo '<script>alert("No se proporcionó formación para eliminar.");</script>';
}

echo '<script>window.location="./formacion.php"</script>';
?>
