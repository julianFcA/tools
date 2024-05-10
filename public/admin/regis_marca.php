<?php
require_once 'template.php';

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nom_marca = isset($_POST['nom_marca']) ? $_POST['nom_marca'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($nom_marca) < 6 || strlen($nom_marca) > 20) {
        echo '<script>alert("La marca debe tener entre 6 y 20 caracteres.");</script>';
        echo '<script>window.location = "./regis_marca.php";</script>';
    } else {
        // Se elimina NOW() de los valores
        $stmt = $conn->prepare("INSERT INTO marca_herra (nom_marca) VALUES (?)");

        // Asegúrate de que el número de parámetros coincide con el número de '?' en la consulta
        $stmt->execute([$nom_marca]);

        echo '<script>alert("Registro exitoso.");</script>';
        echo '<script>window.location = "./regis_tp_herra.php";</script>';
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
                                    <form class="registro_form" action="regis_marca.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">
                                        <h1>Registrar Marca de Herramientas</h1>
                                        <div class="form-group">
                                            <label for="empresa"></label>
                                            <div class="form-group">
                                                <br>
                                                <label>Marca de Herramientas</label>
                                                <input type="varchar" placeholder="Ingrese Marca" class="form-control" name="nom_marca" title="Debe ser de 20 letras" required minlength="6" maxlength="20">
                                            </div>
                                            <br>
                                            <input type="submit" name="MM_register" value="Crear Marca de Herramienta" class="btn-primary"></input>
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
