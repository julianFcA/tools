<?php   
require_once ("../../database/conn.php"); 
$db = new Database();
$conn = $db ->conectar();
session_start();

 // Cerrar sesión
// if (isset($_POST['btncerrar'])) {
//     session_destroy();
//     header("Location:../../index.php");
//     exit();
// }

?>

<?php


// Verificamos si 'licencia' y 'documento' están definidos en $_GET
// if (isset($_GET['licencia']) && isset($_GET['documento'])) {
//     // Realizamos la conexión a la base de datos
//     $conn = new PDO( 'usuario', 'contraseña');
//     // Preparamos la consulta utilizando marcadores de posición (?)
//     $elim_usu = $conn->prepare("DELETE FROM licencia WHERE licencia = ? AND documento = ?");
//     // Ejecutamos la consulta pasando los valores correspondientes
//     $elim_usu->execute(array($_GET['licencia'], $_GET['documento']));
//     // Verificamos si se ejecutó correctamente
//     if ($elim_usu) {
//         echo "Licencia eliminada correctamente.";
//     } else {
//         echo "Error al eliminar la licencia.";
//     }
// } else {
//     // Manejo de error si 'licencia' o 'documento' no están definidos en $_GET
//     echo "Error: Falta el parámetro 'licencia' o 'documento'.";
// }


if (isset($_GET['licencia']) && isset($_GET['documento'])) {
    $documento = $_GET["documento"];
    $licencia = $_GET["licencia"];

    $elim_usu = $conn->prepare("DELETE usuario.documento, licencia.licencia FROM usuario ,licencia WHERE licencia ='".$_GET['licencia']." AND documento ='".$_GET['documento'].'"');
    $elim_usu -> execute([$documento, $licencia]);
    $eje_delete = $elim_usu ->fetch(PDO::FETCH_ASSOC);

    
    // if($eje_delete == true){
    //     echo '<script>alert ("Se elimino la licencia");</script>';
    //     // echo '<script>window.location="./index.php"</script>';
    // }

    }else{
        echo '<script>alert ("Se elimino la licencia");</script>';
        // echo '<script>window.location="./index.php"</script>';
    }

?>