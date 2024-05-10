<?php
require_once 'template.php';

$columnas = [];

if (isset($_GET['documento'])) {
    $consulta_tipo = $conn->prepare("SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, empresa.nit_empre, empresa.nom_empre FROM usuario INNER JOIN empresa ON empresa.nit_empre = usuario.nit_empre WHERE usuario.documento = :documento;");
    $consulta_tipo->bindParam(':documento', $_GET['documento']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);

    $consulta = $conn->prepare("SELECT * FROM ficha WHERE ficha != 0");
    $consulta->execute();
    $consul = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $consulta2 = $conn->prepare("SELECT * FROM jornada WHERE id_jornada > 0");
    $consulta2->execute();
    $consul1 = $consulta2->fetchAll(PDO::FETCH_ASSOC);

    $consulta1 = $conn->prepare("SELECT * FROM formacion WHERE id_forma > 0");
    $consulta1->execute();
    $consul2 = $consulta1->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST["MM_register"]) && ($_POST["MM_register"] == "formRegister")) {
    $documento = isset($_POST['documento']) ? $_POST['documento'] : "";
    $ficha = isset($_POST['ficha']) ? $_POST['ficha'] : "";

    $stmtCheckTypeDoc = $conn->prepare("SELECT id_forma FROM formacion WHERE id_forma = ?");
    $stmtCheckTypeDoc->bindParam(1, $id_forma, PDO::PARAM_INT);
    $stmtCheckTypeDoc->execute();
    $resultCheckTypeDoc = $stmtCheckTypeDoc->fetch(PDO::FETCH_ASSOC);

    $stmtCheck = $conn->prepare("SELECT id_jornada FROM jornada WHERE id_jornada = ?");
    $stmtCheck->bindParam(1, $id_jornada, PDO::PARAM_INT);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    $stmtType = $conn->prepare("SELECT ficha FROM ficha WHERE ficha = ?");
    $stmtType->bindParam(1, $ficha, PDO::PARAM_INT);
    $stmtType->execute();
    $resultType = $stmtType->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("INSERT INTO deta_ficha (ficha, documento) VALUES (:ficha, :documento)");
    $stmt->bindParam(':ficha', $ficha, PDO::PARAM_STR);
    $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);

    $stmt->execute();

    echo '<script>alert("Registro exitoso.");</script>';
    echo '<script>window.location = "./index.php";</script>';
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
                                        <form class="registro_form" action="asigna.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">

                                            <h1>Asignar Formación</h1>
                                            <br>
                                            <div class="form-group">
                                                <label>Nombre de Instructor</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars($columnas['nombre'] ?? '', ENT_QUOTES); ?>" name="nombre" title="Debe ser de 15 letras" required oninput="validarLetras(this)" minlength="6" maxlength="12" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Apellido de Instructor</label>
                                                <input type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars($columnas['apellido'] ?? '', ENT_QUOTES); ?>" name="apellido" title="Debe ser de 15 letras" required oninput="validarLetras(this)" minlength="6" maxlength="12" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Número de Documento</label>
                                                <input type="text" placeholder="Ingrese Documento de Administrador" class="form-control" value="<?php echo htmlspecialchars($columnas['documento'] ?? '', ENT_QUOTES); ?>" name="documento" title="Debe ser de 10 dígitos" required onkeyup="espacios(this)" minlength="7" maxlength="10" readonly>
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

                                            <input type="submit" name="MM_register" value="Asignar Formación" class="btn-primary">
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