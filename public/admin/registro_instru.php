<?php
require_once 'template.php';
require_once '../../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$consulta2 = $conn->prepare("SELECT nom_tp_docu, id_tp_docu FROM tp_docu WHERE id_tp_docu > 1 ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = $conn->prepare("SELECT id_rol, nom_rol FROM rol WHERE id_rol = 2 ");
$consulta3->execute();
$consulll = $consulta3->fetchAll(PDO::FETCH_ASSOC);



$nom_forma = isset($_POST['nom_forma']) ? $_POST['nom_forma'] : null;

if ($nom_forma !== null) {
    // Consulta para obtener las opciones de formación asociadas a la ficha seleccionada
    $statement = $conn->prepare("SELECT * FROM ficha INNER JOIN formacion ON formacion.id_forma = ficha.id_forma INNER JOIN jornada ON jornada.id_jornada = ficha.id_jornada WHERE ficha.id_forma = ?");

    $statement->execute([$nom_forma]);

    $cadena = "<label>Ficha</label><br><select id='ficha' name='ficha'>";
    $cadena1 = "<label>Jornada</label><br><select id='tp_jornada' name='tp_jornada'>";

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $cadena .= "<option value='" . $row['ficha'] . "'>" . $row['ficha'] . "</option>";
        $cadena1 .= "<option value='" . $row['id_jornada'] . "'>" . $row['tp_jornada'] . "</option>";
    }

    $cadena .= "</select>"; // Cerrar la etiqueta select
    $cadena1 .= "</select>";
    echo $cadena . $cadena1; // Imprime ambas cadenas juntas
} 




$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll = $consulta5->fetchAll(PDO::FETCH_ASSOC);


// Asignar un valor por defecto para $nit_empres
$nit_empres = "";

// Verificar si hay una sesión iniciada y obtener el nit_empre de la sesión
if (isset($_SESSION['nit_empre'])) {
    $nit_empres = $_SESSION['nit_empre'];

    // Preparar la consulta SQL para obtener el nombre de la empresa asociada al nit_empre
    $consulta6 = $conn->prepare("SELECT nom_empre, nit_empre FROM empresa WHERE nit_empre = :nit_empre");
    // Vincular el parámetro :nit_empre con el valor de $nit_empres
    $consulta6->bindParam(':nit_empre', $nit_empres);
    // Ejecutar la consulta
    $consulta6->execute();
    // Obtener los resultados
    $resultados = $consulta6->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron resultados
    if ($resultados) {
        // La consulta devolvió resultados, puedes trabajar con ellos aquí
        foreach ($resultados as $fila) {
            // Acceder a los valores de la fila
            $nombre_empresa = $fila['nom_empre'];
            $nit_empresa = $fila['nit_empre'];

            // Aquí puedes hacer lo que necesites con los datos de la empresa encontrada
        }
    } else {
        // No se encontraron resultados para el nit_empre especificado
        echo "No se encontró ninguna empresa asociada al NIT: " . $nit_empres;
    }
} else {
    // La sesión no está iniciada o el nit_empre no está disponible en la sesión
    echo "No hay ninguna sesión iniciada o el NIT de la empresa no está disponible en la sesión.";
}



$consulta7 = $conn->prepare("SELECT terminos FROM usuario ");
$consulta7->execute();
$consult = $consulta7->fetch(PDO::FETCH_ASSOC);



if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $documento = isset($_POST['documento']) ? $_POST['documento'] : "";
    $id_tp_docu = isset($_POST['id_tp_docu']) ? $_POST['id_tp_docu'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";
    $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
    $ficha = isset($_POST['ficha']) ? $_POST['ficha'] : "";
    $terminos = isset($_POST['terminos']) ? 1 : 0;
    $id_esta_usu = isset($_POST['id_esta_usu']) ? $_POST['id_esta_usu'] : "";
    $id_rol = isset($_POST['id_rol']) ? $_POST['id_rol'] : "";
    $nit_empre = isset($_POST['nit_empre']) ? $_POST['nit_empre'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($documento) !== 10 || !is_numeric($documento)) {
        echo '<script>alert("Documento debe tener 10 dígitos numéricos.");</script>';
        echo '<script>window.location = "./registro_instru.php";</script>';
    } elseif (strlen($nombre) < 3 || strlen($nombre) > 12) {
        echo '<script>alert("Nombre debe tener entre 3 y 12 caracteres.");</script>';
        echo '<script>window.location = "./registro_instru.php";</script>';
    } elseif (strlen($apellido) < 3 || strlen($apellido) > 15) {
        echo '<script>alert("El apellido debe tener entre 3 y 15 caracteres.");</script>';
        echo '<script>window.location = "./registro_instru.php";</script>';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Correo electrónico no válido.");</script>';
        echo '<script>window.location = "./registro_instru.php";</script>';
    } else {
        // Prepara y ejecuta la consulta para verificar si el tipo de documento existe
        $stmtCheckTypeDoc = $conn->prepare("SELECT id_tp_docu FROM usuario WHERE id_tp_docu = ?");
        $stmtCheckTypeDoc->bindParam(1, $id_tp_docu, PDO::PARAM_INT);
        $stmtCheckTypeDoc->execute();
        $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

        $stmtCheckType = $conn->prepare("SELECT id_jornada FROM jornada WHERE id_jornada = ?");
        $stmtCheckType->bindParam(1, $id_jornada, PDO::PARAM_INT);
        $stmtCheckType->execute();
        $resultCheckType = $stmtCheckType->fetch(PDO::FETCH_ASSOC);

        // Prepara y ejecuta la consulta para verificar si el documento ya existe
        $stmtCheckDocument = $conn->prepare("SELECT documento FROM usuario WHERE documento = ?");
        $stmtCheckDocument->bindParam(1, $documento, PDO::PARAM_STR);
        $stmtCheckDocument->execute();
        $resultCheckDocument = $stmtCheckDocument->fetch(PDO::FETCH_ASSOC);

        // Verificar si el documento ya existe en la base de datos
        if ($resultCheckDocument) {
            // El documento ya existe en la base de datos, mostrar mensaje emergente con JavaScript
            echo '<script>alert("El documento ingresado ya está registrado.");</script>';
            echo '<script>window.location = "./registro_instru.php";</script>';
        } else {
            $codigo_barras = uniqid() . rand(1000, 9999);
            $generator = new BarcodeGeneratorPNG();
            $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);
            file_put_contents(__DIR__ . '/../../images/' . $codigo_barras . '.png', $codigo_barras_imagen);

            $user_password = password_hash($contrasena, PASSWORD_DEFAULT);
            if ($user_password === false) {
                echo '<script>alert("Error al hashear la contraseña.");</script>';
                echo '<script>window.location = "./registro_instru.php";</script>';
            } else {
                // Se define la variable $fecha_registro
                $fecha_registro = date("Y-m-d H:i:s");
                // Se elimina NOW() de los valores
                $stmt = $conn->prepare("INSERT INTO usuario (documento, id_tp_docu, nombre, apellido, contrasena, correo, codigo_barras, fecha_registro, terminos, id_rol, id_esta_usu, nit_empre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Asegúrate de que el número de parámetros coincide con el número de '?' en la consulta
                $stmt->execute([$documento, $id_tp_docu, $nombre, $apellido, $user_password, $correo, $codigo_barras, $fecha_registro, $terminos, $id_rol, $id_esta_usu, $nit_empre]);

                $stmt1 = $conn->prepare("INSERT INTO deta_ficha (ficha, documento) VALUES (?, ?)");

                $stmt1->execute([$ficha, $documento]);

                echo '<script>alert("Registro exitoso.");</script>';
                echo '<script>window.location = "./index.php";</script>';
            }
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
                        <div class="registro_container">
                            <!-- Formulario de Registro -->
                            <form class="registro_form" action="registro_instru.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario" onsubmit="return validarContraseña()">

                                <h1>Registro de Instructor </h1>
                                <br>
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
                                    <input type="text" placeholder="Ingrese primer nombre" class="form-control" name="nombre" title="Debe ser de 3 a 12 letras" required oninput="validateForm(this)" minlength="3" maxlength="12">
                                </div>

                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input type="text" placeholder="Ingrese primer apellido" class="form-control" name="apellido" title="Debe ser de 3 a 15 letras" required oninput="validateForm(this)"  minlength="3" maxlength="15">
                                </div>

                                <div class="form-group">
                                    <label> Correo</label>
                                    <input type="email" placeholder="Ingrese correo" class="form-control" name="correo" required minlength="6" maxlength="25">
                                </div>

                                <div class="form-group">
                                    <label>Rol</label>
                                    <select class="form-control" name="id_rol" required>
                                        <?php foreach ($consulll as $row) : ?>
                                            <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nom_rol']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nom_forma">Formación</label>
                                    <select name="nom_forma" id="nom_forma" class="form-control">
                                        <?php
                                        // Consulta para obtener las opciones de formación
                                        $statement = $conn->prepare("SELECT * FROM formacion WHERE id_forma >= 1");
                                        $statement->execute();
                                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . $row['id_forma'] . "'>" . $row['nom_forma'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group" id="ficha-group">
                                    <label for="ficha" class="form-group">Ficha</label>
                                    <select name="ficha" id="ficha" class="form-control"></select>
                                </div>

                                <div class="form-group" id="tp_jornada-group">
                                    <label for="tp_jornada" class="form-group">Jornada</label>
                                    <select id="tp_jornada" name="tp_jornada" class="form-control"></select>
                                </div>

                                <input type="hidden" placeholder="Estado" readonly class="form-control" value="1" name="id_esta_usu">

                                <div class="group-material">
                                    <label>Fecha de Registro</label>
                                    <input type="text" name="fecha_registro" class="material-control tooltips-general" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Empresa</label>
                                    <select class="form-control" name="nit_empre" required>
                                        <?php foreach ($resultados as $row) : ?>
                                            <option value="<?php echo $row['nit_empre']; ?>"><?php echo $row['nom_empre']; ?> </option readonly>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="contrase"> Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena" class="form-control clave" title="Debe tener de 6 a 12 dígitos" required minlength="6" maxlength="12">
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
                                            <input type="checkbox" id="checkboxTerminos" name="terminos" <?php echo (isset($consult['terminos']) && $consult['terminos'] == '1') ? 'checked' : ''; ?> required>

                                        </div>
                                    </div>
                                    <br>
                                    <button class="btn-success" type="button" onclick="openOverlayTerminos()">Acepto Términos y Condiciones</button>
                                </div>

                                <input type="submit" name="MM_register" value="Registrar" class="btn-primary"></input>
                                <input type="hidden" name="MM_register" value="formRegister">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function() {
    $('#nom_forma').change(function() {
        var idForma = $(this).val();  // Obtiene el ID de la formación seleccionada
        $.ajax({
            type: "POST",
            url: "./getFichas.php",  // Asegúrate de ajustar la ruta al archivo PHP adecuado
            data: {id_forma: idForma},
            dataType: 'json',  // Esto le dice a jQuery que espere una respuesta JSON
            success: function(data) {  // 'data' ya es un objeto JavaScript
                var fichaSelect = $('#ficha');  // El select de fichas
                fichaSelect.empty();  // Limpia las opciones actuales

                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        fichaSelect.append($('<option>', {
                            value: item.ficha,
                            text: item.ficha
                        }));
                    });
                } else {
                    fichaSelect.append($('<option>', {
                        value: '',
                        text: 'No hay fichas disponibles'
                    }));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                console.error('Response: ' + xhr.responseText);
            }
        });
    });
});


$(document).ready(function() {
    $('#ficha').change(function() {
        var idFicha = $(this).val();  // Obtiene el ID de la ficha seleccionada
        $.ajax({
            type: "POST",
            url: "./getJornada.php",  // Asegúrate de ajustar la ruta al archivo PHP adecuado
            data: {id_ficha: idFicha},
            dataType: 'json',
            success: function(data) {
                var jornadaSelect = $('#tp_jornada');  // El select de jornadas
                jornadaSelect.empty();  // Limpia las opciones actuales

                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        jornadaSelect.append($('<option>', {
                            value: item.id_jornada,
                            text: item.tp_jornada
                        }));
                    });
                } else {
                    jornadaSelect.append($('<option>', {
                        value: '',
                        text: 'No hay jornadas disponibles'
                    }));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
                console.error('Response: ' + xhr.responseText);
            }
        });
    });
});
</script>