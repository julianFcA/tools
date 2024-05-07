<?php
require_once("../database/conn.php");
$db = new database();
$conn = $db->conectar();
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nueva Contraseña</title>
    <link rel="icon" href="../images/icono.png">
    <meta charset="utf-8">
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
            width: 100%;
            /* Adjust the width as needed */
            max-width: 600px;
            /* Set a maximum width for the form */
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

    <script>
        function maxlengthNumber(obj) {
            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el número de dígitos requeridos");
            }
        }

        function validarContraseña() {
            var contraseña = document.getElementById("contrasena").value;
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
</body>

</html>