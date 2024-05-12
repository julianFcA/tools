<?php
require_once 'template.php';

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nom_tp_herra = isset($_POST['nom_tp_herra']) ? $_POST['nom_tp_herra'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($nom_tp_herra) < 6 || strlen($nom_tp_herra) > 20) {
        echo '<script>alert("La herramienta debe tener entre 6 y 20 caracteres.");</script>';
        echo '<script>window.location = "./regis_tp_herra.php";</script>';
    } else {
        // Se elimina NOW() de los valores
        $stmt = $conn->prepare("INSERT INTO tp_herra (nom_tp_herra, nit_empre) VALUES (?, '$nit')");

        // Asegúrate de que el número de parámetros coincide con el número de '?' en la consulta
        $stmt->execute([$nom_tp_herra]);

        echo '<script>alert("Registro exitoso.");</script>';
        echo '<script>window.location = "./registro_herra.php";</script>';
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
                <div class="content-body container-table">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="registro_container">
                                    <form class="registro_form" action="regis_tp_herra.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">
                                        <h1>Registrar Tipo de Herramienta</h1>
                                        <div class="form-group">
                                            <label for="empresa"></label>
                                            <div class="form-group">
                                                <br>
                                                <label>Tipo de Herramienta</label>
                                                <input type="text" placeholder="Ingrese Tipo de Herramienta" class="form-control" name="nom_tp_herra" title="Debe ser de 20 letras" required minlength="6" maxlength="20" required oninput="validarLetras(this)">
                                            </div>
                                            <br>
                                            <input type="submit" name="MM_register" value="Crear Tipo de Herramienta" class="btn-primary"></input>
                                            <input type="hidden" name="MM_register" value="formRegister">
                                        </div>
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
<script>
    function validarLetras(input) {
        // Remover cualquier caracter que no sea una letra
        input.value = input.value.replace(/[^a-zA-Z]/g, '');
    }
</script>