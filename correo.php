<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'];
    $paracorreo = $correo;
    $titulo = "Recuperacion de contraseña";
    $msj = "Para cambiar tu contraseña, haz clic en el siguiente enlace: http://localhost/tools/recuperacion.html , e ingrese en el cuadro de confirmación donde dice 'Ingrese Codiogo de Confirmacion' el siguiente codigo: Tools_Usuario2024" ;
    $tucorreo = "From: jfcalderona16@gmail.com";
    if (mail($paracorreo, $titulo, $msj, $tucorreo)) {
        echo '<script>alert("Correo enviado con éxito");</script>';
        echo '<script>window.location="auth/inicio_sesion.php"</script>';
        exit();
    } else {
        echo '<script>alert("ERROR, inténtelo nuevamente");</script>';
        echo '<script>window.location="correo.php"</script>';
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recuperar contraseña</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/icono.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ad743e;
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
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #fff;
        }

        .btn-submit {
            background-color: green;
            border-color: #000;
            color: #fff;
        }

        .btn-back {
            background-color: red;
            border-color: #000;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="row">
            <div class="col-md-12 form-left">
                <form method="POST" autocomplete="off" class="row g-3">
                    <h3 class="form-title mb-3">VALIDACION DE CORREO</h3>
                    <div class="col-12 form-group">
                        <label>CORREO<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                            <input type="email" name="correo" minlength="6" maxlength="50" id="doc" class="form-control"
                                placeholder="Digite Su Correo" oninput="maxlengthNumber(this);">
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <input type="submit" class="btn btn-submit px-5" name="inicio" id="inicio" value="Validar">
                        <a href="auth/inicio_sesion.php" class="btn btn-back px-5">Volver</a>
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
