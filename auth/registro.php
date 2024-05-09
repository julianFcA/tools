<?php
require_once 'template.php';


// Consulta 1
$consulta2 = $conn->prepare("SELECT nom_tp_docu, id_tp_docu FROM tp_docu WHERE id_tp_docu >= 1 ");
$consulta2->execute();
$consull = $consulta2->fetchAll(PDO::FETCH_ASSOC);



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



// Consulta 3
$consulta4 = $conn->prepare("SELECT nom_rol, id_rol FROM rol WHERE id_rol >= 3 ");
$consulta4->execute();
$consullll = $consulta4->fetchAll(PDO::FETCH_ASSOC);

// Consulta 4
$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll = $consulta5->fetchAll(PDO::FETCH_ASSOC);

// Consulta 6
// Preparar y ejecutar la consulta SQL
$consulta6 = $conn->prepare("SELECT empresa.nom_empre, empresa.nit_empre, licencia.esta_licen FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre WHERE empresa.nit_empre > 0 AND licencia.esta_licen = 'activo'");
$consulta6->execute();
$consullllll = $consulta6->fetchAll(PDO::FETCH_ASSOC);

$consulta7 = $conn->prepare("SELECT terminos FROM usuario ");
$consulta7->execute();
$consult = $consulta7->fetch(PDO::FETCH_ASSOC);

?>


<div class="registro_container">
    <!-- Formulario de Registro -->
    <form class="registro_form" action="../controller/RegisterController.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario" onsubmit="return validarContraseña()">

        <h1>REGISTRO </h1>

        <!-- Contenedor para mostrar errores -->
        <div class="error-text"></div>

        <!-- Campos para registrar un nuevo usuario -->

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
            <input type="number" placeholder="Ingrese Documento" class="form-control" name="documento" id="documento" title="Debe ser de 8 a 10 dígitos" required minlength="7" maxlength="10">
            <p id="mensaje"></p>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" placeholder="Ingrese Primer Nombre" class="form-control" name="nombre" title="Debe ser de 15 letras" required oninput="validarFormulario(this)"minlength="3" maxlength="12">
        </div>

        <div class="form-group">
            <label>Apellido</label>
            <input type="text" placeholder="Ingrese Primer Apellido" class="form-control" name="apellido" title="Debe ser de 15 letras" required minlength="3" maxlength="15">
        </div>

        <div class="form-group">
            <label> Correo</label>
            <input type="email" placeholder="Ingrese correo" class="form-control" name="correo" required minlength="6" maxlength="40">
        </div>

        <div class="form-group">
            <label>Rol</label>
            <select class="form-control" name="id_rol" required>
                <?php foreach ($consullll as $row) : ?>
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

        <br>
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
                    <input type="checkbox" class="form-control" id="checkboxTerminos" name="terminos" <?php echo ($consult && $consult['terminos'] == '1') ? 'checked' : ''; ?> required>
                </div>
            </div>
            <br>
            <button type="button" onclick="openOverlayTerminos()">Acepto Términos y Condiciones</button>
        </div>

        <input type="submit" name="MM_register" value="Registrarme" class="btn"></input>
        <input type="hidden" name="MM_register" value="formRegister">

        <div class="botones-container">
            <div class="redirecciones">
                <a href="./../index.php" class="link return">Regresar</a>
            </div>
        </div>
    </form>
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