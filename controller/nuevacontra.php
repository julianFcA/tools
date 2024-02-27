<?php
require_once("../database/conn.php");
$db = new database();
$conn = $db->conectar();
session_start();

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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nueva Contraseña</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-color: #212529;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 100%; /* Adjust the width as needed */
            max-width: 600px; /* Set a maximum width for the form */
        }


        .form-left {
            padding: 50px;
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #fff;
        }

    </style>

<body>

<div class="login-container">
        <div class="row">
            <div class="col-md-12 form-left">
                <form method="POST" name="form1" id="form1" autocomplete="off">
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
                        <a href="../index.php" class="btn btn-primary px-5">Volver a la página principal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function maxlengthNumber(obj) {
            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el número de dígitos requeridos");
            }
        }
    </script>
</body>

</html>


    <?php
    }
    else
    {
        echo '<script>alert ("El documento no existe en la base de datos");</script>';
        echo '<script>window.location="../../recuperacion.html"</script>';
    }
}

?>
