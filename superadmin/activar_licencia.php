<?php
require_once 'template.php';

if (isset($_GET["licencia"])) {

    $id = $_GET["licencia"];

    $nit_empresa = $conn->prepare("SELECT licencia FROM licencia WHERE licencia=?");
    $nit_empresa->execute([$id]);
    $nit_empre = $nit_empresa->fetch(PDO::FETCH_ASSOC);

    $fecha_ini = date('Y-m-d H:i:s');

    $fecha_fin = date('Y-m-d H:i:s', strtotime('+1 year'));

    $esta_licen='activo';

    $validar_nit = $conn->prepare("SELECT * FROM licencia WHERE nit_empre = ?");
    $validar_nit->execute([$nit_empre]);

    if ($nit_empre) {
        $updateSql = $conn->prepare("UPDATE licencia SET fecha_ini = ?, fecha_fin = ?, esta_licen = ? WHERE licencia = ?");
        $updateSql->execute([$fecha_ini, $fecha_fin,$esta_licen, $id]);

        echo '<script>alert("Licencia activa.");</script>';
        echo '<script>window.location="./index.php"</script>';
    }
}
