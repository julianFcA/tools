<?php   
require_once 'template.php'

?>

<?php


if (isset($_GET['licencia']) && isset($_GET['documento'])) {
    $documento = $_GET["documento"];
    $licencia = $_GET["licencia"];

    $elim_usu = $conn->prepare("DELETE usuario.documento, licencia.licencia FROM usuario ,licencia WHERE licencia ='".$_GET['licencia']." AND documento ='".$_GET['documento'].'"');
    $elim_usu -> execute([$documento, $licencia]);
    $eje_delete = $elim_usu ->fetch(PDO::FETCH_ASSOC);

    }else{
        echo '<script>alert ("Se elimino la licencia");</script>';
        // echo '<script>window.location="./index.php"</script>';
    }

?>