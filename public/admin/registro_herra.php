<?php
require_once 'template.php';

require_once '../../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

// Asegúrate de tener la conexión a la base de datos $conn correctamente configurada

$consulta2 = $conn->prepare("SELECT * FROM tp_herra ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = $conn->prepare("SELECT * FROM marca_herra ");
$consulta3->execute();
$consulll = $consulta3->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $id_tp_herra = isset($_POST['id_tp_herra']) ? $_POST['id_tp_herra'] : "";
    $nombre_herra = isset($_POST['nombre_herra']) ? $_POST['nombre_herra'] : "";
    $id_marca = isset($_POST['id_marca']) ? $_POST['id_marca'] : "";
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $esta_herra = isset($_POST['esta_herra']) ? $_POST['esta_herra'] : "";

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];

        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($imagen['type'], $allowed_types)) {
            echo '<script>alert("Solo se permiten archivos de imagen JPG o PNG.");</script>';
            echo '<script>window.location="./registro_herra.php";</script>';
            exit;
        }

        if ($imagen['size'] > 400000) {
            echo '<script>alert("El tamaño del archivo no puede exceder los 400kb.");</script>';
            echo '<script>window.location="./registro_herra.php";</script>';
            exit;
        }

        // Ruta relativa de la carpeta de destino de las imágenes basada en la ubicación del script actual
        $target_dir = dirname(__FILE__) . "/../../images/";
        $imagen_nombre = basename($imagen["name"]);
        $target_file = $target_dir . $imagen_nombre;
        if (!move_uploaded_file($imagen["tmp_name"], $target_file)) {
            echo '<script>alert("Hubo un error al cargar la imagen.");</script>';
            echo '<script>window.location="./registro_herra.php";</script>';
            exit;
        }
    } else {
        echo '<script>alert("No se recibió ninguna imagen o hubo un error al cargarla.");</script>';
        echo '<script>window.location="./registro_herra.php";</script>';
        exit;
    }

    // Validaciones adicionales en el lado del servidor
    if (strlen($nombre_herra) < 6 || strlen($nombre_herra) > 20) {
        echo '<script>alert("Nombre de herramienta debe tener entre 6 y 20 caracteres.");</script>';
        echo '<script>window.location = "./registro_herra.php";</script>';
    } elseif (strlen($descripcion) < 6 || strlen($descripcion) > 30) {
        echo '<script>alert("Descripción debe tener entre 6 y 30 caracteres.");</script>';
        echo '<script>window.location = "./registro_herra.php";</script>';
    } else {
        // Prepara y ejecuta la consulta para verificar si el tipo de documento existe
        $stmtCheckTypeDoc = $conn->prepare("SELECT id_tp_herra FROM herramienta WHERE id_tp_herra = ?");
        $stmtCheckTypeDoc->bindParam(1, $id_tp_herra, PDO::PARAM_INT);
        $stmtCheckTypeDoc->execute();
        $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

        $stmtCheckType = $conn->prepare("SELECT id_marca FROM herramienta WHERE id_marca = ?");
        $stmtCheckType->bindParam(1, $id_marca, PDO::PARAM_INT);
        $stmtCheckType->execute();
        $resultCheckType = $stmtCheckType->fetch(PDO::FETCH_ASSOC);

        $codigo_barra_herra = uniqid() . rand(1000, 9999);
        $generator = new BarcodeGeneratorPNG();
        $codigo_barras_imagen = $generator->getBarcode($codigo_barra_herra, $generator::TYPE_CODE_128);
        file_put_contents(__DIR__ . '/../../images/' . $codigo_barra_herra . '.png', $codigo_barras_imagen);

        // Guarda el nombre generado aleatoriamente de la imagen en una variable
        $codigo_barra_herra . '.png';

        $imagen_nombre = basename($imagen["name"]);

        // Se elimina NOW() de los valores
        $stmt = $conn->prepare("INSERT INTO herramienta (codigo_barra_herra, id_tp_herra, nombre_herra, id_marca, cantidad, descripcion, imagen, esta_herra) VALUES (?, ?, ?, ?, ?, ?, ?,?)");

        // Asegúrate de que el número de parámetros coincide con el número de '?' en la consulta
        $stmt->execute([$codigo_barra_herra, $id_tp_herra, $nombre_herra, $id_marca, $cantidad, $descripcion, $imagen_nombre, $esta_herra]);

        echo '<script>alert("Registro exitoso.");</script>';
        echo '<script>window.location = "./herramienta.php";</script>';
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
                                        <form class="registro_form" action="registro_herra.php" name="formRegister" autocomplete="off" method="POST" id="formulario" enctype="multipart/form-data">

                                            <h1>Registro de Herramienta</h1>
                                            <br>
                                            <div class="form-group">
                                                <label>Tipo de Herramienta <a href="./regis_tp_herra.php" style="color: orange;">Crear Tipo de Herramienta</a></label>
                                                <select class="form-control" name="id_tp_herra" required>
                                                    <?php foreach ($consull as $row) : ?>
                                                        <option value="<?php echo $row['id_tp_herra']; ?>"><?php echo $row['nom_tp_herra']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nombre de Herramienta</label>
                                                <input type="text" placeholder="Ingrese Nombre de Herramienta" class="form-control" name="nombre_herra" title="Debe ser de 20 letras" required minlength="6" maxlength="20">
                                            </div>

                                            <div class="form-group">
                                                <label>Marca <a href="./regis_marca.php" style="color: orange;">Crear Marca de Herramienta</a></label>
                                                <select class="form-control" name="id_marca" required>
                                                    <?php foreach ($consulll as $row) : ?>
                                                        <option value="<?php echo $row['id_marca']; ?>"><?php echo $row['nom_marca']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="number" placeholder="Ingrese Cantidad de Herramienta" class="form-control" name="cantidad" title="Debe ser una cantidad de entre 1 o 3 cifras" required minlength="1" maxlength="4">
                                            </div>

                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <input type="text" placeholder="Ingrese Descripción de Herramienta" class="form-control" name="descripcion" title="Debe ser de 30 letras" required minlength="6" maxlength="30">
                                            </div>

                                            <div class="form-group">
                                                <label>Imagen de Herramienta</label>
                                                <input type="file" name="imagen" class="form-control" placeholder="Ingrese Imagen">
                                            </div>

                                            <input type="hidden" placeholder="Estado" readonly class="form-control" value="disponible" name="esta_herra">

                                            <input type="submit" name="MM_register" value="Registrar Herramienta" class="btn-primary">
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