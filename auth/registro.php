<?php
require_once 'template.php';


try {
    $nit_empre = $_POST['nit_empre'] ?? '';
    echo $nit_empre;

    // Consulta SQL para verificar el código
    $sql = "SELECT * FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre WHERE licencia.esta_licen = 'activo' AND empresa.nit_empre = :nit_empre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nit_empre', $nit_empre);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se encontró una coincidencia
    if ($resultado) {
        // La contraseña es correcta y el NIT de la empresa está activo
        echo json_encode(array('acceso_permitido' => true));
    } else {
        // La contraseña es incorrecta o el NIT de la empresa no está activo
        echo json_encode(array('acceso_permitido' => false));
    }
} catch (PDOException $e) {
    // Captura cualquier excepción PDO (error de base de datos)
    echo json_encode(array('error' => 'Error de base de datos: ' . $e->getMessage()));
} catch (Exception $e) {
    // Captura cualquier otra excepción
    echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
}

?>

<?php

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

// Consulta SQL para verificar el NIT de la empresa
$consulta6 = $conn->prepare("SELECT empresa.nom_empre, empresa.nit_empre, licencia.esta_licen FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre WHERE empresa.nit_empre= :nit_empre AND licencia.esta_licen = 'activo'");
$consulta6->bindParam(':nit_empre', $nit_empre);
$consulta6->execute();
$consullllll = $consulta6->fetchAll(PDO::FETCH_ASSOC);


$consulta7 = $conn->prepare("SELECT terminos FROM usuario ");
$consulta7->execute();
$consult = $consulta7->fetch(PDO::FETCH_ASSOC);



?>

<style>
    /* cuadro de texto con codigo */

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
    }

    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div class="modal" id="modal">
    <div class="modal-content">
        <span id="close" class="close">&times;</span>
        <h2>Ingrese Nit de Empresa</h2>
        <!-- Cambiar el tipo de campo de "password" a "text" -->
        <input type="text" id="nitInput" name="nit_empre" placeholder="Ingrese Nit de la Empresa a la que Pertenece">
        <button onclick="validarAcceso()" class="accept-button" style="background-color: orange; width: calc(100% - 10px); padding: 10px; margin-top: 10px;">Aceptar</button>
    </div>
</div>


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
            <input type="number" placeholder="Ingrese Documento" class="form-control" name="documento" id="documento" title="Debe ser de 8 a 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength="10" oninput="validarNumeros(this)">
            <p id="mensaje"></p> <span id="errorDocumento" style="color: red; display: none;">El documento solo puede contener números</span>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" placeholder="Ingrese Primer Nombre" class="form-control" name="nombre" title="Debe ser de 15 letras" required onkeyup="espacios(this)" minlength="3" maxlength="12">
            <span id="errorNombre" style="color: red; display: none;">El nombre solo puede contener letras</span>
        </div>

        <div class="form-group">
            <label>Apellido</label>
            <input type="text" placeholder="Ingrese Primer Apellido" class="form-control" name="apellido" title="Debe ser de 15 letras" required onkeyup="espacios(this)" minlength="3" maxlength="15">
            <span id="errorApellido" style="color: red; display: none;">El apellido solo puede contener letras</span>
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
                $statement = $conn->prepare("SELECT empresa.*, formacion.* FROM empresa INNER JOIN formacion ON empresa.nit_empre= formacion.nit_empre WHERE empresa.nit_empre = '$nit_empre' AND formacion.id_forma >=1 ");
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
                    <div class="center-content">
                        <p>Estos son los términos y condiciones para el uso de la aplicación de préstamos de herramientas:</p>
                        <ol>
                            <li><strong>Uso Aceptable:</strong> Al utilizar esta aplicación, aceptas utilizarla de manera ética y legal. No debes usar la aplicación con fines ilegales o dañinos.</li>
                            <li><strong>Registro:</strong> Para acceder a la funcionalidad completa de la aplicación, es posible que debas registrarte proporcionando información precisa y actualizada.</li>
                            <li><strong>Préstamos:</strong> El préstamo de herramientas está sujeto a disponibilidad y a las reglas establecidas por la aplicación. Asegúrate de cumplir con las fechas y condiciones acordadas.</li>
                            <li><strong>Responsabilidad:</strong> La aplicación y sus desarrolladores no se hacen responsables de cualquier daño o pérdida resultante del uso de la aplicación o de las herramientas prestadas.</li>
                        </ol>
                        <p>Al utilizar esta aplicación, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo con estos términos, por favor, no utilices la aplicación.</p>
                    </div>
                    <input type="checkbox" class="form-control" id="checkboxTerminos" name="terminos" <?php echo ($consult && $consult['terminos'] == '1') ? 'checked' : ''; ?> required>
                </div>
            </div>
            <br>
            <button type="button" onclick=" openOverlayTerminos()">Acepto Términos y Condiciones</button>
        </div>


        <input type="submit" name="MM_register" value="Registrarme" class="btn"></input>
        <input type="hidden" name="MM_register" value="formRegister" onclick="if(validarAceptacionTerminos())">

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
            var idForma = $(this).val(); // Obtiene el ID de la formación seleccionada
            $.ajax({
                type: "POST",
                url: "./getFichas.php", // Asegúrate de ajustar la ruta al archivo PHP adecuado
                data: {
                    id_forma: idForma
                },
                dataType: 'json', // Esto le dice a jQuery que espere una respuesta JSON
                success: function(data) { // 'data' ya es un objeto JavaScript
                    var fichaSelect = $('#ficha'); // El select de fichas
                    fichaSelect.empty(); // Limpia las opciones actuales

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
            var idFicha = $(this).val(); // Obtiene el ID de la ficha seleccionada
            $.ajax({
                type: "POST",
                url: "./getJornada.php", // Asegúrate de ajustar la ruta al archivo PHP adecuado
                data: {
                    id_ficha: idFicha
                },
                dataType: 'json',
                success: function(data) {
                    var jornadaSelect = $('#tp_jornada'); // El select de jornadas
                    jornadaSelect.empty(); // Limpia las opciones actuales

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

<script>
    function validarNumeros(input) {
        var documentoValue = input.value.trim();
        var numerosValidos = /^\d+$/;
        var errorDocumento = document.getElementById('errorDocumento');

        if (!numerosValidos.test(documentoValue)) {
            errorDocumento.style.display = 'block';
            input.setCustomValidity('El documento solo puede contener números');
        } else {
            errorDocumento.style.display = 'none';
            input.setCustomValidity('');
        }
    }


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

    function limpiarNoPermitidos(input) {
        // Reemplazar todo lo que no sea número o guion con una cadena vacía
        input.value = input.value.replace(/[^0-9\-]/g, '');
    }

    function validarContraseña() {
        var contraseña = document.getElementById("contrasena").value;
        var mayusculaRegex = /[A-Z]/;
        var numeroRegex = /[0-9]/;
        var signoRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

        if (!mayusculaRegex.test(contraseña)) {
            alert("La contraseña debe contener al menos una letra mayúscula.");
            return false;
        }
        if (!numeroRegex.test(contraseña)) {
            alert("La contraseña debe contener al menos un número.");
            return false;
        }
        if (!signoRegex.test(contraseña)) {
            alert("La contraseña debe contener al menos un signo.");
            return false;
        }
        return true;
    }

    function openOverlayTerminos() {
        document.getElementById("overlay-terminos").style.display = "block";
    }

    function closeOverlayTerminos() {
        document.getElementById("overlay-terminos").style.display = "none";
    }

    function validarAceptacionTerminos() {
        var checkboxTerminos = document.getElementById("checkboxTerminos");
        if (!checkboxTerminos.checked) {
            alert("Debes aceptar los términos y condiciones para continuar.");
            return false;
        }
        return true;
    }
</script>


<script>
    // Función para validar el código o el NIT de la empresa según el contexto
    function validarAcceso() {
        const valorIngresado = document.getElementById("nitInput").value;
        document.getElementById("modal").style.display = "none";
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.acceso_permitido) {
                            alert("Acceso permitido.");
                            document.getElementById("modal").style.display = "none";
                            // Aquí debes especificar la URL a la que deseas redirigir al usuario
                        } else {
                            alert("Acceso denegado.");
                            window.location.href = "";

                        }
                    } catch (error) {
                        console.error("Error al procesar la respuesta JSON:", error.message);
                    }
                } else {
                    // Manejar errores de solicitud si es necesario
                    console.error("Error al procesar la solicitud. Código de estado:", xhr.status);
                }
            }
        };
        // Enviar el valor ingresado al servidor
        xhr.send("nit_empre=" + encodeURIComponent(valorIngresado));
    }

    // Mostrar el cuadro de diálogo automáticamente al cargar la página
    window.onload = function() {
        document.getElementById("modal").style.display = "block";

        // Asignar evento al botón de cierre después de que el DOM esté completamente cargado
        document.getElementById("close").onclick = function() {
            document.getElementById("modal").style.display = "none";
            window.location.href = "./../index.php"; // Redirigir a la página principal
        };
    };
</script>