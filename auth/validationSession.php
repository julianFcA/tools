<?php

if (!isset($_SESSION['documento']) || !isset($_SESSION['rol'])) {
    echo "<script>alert('Debes iniciar sesión');</script>";
    header("Location:./index.php");
    exit(); // Agregar exit para asegurar que el script se detenga
}   

?>