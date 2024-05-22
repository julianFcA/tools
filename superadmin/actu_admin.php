<?php
require_once 'template.php';

$columnas = [];

if (isset($_POST['documento'])) {
    $consulta_tipo = $conn->prepare("SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, empresa.nit_empre, empresa.nom_empre FROM usuario INNER JOIN empresa ON empresa.nit_empre = usuario.nit_empre WHERE usuario.documento = :documento;");
    $consulta_tipo->bindParam(':documento', $_POST['documento']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    $errors = [];

    if (strlen($documento) < 8 || strlen($documento) > 10 || !is_numeric($documento)) {
        $errors[] = "Documento debe contener entre 8 y 10 dígitos numéricos.";
    }

    if (strlen($nombre) < 3 || strlen($nombre) > 12) {
        $errors[] = "Nombre debe tener entre 3 y 12 caracteres.";
    }

    if (strlen($apellido) < 3 || strlen($apellido) > 15) {
        $errors[] = "El apellido debe tener entre 3 y 15 caracteres.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Correo electrónico no válido.";
    }

    if (empty($documento) || empty($nombre) || empty($apellido) || empty($correo)) {
        $errors[] = "Existen datos vacíos.";
    }

    if (empty($errors)) {
        $actu_update = $conn->prepare("UPDATE usuario SET nombre = :nombre, apellido = :apellido, correo = :correo WHERE documento = :documento");

        $actu_update->bindParam(':nombre', $nombre);
        $actu_update->bindParam(':apellido', $apellido);
        $actu_update->bindParam(':correo', $correo);
        $actu_update->bindParam(':documento', $documento);

        try {
            $actu_update->execute();
            echo '<script>alert("Actualización Exitosa "); window.location="./index.php";</script>';
            exit;
        } catch (PDOException $e) {
            echo '<script>alert("Error al ejecutar la consulta: ' . $e->getMessage() . '"); window.location="actu_admin.php";</script>';
        }
    } else {
        foreach ($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }
        echo '<script>window.location="actu_admin.php";</script>';
    }
}
?>

<div class="registro_container">
    <form class="registro_form" name="formRegister" autocomplete="off" method="POST" id="formulario">
        <h1>Actualizar Datos de Administrador de Empresa</h1>
        <br>
        <div class="form-group">
            <label>Nit de Empresa</label>
            <input type="text" class="form-control" value="<?php echo $columnas['nit_empre'] ?? ''; ?>" name="nit_empre" required readonly>
        </div>

        <div class="form-group">
            <label>Nombre de Empresa</label>
            <input type="text" class="form-control" value="<?php echo $columnas['nom_empre'] ?? ''; ?>" name="nom_empre" readonly>
        </div>

        <div class="form-group">
            <label>Nombre de Administrador</label>
            <input type="text" class="form-control" value="<?php echo $columnas['nombre'] ?? ''; ?>" name="nombre" required minlength="3" maxlength="12" pattern="[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*">
            <span id="errorNombre" style="color: red; display: none;">El nombre solo puede contener letras</span>
        </div>

        <div class="form-group">
            <label>Apellido de Administrador</label>
            <input type="text" class="form-control" value="<?php echo $columnas['apellido'] ?? ''; ?>" name="apellido" required minlength="3" maxlength="15" pattern="[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*">
            <span id="errorApellido" style="color: red; display: none;">El apellido solo puede contener letras</span>
        </div>

        <div class="form-group">
            <label>Número de Documento de Administrador</label>
            <input type="text" class="form-control" value="<?php echo $columnas['documento'] ?? ''; ?>" name="documento" required minlength="8" maxlength="10" readonly>
        </div>

        <div class="form-group">
            <label>Correo de Administrador</label>
            <input type="email" class="form-control" value="<?php echo $columnas['correo'] ?? ''; ?>" name="correo" required minlength="6" maxlength="25">
        </div>

        <div class="form-group">
            <label>Código de Barras</label>
            <img src="../images/<?php echo $columnas['codigo_barras'] ?? ''; ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
            <input type="text" class="form-control" value="<?php echo $columnas['codigo_barras'] ?? ''; ?>" name="codigo_barras" required readonly>
        </div>

        <input type="submit" name="MM_register" value="Actualizar" class="btn-primary">
        <input type="hidden" name="MM_register" value="formRegister">

        <div class="redirecciones">
            <a href="./index.php" class="link return">Regresar</a>
        </div>
    </form>
</div>
