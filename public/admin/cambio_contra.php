<?php
require_once 'template.php';

$docu = $_SESSION['documento'];
// echo $docu;

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $contra = $_POST['cont'];
    $clave1 = password_hash($contra, PASSWORD_DEFAULT, ["cost" => 12]);

    if ($_POST['cont'] == "" || $_POST['conta'] == "") {
        echo '<script>alert ("Datos vacios no ingreso la clave");</script>';
        echo '<script>window.location="../recuperacion.html"</script>';
    } else {
        $documento = $_SESSION['documento'];
        $insertSQL = $conn->prepare("UPDATE usuario SET contrasena = :contrasena WHERE documento = :documento");
        $insertSQL->bindParam(':contrasena', $clave1, PDO::PARAM_STR);
        $insertSQL->bindParam(':documento', $documento, PDO::PARAM_STR);
        $insertSQL->execute();

        echo '<script>alert ("Cambio de clave exitosa");</script>';
        echo '<script>window.location="./index.php"</script>';
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
                                    <div class="login-container">
                                        <div class="row">
                                            <div class="col-md-12 form-left">
                                                <form method="POST" name="form1" id="form1" autocomplete="off" onsubmit="return validarContraseña()">
                                                    <h3>CAMBIO DE CONTRASEÑA</h3>

                                                    <div class="form-group">
                                                        <label for="cont">NUEVA CONTRASEÑA<span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                            <input type="password" name="cont" id="cont" placeholder="Nueva clave" minlength="6" class="form-control" maxlength="20" oninput="maxlengthNumber(this);">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="conta">CONFIRMACION DE CONTRASEÑA<span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                            <input type="password" name="conta" id="conta" placeholder="Confirme clave" minlength="8" class="form-control" maxlength="20" oninput="maxlengthNumber(this);">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" name="inicio" id="inicio" class="btn btn-success px-5" value="Cambiar">
                                                        <input type="hidden" name="MM_update" value="form1">
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
        </div>
    </div>
</div>