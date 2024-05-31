<?php
require_once 'template.php';

$columnas = [];

// Verificar si se ha enviado un ID de formación
if (isset($_GET['id_forma'])) {
    $id_forma = $_GET['id_forma'];
    
    // Consulta para obtener los datos de la formación
    $consulta_tipo = $conn->prepare("SELECT * FROM formacion WHERE id_forma = :id_forma");
    $consulta_tipo->bindParam(':id_forma', $id_forma);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

// Verificar si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $nom_forma = $_POST['nom_forma'];
    $id_forma = $_POST['id_forma'];

    // Validar longitud del nombre de formación
    if (strlen($nom_forma) < 3 || strlen($nom_forma) > 40) {
        echo '<script>alert("Nombre de formación debe tener entre 3 y 40 caracteres.");</script>';
    } else {
        // Actualización de registros
        $actu_update = $conn->prepare("UPDATE formacion SET nom_forma = :nom_forma WHERE id_forma = :id_forma");
        $actu_update->bindParam(':nom_forma', $nom_forma);
        $actu_update->bindParam(':id_forma', $id_forma);

        $actu_update->execute();

        echo '<script>alert("Actualización Exitosa ");</script>';
        echo '<script>window.location="./formacion.php"</script>';
        exit;
    }
}
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="tab-list">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="card-header">
                        <div class="content-body container-table">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="registro_container">
                                        <form class="registro_form" name="formRegister" autocomplete="off" method="POST" id="formulario" enctype="multipart/form-data" action="actu_forma.php">

                                            <h1>Actualizar Datos de Formación</h1>
                                            <div class="form-group">
                                                <input type="hidden" placeholder="" class="form-control" value="<?php echo $columnas['id_forma'] ?>" name="id_forma" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Nombre de Formación</label>
                                                <input type="text" placeholder="Ingrese Nombre de Formación" class="form-control" value="<?php echo $columnas['nom_forma'] ?>"  name="nom_forma" title="Debe ser de 20 letras" required minlength="3" maxlength="40" oninput="validarLetras(this)">
                                            </div>

                                            <input type="submit" value="Actualizar" class="btn-primary">
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
