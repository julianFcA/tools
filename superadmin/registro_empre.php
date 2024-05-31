<?php
require_once 'template.php';

$empresa = $conn->prepare("SELECT * FROM empresa");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nit_empre = $_POST['nit_empre'] ?? "";
    $nom_empre = $_POST['nom_empre'] ?? "";
    $direcc_empre = $_POST['direcc_empre'] ?? "";
    $telefono = $_POST['telefono'] ?? "";
    $correo_empre = $_POST['correo_empre'] ?? "";

    $errors = [];

    if (strlen($nit_empre) < 8 || strlen($nit_empre) > 12) {
        $errors[] = "El NIT debe contener entre 8 y 12 caracteres.";
    }

    if (strlen($nom_empre) < 3 || strlen($nom_empre) > 30) {
        $errors[] = "El nombre de la empresa debe tener entre 3 y 30 caracteres.";
    }

    if (strlen($direcc_empre) < 3 || strlen($direcc_empre) > 40) {
        $errors[] = "La dirección debe tener entre 3 y 40 caracteres.";
    }

    if (strlen($telefono) < 7 || strlen($telefono) > 13) {
        $errors[] = "El teléfono debe tener entre 7 y 13 caracteres.";
    }

    if (!filter_var($correo_empre, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Correo electrónico no válido.";
    }

    if (empty($nit_empre) || empty($nom_empre) || empty($direcc_empre) || empty($telefono) || empty($correo_empre)) {
        $errors[] = "Existen campos vacíos.";
    }

    if (empty($errors)) {
        $stmtCheckDocument = $conn->prepare("SELECT nit_empre FROM empresa WHERE nit_empre = ?");
        $stmtCheckDocument->bindParam(1, $nit_empre, PDO::PARAM_STR);
        $stmtCheckDocument->execute();
        $resultCheckDocument = $stmtCheckDocument->fetch(PDO::FETCH_ASSOC);

        if ($resultCheckDocument) {
            echo '<script>alert("El NIT de empresa ingresado ya está registrado."); window.location = "./registro_empre.php";</script>';
        } else {
            $insertsql = $conn->prepare("INSERT INTO empresa (nit_empre, nom_empre, direcc_empre, telefono, correo_empre) VALUES (?, ?, ?, ?, ?)");
            $insertsql->execute([$nit_empre, $nom_empre, $direcc_empre, $telefono, $correo_empre]);
            echo '<script>alert("Registro exitoso"); window.location = "crear.php";</script>';
        }
    } else {
        foreach ($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }
        echo '<script>window.location = "./registro_empre.php";</script>';
    }
}
?>

<body>
    <div class="registro_container">
        <!-- Formulario de Registro -->
        <form class="formulario-mediano registro_form" action="registro_empre.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">
            <h1>Registro de Empresa</h1>
            <div class="form-group">
                <label>Nit de Empresa</label>
                <input type="text" placeholder="Ingrese Nit de Empresa" class="form-control" name="nit_empre" title="Debe ser de 10 dígitos" required minlength="7" maxlength="12" pattern="[0-9\-]*" onkeyup="limpiarNoPermitidos(this)">
            </div>

            <div class="form-group">
                <label>Nombre de Empresa</label>
                <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" name="nom_empre" title="Debe ser de 40 letras" required oninput="validarLetrasNumerosGuiones(this)" minlength="3" maxlength="40">
            </div>

            <div class="form-group">
                <label>Dirección de Empresa</label>
                <input type="text" placeholder="Ingrese Dirección de Empresa" class="form-control" name="direcc_empre" title="Debe ser de 30 letras" required minlength="6" maxlength="30">
            </div>

            <div class="form-group">
                <label> Teléfono de Empresa</label>
                <input type="text" placeholder="Ingrese Teléfono de Empresa" class="form-control" name="telefono" required onkeyup="espacios(this)" minlength="8" maxlength="10">
            </div>

            <div class="form-group">
                <label> Correo de Empresa</label>
                <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" name="correo_empre" required onkeyup="espacios(this)" minlength="6" maxlength="50">
            </div>
            <input type="submit" name="MM_register" value="Registro" class="btn-primary">
            <input type="hidden" name="MM_register" value="formRegister">
        </form>
    </div>   
</body>

<script>
        function validarLetrasNumerosGuiones(input) {
        var valor = input.value.trim();
        var letrasYGuiones = valor.replace(/[^a-zA-Z\- ]/g, '');
        var numeros = valor.replace(/[^0-9]/g, '');

        if (numeros.length > 3) {
            alert('El nombre de empresa solo puede contener hasta 3 números.');
            // Limitar a los primeros 3 números y concatenar con las letras y guiones permitidos
            numeros = numeros.substring(0, 3);
            input.value = numeros + letrasYGuiones;
        } else {
            var regex = /^[a-zA-Z0-9\- ]*$/;
            if (!regex.test(valor)) {
                alert('El nombre de empresa solo puede contener letras, números y guiones.');
                input.value = letrasYGuiones + numeros;
            }
        }
    }


    function validarLetrasConEspacios(input) {
        var valor = input.value.trim();
        var regex = /^[a-zA-Z ]*$/;

        if (!regex.test(valor)) {
            alert('La dirección solo puede contener letras y espacios.');
            input.value = valor.replace(/[^a-zA-Z ]/g, '');
        }
    }

    function espacios(input) {
        input.value = input.value.replace(/\s/g, '');
    }
</script>
