<?php
require_once 'template.php';

$nit = $_SESSION['nit_empre'];

$consulta10 = $conn->prepare("SELECT empresa.*, formacion.* FROM empresa INNER JOIN formacion ON empresa.nit_empre= formacion.nit_empre WHERE empresa.nit_empre = '$nit' AND formacion.id_forma >=1 ");
$consulta10->execute();
$consu10 = $consulta10->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $id_forma = isset($_POST['id_forma']) ? $_POST['id_forma'] : "";
    $nom_forma = isset($_POST['nom_forma']) ? $_POST['nom_forma'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($nom_forma) < 3 || strlen($nom_forma) > 40) {
        echo '<script>alert("Nombre de formación debe tener entre 3 y 40 caracteres.");</script>';
        echo '<script>window.location = "./registro_forma_manual.php";</script>';
        exit; // Salir del script después de la redirección
    } else {

        $stmtCheckFormacion = $conn->prepare("SELECT nom_forma FROM formacion WHERE nom_forma = ?");
        $stmtCheckFormacion->bindParam(1, $nom_forma, PDO::PARAM_INT);
        $stmtCheckFormacion->execute();
        $resultCheckFormacion = $stmtCheckFormacion->fetch(PDO::FETCH_ASSOC);

        if ($resultCheckFormacion) {
            // El documento ya existe en la base de datos, mostrar mensaje emergente con JavaScript
            echo '<script>alert("la formacion ya esta registrada.");</script>';
            echo '<script>window.location = "./registro_forma_manual.php";</script>';
        }

        // Prepara y ejecuta la consulta para insertar en la tabla formacion
        $sql_insert_formacion = "INSERT INTO formacion (id_forma, nom_forma, nit_empre) VALUES (?, ?, '$nit')";
        $stmt_insert_formacion = $conn->prepare($sql_insert_formacion);
        $stmt_insert_formacion->execute([$id_forma, $nom_forma]);

        echo '<script>alert("Registro exitoso.");</script>';
        echo '<script>window.location = "./registro_forma.php";</script>';
        exit; // Salir del script después de la redirección
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
                                        <form class="registro_form" action="registro_forma_manual.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">

                                            <h1>Registro de Formación Manual</h1>
                                            <br>

                                            <div class="form-group">
                                                <label>Nombre de Formación</label>
                                                <input type="text" placeholder="Ingrese Nombre de Formación" class="form-control" name="nom_forma" title="Debe ser de 3 a 40 letras" required minlength="3" maxlength="40" oninput="validarLetras(this)">
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
        </div>
    </div>
</div>
<script>
    function validarNumeros(input) {
        // Remover cualquier caracter que no sea un número
        input.value = input.value.replace(/[^\d]/g, '');
    }

    function validarLetras(input) {
        // Remover cualquier caracter que no sea una letra
        input.value = input.value.replace(/[^a-zA-Z" "]/g, '');
    }
</script>