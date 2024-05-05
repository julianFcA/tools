<?php
require_once 'template.php';

if (isset($_POST["documento"])) {

    $id = $_POST["documento"];

    $nit_empresa = $conn->prepare("SELECT documento FROM usuario WHERE documento=?");
    $nit_empresa->execute([$id]);
    $nit_empre = $nit_empresa->fetch(PDO::FETCH_ASSOC);


    $esta_aprend='1';

    if ($nit_empre) {
        $updateSql = $conn->prepare("UPDATE usuario SET  id_esta_usu = ? WHERE documento = ?");
        $updateSql->execute([$esta_aprend, $id]);

        echo '<script>alert("Aprendiz activado.");</script>';
        echo '<script>window.location="./index.php"</script>';
    }
}
