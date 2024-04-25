<?php   
require_once ("../../database/conn.php"); 
$db = new Database();
$conn = $db ->conectar();
session_start();

?>

<?php

if (isset($_GET['codigo_barra_herra'])) {
    $codigo_barra_herra = $_GET["codigo_barra_herra"];

    $elim_usu = $conn->prepare("DELETE FROM herramienta WHERE codigo_barra_herra = ?");
    $elim_usu->execute([$codigo_barra_herra]);

    // No necesitas fetch() para una sentencia DELETE, ya que no devuelve filas afectadas.
    // Pero si deseas verificar si se realizó con éxito, puedes verificar el número de filas afectadas.
    $num_filas_afectadas = $elim_usu->rowCount();

    if ($num_filas_afectadas > 0) {
        echo '<script>alert("Se eliminó la Herramienta");</script>';
    } else {
        echo '<script>alert("No se encontró la Herramienta para eliminar");</script>';
    }
    echo '<script>window.location="./herramienta.php"</script>';
} else {
    echo '<script>alert("No se proporcionó un código de barras de herramienta para eliminar");</script>';
    echo '<script>window.location="./herramienta.php"</script>';
}

?>