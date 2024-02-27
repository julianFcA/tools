<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error de Inicio de Sesión</title>

    <!-- Fuentes - Tipo de letra - Iconografía -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../assets/css/register.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f4f4f4;
        }

        .contenedor-login {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .contenedor-form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 400px;
        }

        .titulo_login {
            text-align: center;
            padding: 20px;
            background-color: #F70A0A;
            color: #fff;
            margin: 0;
        }

        .tabs-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-around;
            background-color: #eee;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .tabs-links li {
            padding: 10px;
            flex: 1;
            text-align: center;
            border-bottom: 2px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .tabs-links li:hover {
            background-color: #ddd;
        }

        .formulario {
            padding: 20px;
        }

        .input-text {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .clave {
            width: 80%;
            border-radius: 5px 0 0 5px;
        }

        .icono {
            width: 20%;
            border-radius: 0 5px 5px 0;
            background-color: #F70A0A;
            color: #fff;
            border: 1px solid #F70A0A;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #F70A0A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #F70A0A;
        }

        .return {
            color: #F70A0A;
        }

        .return:hover {
            text-decoration: none;
        }

        .error-text {
            color: #ff0000;
            margin-bottom: 15px;
        }

        .redirecciones {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="contenedor-login">

        <div class="contenedor-form">

            <div class="container-center">
                <h1 class="titulo_login">Error <br> Iniciar Sesión</h1>

                <!-- Tabs -->
                <a class="link return" onclick="window.location.href='./registro.php'">Registro </a>

                <!-- Formulario -->
                <form action="../controller/AuthController.php" autocomplete="off" method="POST" id="formLogin" class="formulario active">

                    

                    <input type="number" placeholder="Ingrese documento" class="input-text" name="documento" title="Debe tener de 8 a 10 digitos" required onkeyup="espacios(this)" minlength="8" maxlength="11" required autocomplete="off">

                    <div class="grupo-input">
                        <input type="password" placeholder="Ingresa tu Contraseña" name="contrasena" class="input-text clave" title="Debe tener de 8 a 10 digitos" required onkeyup="espacios(this)" minlength="8" maxlength="20">
                        
                    </div>

                    <div class="redirecciones">
                        <a href="../index.php" class="link return">Regresar</a>
                    </div>
                    <div class="redirecciones">
                        <a href="./passwords/cambio_con.php" class="link return">¿Olvido su contraseña?</a>
                    </div>
            

                    <input class="btn" type="submit" name="iniciarSesion" value="Iniciar Sesión">

                </form>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




    <!--========================================
       Mis Scripts
    ==========================================-->
    <script src="../assets/js/register.js"></script>


    <script>
        // FUNCION QUE PERMITE PONER EL TEXT EN MAYUSCULA
        function mayuscula(e) {
            e.value = e.value.toUpperCase();
        }

        // FUNCION QUE PERMITE PONER EL TEXT EN MINUSCULA
        function minuscula(e) {
            e.value = e.value.toLowerCase();
        }

        // FUNCION QUE NO PERMITE INGRESAR ESPACIOS
        function espacios(e) {
            e.value = e.value.replace(/ /g, '');
        }

        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO EL NUMERO VALORES REQUERIDOS DE ACUERDO A LA LONGITUD MAXLENGTH DEL CAMPO -->
        function maxlengthNumber(obj) {

            if (obj.value.length > obj.maxLength) {
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el numeros de digitos requeridos");
            }
        }

        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO NUMEROS EN EL FORMULARIO ASIGNADO -->
        function multiplenumber(e) {
            key = e.keyCode || e.which;

            teclado = String.fromCharCode(key).toLowerCase();

            numeros = "1234567890";

            especiales = "8-37-38-46-164-46";

            teclado_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial = true;
                    alert("Debe ingresar solo numeros en el formulario");
                    break;
                }
            }

            if (numeros.indexOf(teclado) == -1 && !teclado_especial) {
                return false;
                alert("Debe ingresar solo numeros en el formulario ");
            }
        }


        // <!-- FUNCION DE JAVASCRIPT QUE PERMITE INGRESAR SOLO LETRAS. NUMEROS Y GUIONES BAJOS PARA LA CONTRASEÑA   -->
        function validarPassword(event) {
            // Obtenemos la tecla que se ha presionado
            var key = event.keyCode || event.which;

            // Convertimos el código de la tecla a su respectivo carácter
            var char = String.fromCharCode(key);

            // Definimos una expresión regular que solo permita números, letras y guiones bajos
            var regex = /[0-9a-zA-Z_]/;

            // Validamos si el carácter ingresado cumple con la expresión regular
            if (!regex.test(char)) {
                // Si no cumple, cancelamos el evento de ingreso de datos
                event.preventDefault();
                return false;
            }
        }
    </script>

</body>

</html>
