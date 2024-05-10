<?php
require_once 'template.php';

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
        echo '<script>window.location="../auth/inicio_sesion.php"</script>';
    }
}
?>

<?php
if (isset($_POST["inicio"])) {
    $documento = $_POST["documento"];

    $sql = $conn->prepare("SELECT * FROM usuario WHERE documento = :documento");
    $sql->bindParam(':documento', $documento, PDO::PARAM_STR);
    $sql->execute();
    $fila = $sql->fetch();

    if ($fila) {
        $_SESSION['documento'] = $fila['documento'];
?>

        <div class="login-container">
            <div class="row">
                <div class="col-md-12 form-left">
                    <form method="POST" name="form1" id="form1" autocomplete="off" onsubmit="return validarContraseña()">
                        <h3>CAMBIO DE CONTRASEÑA</h3>

                        <div class="form-group">
                            <label for="cont">NUEVA CONTRASEÑA<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="password" name="cont" id="contrasena" placeholder="Nueva clave" minlength="6" class="form-control" maxlength="12" oninput="maxlengthNumber(this);">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta">CONFIRMACION DE CONTRASEÑA<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                <input type="password" name="conta" id="contrasena" placeholder="Confirme clave" minlength="6" class="form-control" maxlength="12" oninput="maxlengthNumber(this);">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="inicio" id="inicio" class="btn btn-success px-5" value="Cambiar">
                            <input type="hidden" name="MM_update" value="form1">
                            <a href="../index.php" class="btn btn-primary px-5">Volver a la página principal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<?php
    } else {
        echo '<script>alert ("El documento no existe en la base de datos");</script>';
        echo '<script>window.location="../../recuperacion.html"</script>';
    }
}

?>


<script>
    function validarContraseña() {
        var contraseña = document.getElementById('cont').value;
        var confirmarContraseña = document.getElementById('conta').value;

        if (contraseña !== confirmarContraseña) {
            alert('Las contraseñas no coinciden');
            return false; // Detener el envío del formulario
        }
        return true; // Permitir el envío del formulario si las contraseñas coinciden
    }



    function validarContra() {
    var contraseña = document.getElementById("contrasena","cont","conta").value;
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

</script>