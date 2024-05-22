<?php
require_once 'template.php';

$columnas = [];

if (isset($_POST['nit_empre'])) {
    $consulta_tipo = $conn->prepare("SELECT nit_empre, nom_empre, direcc_empre, telefono, correo_empre FROM empresa WHERE nit_empre = :nit_empre;");
    $consulta_tipo->bindParam(':nit_empre', $_POST['nit_empre']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nit_empre = $_POST['nit_empre'];
    $nom_empre = $_POST['nom_empre'];
    $direcc_empre = $_POST['direcc_empre'];
    $telefono = $_POST['telefono'];
    $correo_empre = $_POST['correo_empre'];

    $errors = [];

    if (strlen($nit_empre) < 8 || strlen($nit_empre) > 12) {
        $errors[] = "El NIT debe contener entre 8 y 12 caracteres.";
    }

    if (strlen($nom_empre) < 3 || strlen($nom_empre) > 30) {
        $errors[] = "El nombre de la empresa debe tener entre 3 y 30 caracteres.";
    }

    if (strlen($direcc_empre) < 3 || strlen($direcc_empre) > 40) {
        $errors[] = "La dirección debe tener entre 3 y 40 caracteres.";
    }

    if (strlen($telefono) < 7 || strlen($telefono) > 13) {
        $errors[] = "El teléfono debe tener entre 8 y 13 caracteres.";
    }

    if (!filter_var($correo_empre, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Correo electrónico no válido.";
    }

    if (empty($nit_empre) || empty($nom_empre) || empty($direcc_empre) || empty($telefono) || empty($correo_empre)) {
        $errors[] = "Existen datos vacíos.";
    }

    if (empty($errors)) {
        $actu_update = $conn->prepare("UPDATE empresa SET nom_empre = :nom_empre, direcc_empre = :direcc_empre, telefono = :telefono, correo_empre = :correo_empre WHERE nit_empre = :nit_empre");

        $actu_update->bindParam(':nom_empre', $nom_empre);
        $actu_update->bindParam(':direcc_empre', $direcc_empre);
        $actu_update->bindParam(':telefono', $telefono);
        $actu_update->bindParam(':correo_empre', $correo_empre);
        $actu_update->bindParam(':nit_empre', $nit_empre);
        $actu_update->execute();

        echo '<script>alert("Actualización exitosa"); window.location="./index.php";</script>';
        exit;
    } else {
        foreach ($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }
        echo '<script>window.location="actu_empre.php";</script>';
    }
}
?>

<div class="registro_container">
    <form class="registro_form" name="formRegister" autocomplete="off" method="POST" id="formulario" enctype="multipart/form-data">
        <h1>Actualizar Datos de Empresa</h1>
        <div class="form-group">
            <label>Nit de Empresa</label>
            <input type="text" placeholder="Ingrese Nit de Empresa" class="form-control" value="<?php echo $columnas['nit_empre'] ?? '' ?>" name="nit_empre" title="Debe ser de 10 dígitos" required readonly>
        </div>

        <div class="form-group">
            <label>Nombre de Empresa</label>
            <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" value="<?php echo $columnas['nom_empre'] ?? '' ?>" name="nom_empre" title="Debe ser de 3 a 30 letras" required minlength="3" maxlength="30">
        </div>

        <div class="form-group">
            <label>Dirección de Empresa</label>
            <input type="text" placeholder="Ingrese Dirección de Empresa" class="form-control" value="<?php echo $columnas['direcc_empre'] ?? '' ?>" name="direcc_empre" title="Debe ser de 3 a 40 letras" required minlength="3" maxlength="40">
        </div>

        <div class="form-group">
            <label>Teléfono de Empresa</label>
            <input type="text" placeholder="Ingrese Teléfono de Empresa" class="form-control" value="<?php echo $columnas['telefono'] ?? '' ?>" name="telefono" required minlength="8" maxlength="13">
        </div>

        <div class="form-group">
            <label>Correo de Empresa</label>
            <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" value="<?php echo $columnas['correo_empre'] ?? '' ?>" name="correo_empre" required minlength="10" maxlength="40">
        </div>

        <input type="submit" name="MM_register" value="Actualizar" class="btn-primary">
        <input type="hidden" name="MM_register" value="formRegister">

        <div class="redirecciones">
            <a href="./index.php" class="link return">Regresar</a>
        </div>
    </form>
</div>
