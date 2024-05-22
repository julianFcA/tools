<?php
require_once 'template.php';

$columnas = [];

if (isset($_GET['codigo_barra_herra'])) {
    $consulta_tipo = $conn->prepare("SELECT herramienta.codigo_barra_herra, herramienta.id_tp_herra, herramienta.nombre_herra, herramienta.descripcion, herramienta.cantidad, herramienta.imagen, herramienta.esta_herra, tp_herra.nom_tp_herra, marca_herra.nom_marca FROM herramienta INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra INNER JOIN marca_herra ON marca_herra.id_marca = herramienta.id_marca WHERE herramienta.codigo_barra_herra = :codigo_barra_herra");
    $consulta_tipo->bindParam(':codigo_barra_herra', $_GET['codigo_barra_herra']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

// (isset($_POST["MM_insert"]) && ($_POST["MM_insert"] == "formreg")) 

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verificar si se envió el formulario correctamente
    $nombre_herra = $_POST['nombre_herra'];
    $marca = $_POST['marca'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    if (strlen($nombre_herra) < 3 || strlen($nombre_herra) > 20) {
        echo '<script>alert("Nombre de herramienta debe tener entre 3 y 20 caracteres.");</script>';
        echo '<script>window.location = "./actu_herra.php";</script>';
    } elseif (strlen($descripcion) < 6 || strlen($descripcion) > 30) {
        echo '<script>alert("Descripción debe tener entre 6 y 30 caracteres.");</script>';
        echo '<script>window.location = "./actu_herra.php";</script>';
    }

    // Validación de campos vacíos
    if (empty($nombre_herra) || empty($marca) || empty($descripcion) || empty($cantidad )){
        echo '<script>alert("Existen datos vacíos");</script>';
        echo '<script>window.location="actu_herra.php"</script>';
        
    } else {
        // Verificar si se cargó un nuevo archivo de imagen
        if (!empty($_FILES['imagen']['name'])) {
            // Si se cargó un nuevo archivo de imagen
            $imagen = $_FILES['imagen']['name'];
            $ruta_destino = '../../images/' . $imagen;

            // Mover la nueva imagen cargada al directorio deseado
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino);
        } else {
            // Si no se cargó un nuevo archivo de imagen, utilizar la imagen actual
            $imagen = $_POST['imagen_actual'];
        }

        // Asignar valor para :esta_herra
        $esta_herra = $_POST['esta_herra'];

        // Actualización de registros
        $actu_update = $conn->prepare("UPDATE herramienta SET nombre_herra = :nombre_herra, descripcion = :descripcion, imagen = :imagen, cantidad = :cantidad, esta_herra = :esta_herra WHERE codigo_barra_herra = :codigo_barra_herra");

        $actu_update->bindParam(':nombre_herra', $nombre_herra);
        $actu_update->bindParam(':descripcion', $descripcion);
        $actu_update->bindParam(':cantidad', $cantidad);
        $actu_update->bindParam(':imagen', $imagen); // Ruta de la imagen
        $actu_update->bindParam(':esta_herra', $esta_herra); // Estado de la herramienta
        $actu_update->bindParam(':codigo_barra_herra', $_POST['codigo_barra_herra']); // Código de barras

        $actu_update->execute();

        echo '<script>alert("Actualización Exitosa ");</script>';
        echo '<script>window.location="./herramienta.php"</script>';
        exit;
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

                                            <h1>Actualizar Datos de Herramienta</h1>
                                            <div class="form-group">
                                                <label>Código de Barras de Herramienta</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo $columnas['codigo_barra_herra'] ?>" name="codigo_barra_herra" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Tipo de Herramienta</label>
                                                <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" value="<?php echo $columnas['nom_tp_herra'] ?>" name="nom_tp_herra" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Nombre de Herramienta</label>
                                                <input type="text" placeholder="Ingrese Nombre de Herramienta" class="form-control" value="<?php echo $columnas['nombre_herra'] ?>"  name="nombre_herra" title="Debe ser de 20 letras" required minlength="6" maxlength="20" oninput="validarLetras(this)">
                                            </div>

                                            <div class="form-group">
                                                <label>Marca</label>
                                                <input type="text" placeholder="Ingrese Marca de Herramienta" class="form-control" value="<?php echo $columnas['nom_marca'] ?>" name="marca" onkeyup="espacios(this)" minlength="4" maxlength="12" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="number" placeholder="Ingrese Marca de Herramienta" class="form-control" value="<?php echo $columnas['cantidad'] ?>" name="cantidad" onkeyup="espacios(this)" minlength="4" maxlength="12">
                                            </div>

                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <input type="text" placeholder="Ingrese Descripción de Herramienta" class="form-control" value="<?php echo $columnas['descripcion'] ?>" name="descripcion" required onkeyup="espacios(this)" minlength="10" maxlength="40">
                                            </div>

                                            <div class="form-group">
                                                <label>Imagen</label>
                                                <input type="file" name="imagen" class="material-control tooltips-general">
                                                <input type="hidden" name="imagen_actual" value="<?= $columnas["imagen"] ?>">
                                                <div class="image-container">
                                                    <?php $imageUrl = '../../images/' . $columnas["imagen"]; ?>
                                                    <img src="<?= $imageUrl ?>" alt="Imagen de herramienta">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Estado de la Herramienta</label>
                                                <input type="text" placeholder="Estado de la Herramienta" class="form-control" value="<?php echo $columnas['esta_herra'] ?>" name="esta_herra" readonly>
                                            </div>

                                            <input type="submit" name="MM_register" value="Actualizar" class="btn-primary">
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
    function validarLetras(input) {
        // Remover cualquier caracter que no sea una letra
        input.value = input.value.replace(/[^a-zA-Z]/g, '');
    }


    function validarNumeros(input) {
            // Remover cualquier caracter que no sea un número
            input.value = input.value.replace(/[^\d]/g, '');
        }
</script>