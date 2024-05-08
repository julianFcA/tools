<?php
require_once 'template.php';
if (isset($_GET["nit_empre"])) {
    $nit_empre = $_GET["nit_empre"];

    // Consulta para verificar si el NIT ya tiene una licencia activa
    $validar_nit = $conn->prepare("SELECT * FROM licencia WHERE nit_empre = ? AND esta_licen = 'activo'");
    $validar_nit->execute([$nit_empre]);

    // Verifica si ya hay una licencia activa para este NIT
    if ($validar_nit->rowCount() > 0) {
        echo '<script>alert("Este NIT ya tiene una licencia activa");</script>';
        echo '<script>window.location="index.php"</script>';
        exit(); // Termina el script después de redireccionar
    }

    // Si no hay una licencia activa para este NIT, inserta una nueva
    $licencia = uniqid();
    $fecha_ini = date('Y-m-d H:i:s');
    $fecha_fin = date('Y-m-d H:i:s', strtotime('+1 year'));

    try {
        $insertsql = $conn->prepare("INSERT INTO licencia (licencia, esta_licen, fecha_ini, fecha_fin, nit_empre) VALUES (?, 'activo', ?, ?, ?)");
        $insertsql->execute([$licencia, $fecha_ini, $fecha_fin, $nit_empre]);

        // Si la inserción fue exitosa, muestra un mensaje y redirige
        echo '<script>alert("Registro exitoso");</script>';
        echo '<script>window.location = "licencia.php";</script>';
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


