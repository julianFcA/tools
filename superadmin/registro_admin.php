<?php
require_once 'template.php';

require_once './../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;


// Código para obtener datos previos a la inserción
$consulta2 = $conn->prepare("SELECT nom_tp_docu, id_tp_docu FROM tp_docu WHERE id_tp_docu > 1 ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta4 = $conn->prepare("SELECT nom_rol, id_rol FROM rol WHERE id_rol = 1 ");
$consulta4->execute();
$consullll = $consulta4->fetchAll(PDO::FETCH_ASSOC);

$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll = $consulta5->fetchAll(PDO::FETCH_ASSOC);

$consulta6 = $conn->prepare("SELECT nom_empre, nit_empre FROM empresa WHERE nit_empre > 0 ");
$consulta6->execute();
$consullllll = $consulta6->fetchAll(PDO::FETCH_ASSOC);

$consulta7 = $conn->prepare("SELECT terminos FROM usuario ");
$consulta7->execute();
$consult = $consulta7->fetch(PDO::FETCH_ASSOC);

// Verificar si se ha enviado el formulario de registro
if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    // Obtener datos del formulario
    $documento = isset($_POST['documento']) ? $_POST['documento'] : "";
    $id_tp_docu = isset($_POST['id_tp_docu']) ? $_POST['id_tp_docu'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";
    $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
    $terminos = isset($_POST['terminos']) ? 1 : 0;
    $id_esta_usu = isset($_POST['id_esta_usu']) ? $_POST['id_esta_usu'] : "";
    $id_rol = isset($_POST['id_rol']) ? $_POST['id_rol'] : "";
    $nit_empre = isset($_POST['nit_empre']) ? $_POST['nit_empre'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($documento) !== 10 || !is_numeric($documento)) {
        echo '<script>alert("Documento debe tener 10 dígitos numéricos.");</script>';
        echo '<script>window.location = "./registro_admin.php";</script>';
    } elseif (strlen($nombre) < 6 || strlen($nombre) > 12) {
        echo '<script>alert("Nombre debe tener entre 6 y 12 caracteres.");</script>';
        echo '<script>window.location = "./registro_admin.php";</script>';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Correo electrónico no válido.");</script>';
        echo '<script>window.location = "./registro_admin.php";</script>';
    } else {
        // Prepara y ejecuta la consulta para verificar si el tipo de documento existe
        $stmtCheckTypeDoc = $conn->prepare("SELECT id_tp_docu FROM usuario WHERE id_tp_docu = ?");
        $stmtCheckTypeDoc->bindParam(1, $id_tp_docu, PDO::PARAM_INT);
        $stmtCheckTypeDoc->execute();
        $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

        // Prepara y ejecuta la consulta para verificar si el documento ya existe
        $stmtCheckDocument = $conn->prepare("SELECT documento FROM usuario WHERE documento = ?");
        $stmtCheckDocument->bindParam(1, $documento, PDO::PARAM_STR);
        $stmtCheckDocument->execute();
        $resultCheckDocument = $stmtCheckDocument->fetch(PDO::FETCH_ASSOC);

        // Verificar si el documento ya existe en la base de datos
        if ($resultCheckDocument) {
            // El documento ya existe en la base de datos, mostrar mensaje emergente con JavaScript
            echo '<script>alert("El documento ingresado ya está registrado.");</script>';
            echo '<script>window.location = "./registro_admin.php";</script>';
        } else {
            // El documento no existe en la base de datos, proceder con la inserción
            // Generar código de barras
            $codigo_barras = uniqid() . rand(1000, 9999);
            $generator = new BarcodeGeneratorPNG();
            $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);
            file_put_contents(__DIR__ . '/../images/' . $codigo_barras . '.png', $codigo_barras_imagen);

            // Hashear contraseña
            $user_password = password_hash($contrasena, PASSWORD_DEFAULT);
            if ($user_password === false) {
                echo '<script>alert("Error al hashear la contraseña.");</script>';
                echo '<script>window.location = "./registro_admin.php";</script>';
            } else {
                // Fecha de registro
                $fecha_registro = date("Y-m-d H:i:s");
                // Inserción en la base de datos
                $stmt = $conn->prepare("INSERT INTO usuario (documento, id_tp_docu, nombre, apellido, contrasena, correo, codigo_barras, fecha_registro, terminos, id_rol, id_esta_usu, nit_empre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                // Ejecutar inserción
                $stmt->execute([$documento, $id_tp_docu, $nombre, $apellido, $user_password, $correo, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre]);
                echo '<script>alert("Registro exitoso.");</script>';
                echo '<script>window.location = "./index.php";</script>';
            }
        }
    }
}
// }
?>




<div class="registro_container">
    <!-- Formulario de Registro -->
    <form class=" formulario-grande registro_form" action="registro_admin.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario" onsubmit="return validarContraseña()">

        <h1>Registro de Administrador </h1>
        <div class="form-group">
            <label>Tipo de Documento</label>
            <select class="form-control" name="id_tp_docu" required>
                <?php foreach ($consull as $row) : ?>
                    <option value="<?php echo $row['id_tp_docu']; ?>"><?php echo $row['nom_tp_docu']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Documento</label>
            <input type="number" placeholder="Ingrese Documento" class="form-control" name="documento" title="Debe ser de 10 dígitos" required minlength="7" maxlength="10">
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" placeholder="Ingrese primer nombre" class="form-control" name="nombre" title="Debe ser de 3 a 15 letras" required minlength="3" maxlength="15">
        </div>

        <div class="form-group">
            <label>Apellido</label>
            <input type="text" placeholder="Ingrese primer apellido" class="form-control" name="apellido" title="Debe ser de 3 a 15 letras" required minlength="3" maxlength="15">
        </div>

        <div class="form-group">
            <label> Correo</label>
            <input type="email" placeholder="Ingrese correo" class="form-control" name="correo" required minlength="6" maxlength="25">
        </div>

        <div class="form-group">
            <label>Rol</label>
            <select class="form-control" name="id_rol" required>
                <?php foreach ($consullll as $row) : ?>
                    <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nom_rol']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" placeholder="Estado" readonly class="form-control" value="1" name="id_esta_usu">

        <div class="group-material">
            <label>Fecha de Registro</label>
            <input type="text" name="fecha_registro" class="material-control tooltips-general" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>

        <div class="form-group">
            <label>Empresa</label>
            <select class="form-control" name="nit_empre" required>
                <?php foreach ($consullllll as $row) : ?>
                    <option value="<?php echo $row['nit_empre']; ?>"><?php echo $row['nom_empre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="contrase"> Contraseña</label>
            <div class="input-group">
                <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena" class="form-control clave" title="Debe tener de 6 a 12 dígitos" required minlength="6" maxlength="12" >
            </div>
        </div>

        <div class="form-group">
            <div class="overlay-terminos" id="overlay-terminos">
                <div class="container-terminos">
                    <span class="close-btn-terminos" onclick="closeOverlayTerminos()">X</span>
                    <h1>Términos y Condiciones</h1>
                    <p>Estos son los términos y condiciones para el uso de la aplicación de préstamos de herramientas:</p>
                    <ol>
                        <li><strong>Uso Aceptable:</strong> Al utilizar esta aplicación, aceptas utilizarla de manera ética y legal. No debes usar la aplicación con fines ilegales o dañinos.</li>
                        <li><strong>Registro:</strong> Para acceder a la funcionalidad completa de la aplicación, es posible que debas registrarte proporcionando información precisa y actualizada.</li>
                        <li><strong>Préstamos:</strong> El préstamo de herramientas está sujeto a disponibilidad y a las reglas establecidas por la aplicación. Asegúrate de cumplir con las fechas y condiciones acordadas.</li>
                        <li><strong>Responsabilidad:</strong> La aplicación y sus desarrolladores no se hacen responsables de cualquier daño o pérdida resultante del uso de la aplicación o de las herramientas prestadas.</li>
                    </ol>
                    <p>Al utilizar esta aplicación, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo con estos términos, por favor, no utilices la aplicación.</p>
                    <input type="checkbox" class="form-control" id="checkboxTerminos" name="terminos" <?php echo ($consult && $consult['terminos'] == '1') ? 'checked' : ''; ?> required>
                </div>
            </div>
            <br>
            <button class="btn-success" type="button" onclick="openOverlayTerminos()">Acepto Términos y Condiciones</button>
        </div>

        <input type="submit" name="MM_register" value="Registrar" class="btn-primary"></input>
        <input type="hidden" name="MM_register" value="formRegister">

    </form>
</div>