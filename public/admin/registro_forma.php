<?php
require_once 'template.php';


$consulta8 = $conn->prepare("SELECT * FROM jornada");
$consulta8->execute();
$cons = $consulta8->fetchAll(PDO::FETCH_ASSOC);

$consulta10 = $conn->prepare("SELECT * FROM formacion");
$consulta10->execute();
$consu10 = $consulta10->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $ficha = isset($_POST['ficha']) ? $_POST['ficha'] : "";
    $id_forma = isset($_POST['id_forma']) ? $_POST['id_forma'] : "";
    $id_jornada = isset($_POST['id_jornada']) ? $_POST['id_jornada'] : "";

    // Validaciones adicionales en el lado del servidor
    if (strlen($ficha) !== 7 || !is_numeric($ficha)) {
        echo '<script>alert("La ficha debe ser de 7 dígitos numéricos.");</script>';
        echo '<script>window.location = "./registro_forma.php";</script>';
        exit; // Salir del script después de la redirección
    } else {
        // Prepara y ejecuta la consulta para verificar si la jornada y la formación existen
        $stmtCheckFormacion = $conn->prepare("SELECT id_forma FROM formacion WHERE id_forma = ?");
        $stmtCheckFormacion->bindParam(1, $id_forma, PDO::PARAM_INT);
        $stmtCheckFormacion->execute();
        $resultCheckFormacion = $stmtCheckFormacion->fetch(PDO::FETCH_ASSOC);

        $stmtCheckJornada = $conn->prepare("SELECT id_jornada FROM jornada WHERE id_jornada = ?");
        $stmtCheckJornada->bindParam(1, $id_jornada, PDO::PARAM_INT);
        $stmtCheckJornada->execute();
        $resultCheckJornada = $stmtCheckJornada->fetch(PDO::FETCH_ASSOC);

         // Prepara y ejecuta la consulta para verificar si el documento ya existe
         $stmtCheck = $conn->prepare("SELECT ficha FROM ficha WHERE ficha = ?");
         $stmtCheck->bindParam(1, $ficha, PDO::PARAM_STR);
         $stmtCheck->execute();
         $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);
 
         // Verificar si el documento ya existe en la base de datos
         if ($resultCheck) {
             // El documento ya existe en la base de datos, mostrar mensaje emergente con JavaScript
             echo '<script>alert("El ficha ya esta registrada.");</script>';
             echo '<script>window.location = "./registro_forma.php";</script>';
         } 

        // Verificar si la jornada y la formación existen
        if (!$resultCheckJornada || !$resultCheckFormacion) {
            echo '<script>alert("La jornada o la formación no existe.");</script>';
            echo '<script>window.location = "./registro_forma.php";</script>';
            exit; // Salir del script después de la redirección
        }

        // Se procede a insertar la ficha
        $stmtInsertFicha = $conn->prepare("INSERT INTO ficha (ficha, id_forma, id_jornada) VALUES (?, ?, ?)");
        $stmtInsertFicha->execute([$ficha, $id_forma, $id_jornada]);
        
        echo '<script>alert("Registro exitoso.");</script>';
        echo '<script>window.location = "./formacion.php";</script>';
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
                                        <form class="registro_form" action="registro_forma.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">

                                            <h1>Registro de Formación </h1>
                                            <br>
                                            <div class="form-group">
                                                <label>Ficha</label>
                                                <input type="number" placeholder="Ingrese Ficha" class="form-control" name="ficha" title="Debe ser de 7 numeros" required minlength="7" maxlength="7">
                                            </div>

                                            <div class="form-group">
                                                <label>Formación</label>
                                                <select class="form-control" name="id_forma" required>
                                                    <?php foreach ($consu10 as $row) : ?>
                                                        <option value="<?php echo $row['id_forma']; ?>"><?php echo $row['nom_forma']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Tipo de Jornada</label>
                                                <select class="form-control" name="id_jornada" required>
                                                    <?php foreach ($cons as $row) : ?>
                                                        <option value="<?php echo $row['id_jornada']; ?>"><?php echo $row['tp_jornada']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
