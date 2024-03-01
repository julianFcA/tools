<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();


if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $nit_empresa = $conn->prepare("SELECT licencia FROM licencia WHERE licencia=?");
    $nit_empresa->execute([$id]);
    $nit_empre = $nit_empresa->fetch(PDO::FETCH_ASSOC);


    $fecha_inicio = date('Y-m-d H:i:s');

    $fecha_fin = date('Y-m-d H:i:s', strtotime('+2 year'));

    $esta_licen= "activo";




    if ($nit_empre) {
        $updateSql = $conn->prepare("UPDATE licencia SET fecha_ini = ?, fecha_fin = ?, esta_licen = ? WHERE licencia = ?");
        $updateSql->execute([$fecha_inicio, $fecha_fin,$esta_licen, $id]);

        echo '<script>alert("Licencia activa.");</script>';
        echo '<script>window.location="licencia.php"</script>';
    }
}
