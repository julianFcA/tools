<?php
require_once 'template.php';

$columnas = [];

if (isset($_POST['nit_empre'])) {
    $consulta_tipo = $conn->prepare("SELECT emp.nit_empre, emp.nom_empre, emp.direcc_empre, emp.telefono, emp.correo_empre FROM empresa AS emp WHERE emp.nit_empre = :nit_empre;");
    $consulta_tipo->bindParam(':nit_empre', $_POST['nit_empre']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC); // Modificación aquí
}

if (isset($_POST["MM_register"]) && ($_POST["MM_register"] == "formRegister")) { // Modificación aquí
    $nom_empre = $_POST['nom_empre'];
    $direcc_empre = $_POST['direcc_empre'];
    $telefono = $_POST['telefono'];
    $correo_empre = $_POST['correo_empre'];

    // Validación de campos vacíos
    if (empty($nom_empre) || empty($direcc_empre) || empty($telefono) || empty($correo_empre)) {
        echo '<script>alert("Existen datos vacíos");</script>';
        echo '<script>window.location="actu_empre.php"</script>';
    } else {
        // Actualización de registros
        $actu_update = $conn->prepare("UPDATE empresa SET nom_empre = :nom_empre, direcc_empre = :direcc_empre, telefono = :telefono, correo_empre = :correo_empre WHERE nit_empre = :nit_empre");

        $actu_update->bindParam(':nom_empre', $nom_empre);
        $actu_update->bindParam(':direcc_empre', $direcc_empre);
        $actu_update->bindParam(':telefono', $telefono);
        $actu_update->bindParam(':correo_empre', $correo_empre);
        $actu_update->bindParam(':nit_empre', $_POST['nit_empre']);
        $actu_update->execute();

        echo '<script>alert("Actualización Exitosa ");</script>';
        echo '<script>window.location="./index.php"</script>';
        exit;
    }
}

?>

<div class="registro_container">
    <!-- Formulario de Registro -->
    <form class="registro_form" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario" enctype="multipart/form-data">

        <h1>Actulizar Datos de Empresa</h1>
        <div class="form-group">
            <label>Nit de Empresa</label>
            <input type="varchar" placeholder="Ingrese Nit de Empresa" class="form-control" value="<?php echo $columnas['nit_empre'] ?>" name="nit_empre" title="Debe ser de 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength=" 9 a 10" required readonly>
        </div>

        <div class="form-group">
            <label>Nombre de Empresa</label>
            <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" value="<?php echo $columnas['nom_empre'] ?>" name="nom_empre" title="Debe ser de 15 letras" required oninput="validarLetras(this)" minlength="6" maxlength="20">
        </div>

        <div class="form-group">
            <label>Dirección de Empresa</label>
            <input type="varchar" placeholder="Ingrese Direccion de Empresa" class="form-control" value="<?php echo $columnas['direcc_empre'] ?>" name="direcc_empre" title="Debe ser de 30 letras" required oninput="validarLetras(this)" minlength="6" maxlength="30">
        </div>

        <div class="form-group">
            <label> Telefono de Empresa</label>
            <input type="number" placeholder="Ingrese Telefono de Empresa" class="form-control" value="<?php echo $columnas['telefono'] ?>" name="telefono" required onkeyup="espacios(this)" minlength="8" maxlength="12">
        </div>

        <div class="form-group">
            <label> Correo de Empresa</label>
            <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" value="<?php echo $columnas['correo_empre'] ?>" name="correo_empre" required onkeyup="espacios(this)" minlength="10" maxlength="40">
        </div>

        <input type="submit" name="MM_register" value="Actualizar" class="btn-primary"></input>
        <input type="hidden" name="MM_register" value="formRegister">

        <div class="redirecciones">
            <a href="./index.php" class="link return">Regresar</a>
        </div>
    </form>
</div>