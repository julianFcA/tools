<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();

$tip_docQuery = $conectar->prepare("SELECT id_tip_doc,tipo_doc FROM tip_doc");
$tip_docQuery->execute();
$tiposdoc = $tip_docQuery->fetchAll(PDO::FETCH_ASSOC);

$tip_forQuery = $conectar->prepare("SELECT id_formacion,formacion FROM formacion");
$tip_forQuery->execute();
$tiposfor = $tip_forQuery->fetchAll(PDO::FETCH_ASSOC);




if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formreg") {
    // Obtener datos del formulario
    $documento = $_POST["documento"];
    $contrasena = $_POST["contrasena"];
    $nombre = $_POST["nombre"];
    $id_tip_doc = $_POST["id_tip_doc"];
    $email = $_POST["email"];
    $ficha = $_POST["id_relacionados"];
    $tyc = $_POST["tyc"];


    $validar = $conectar->prepare("SELECT * FROM usuario WHERE documento = '$documento'");
    $validar->execute();
    $fila1 = $validar->fetch();

    if ($documento == "" || $nombre == "" || $contrasena == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="regis.php"</script>';
    } else if ($tyc == "") {
        echo '<script>alert("Debes aceptar los terminos y condiciones");</script>';
        echo '<script>window location="regis.php"</script>';
    } elseif ($fila1) {
        echo '<script>alert("Documento existente");</script>';
        echo '<script>window.location="lista_instructor.php.php"</script>';
    } else {
        $encriptar = password_hash($contrasena, PASSWORD_BCRYPT, ["cost" => 15]);

        // Ajusta la consulta para insertar en tu nueva tabla
        $insertsql = $conectar->prepare("INSERT INTO usuario (documento, contraseña, nombre, id_tip_doc, email, id_rol, estado, nit, tyc) 
    VALUES (:documento, :contrasena, :nombre, :id_tip_doc, :email, 4, 'activo',123456789,:tyc)");

        $insertdeta = $conectar->prepare("INSERT INTO detalle_instructor(documento,ficha) VALUES (?, ?)");
        $insertdeta->execute([$documento, $ficha]);

        $insertsql->bindParam(':documento', $documento);
        $insertsql->bindParam(':contrasena', $encriptar);
        $insertsql->bindParam(':nombre', $nombre);
        $insertsql->bindParam(':id_tip_doc', $id_tip_doc);
        $insertsql->bindParam(':email', $email);
        $insertsql->bindParam(':tyc', $tyc);

        $insertsql->execute();
        
        echo '<script>alert ("Registro Exitoso");</script>';
        echo '<script> window.location= "lista.php"</script>';
    }
}
?>






<?php
require_once './../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();

$tip_forQuery = $conectar->prepare("SELECT id_formacion,formacion FROM formacion");
$tip_forQuery->execute();
$tiposfor = $tip_forQuery->fetchAll(PDO::FETCH_ASSOC);

$tip_docQuery = $conectar->prepare("SELECT * FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE rol.id_rol = 4");
$tip_docQuery->execute();
$tiposdoc = $tip_docQuery->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formreg") {
    // Obtener datos del formulario
    $documento = $_POST["documento"];
    $ficha = $_POST["id_relacionados"];

    if ($documento == "" || $ficha == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="asignacion_instructor.php"</script>';
    }
    else {

        $insertdeta = $conectar->prepare("INSERT INTO detalle_instructor(documento,ficha) VALUES (?, ?)");
        $insertdeta->execute([$documento, $ficha]);
        
        echo '<script>alert ("Registro Exitoso");</script>';
        echo '<script> window.location= "lista_instructores.php"</script>';
    }
}
?>