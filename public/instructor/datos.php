<?php
require_once 'template.php';

$columnas = [];

$docu = $_SESSION['documento'];
// echo $docu;

if (isset($_SESSION['documento'])) {
    $consulta_tipo = $conn->prepare("SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, empresa.nit_empre, empresa.nom_empre FROM usuario INNER JOIN empresa ON empresa.nit_empre = usuario.nit_empre WHERE usuario.documento = :documento;");
    $consulta_tipo->bindParam(':documento', $_SESSION['documento']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["MM_register"]) && ($_POST["MM_register"] == "formRegister")) {
    // Imagen debe manejarse como archivo, no como texto plano
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    // Validación de campos vacíos
    if (empty($documento) || empty($nombre) || empty($apellido) || empty($correo)) {
        echo '<script>alert("Existen datos vacíos");</script>';
        echo '<script>window.location="datos.php"</script>';
    } else {
        // Actualización de registros
        $actu_update = $conn->prepare("UPDATE usuario SET documento = :nuevo_documento, nombre = :nombre, apellido = :apellido,  correo = :correo WHERE documento = :documento");

        $actu_update->bindParam(':nuevo_documento', $documento);
        $actu_update->bindParam(':nombre', $nombre);
        $actu_update->bindParam(':apellido', $apellido);
        $actu_update->bindParam(':correo', $correo);
        $actu_update->bindParam(':documento', $_POST['documento']); // Se mantiene como $_POST['documento']

        try {
            $actu_update->execute();
            echo '<script>alert("Actualización Exitosa ");</script>';
            echo '<script>window.location="./index.php"</script>';
            exit;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
    }
}


?>



<div class="content-wrapper">
    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <!-- Main content starts -->
        <div class="tab-list">
            <!-- Row Starts -->
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="card-header">

                        <div class="content-body container-table">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="registro_container">
                                        <!-- Formulario de Registro -->
                                        <form class="registro_form" name="formRegister" autocomplete="off" method="POST" id="formulario" enctype="multipart/form-data">


                                            <h1>Actualizar Datos de Aprendiz</h1>
                                            <br>

                                            <div class="form-group">
                                                <label>Nombre de Empresa</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo $columnas['nom_empre'] ?>" name="nom_empre" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Nombre de Instructor</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo $columnas['nombre'] ?>" name="nombre" title="Debe ser de 15 letras" required oninput="validarLetras(this)" required onkeyup="espacios(this)"  minlength="6" maxlength="12" pattern="[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*">
                                                <span id="errorNombre" style="color: red; display: none;">El nombre solo puede contener letras</span>
                                            </div>

                                            <div class="form-group">
                                                <label>Apellido de Instructor</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo $columnas['apellido'] ?>"  name="apellido" title="Debe ser de 15 letras" required oninput="validarLetras(this)" required onkeyup="espacios(this)"  minlength="6" maxlength="12" pattern="[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*">
                                                <span id="errorApellido" style="color: red; display: none;">El apellido solo puede contener letras</span>
                                            </div>

                                            <div class="form-group">
                                                <label>Numero de Documento de Instructor</label>
                                                <input type="text" placeholder="Ingrese Documento de Administrador" class="form-control" value="<?php echo $columnas['documento'] ?>" name="documento" title="Debe ser de 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength="10" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label> Correo de Instructor</label>
                                                <input type="email" placeholder="" class="form-control" value="<?php echo $columnas['correo'] ?>" name="correo" required onkeyup="espacios(this)" minlength="6" maxlength="25">
                                            </div>

                                            <div class="form-group">
                                                <label>Codigo de Barras</label>
                                                <img src="./../../images/<?= $columnas["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                <input type="varchar" placeholder="" class="form-control" value="<?php echo $columnas['codigo_barras'] ?>" name="codigo_barras" required readonly>
                                            </div>

                                            <input type="submit" name="MM_register" value="Actualizar" class="btn-primary"></input>
                                            <input type="hidden" name="MM_register" value="formRegister">

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var nombreInput = document.querySelector('input[name="nombre"]');
    var apellidoInput = document.querySelector('input[name="apellido"]');
    var errorNombre = document.getElementById('errorNombre');
    var errorApellido = document.getElementById('errorApellido');

    nombreInput.addEventListener('input', function() {
        var nombreValue = nombreInput.value.trim();
        var letrasValidas = /^[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*$/;

        if (!letrasValidas.test(nombreValue)) {
            errorNombre.style.display = 'block';
            nombreInput.setCustomValidity('El nombre solo puede contener letras');
        } else {
            errorNombre.style.display = 'none';
            nombreInput.setCustomValidity('');
        }
    });

    apellidoInput.addEventListener('input', function() {
        var apellidoValue = apellidoInput.value.trim();
        var letrasValidas = /^[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*$/;

        if (!letrasValidas.test(apellidoValue)) {
            errorApellido.style.display = 'block';
            apellidoInput.setCustomValidity('El apellido solo puede contener letras');
        } else {
            errorApellido.style.display = 'none';
            apellidoInput.setCustomValidity('');
        }
    });
});
</script>