<?php
require_once 'template.php';

$empresa = $conn->prepare("SELECT * FROM empresa");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_register"]) && $_POST["MM_register"] == "formRegister") {
    $nit_empre = isset($_POST['nit_empre']) ? $_POST['nit_empre'] : "";
    $nom_empre = isset($_POST['nom_empre']) ? $_POST['nom_empre'] : "";
    $direcc_empre = isset($_POST['direcc_empre']) ? $_POST['direcc_empre'] : "";
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
    $correo_empre = isset($_POST['correo_empre']) ? $_POST['correo_empre'] : "";


    if ($nit_empre == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="registro_empre.php"</script>';
    } else {
        $insertsql = $conn->prepare("INSERT INTO empresa ( nit_empre, nom_empre, direcc_empre, telefono, correo_empre) VALUES (?, ?, ?, ?, ?)");
        $insertsql->execute([$nit_empre, $nom_empre, $direcc_empre, $telefono, $correo_empre]);
        echo '<script>alert ("Registro exitoso");</script>';
        echo '<script> window.location= "crear.php"</script>';
    }
}
?>

<body>
    <div class="registro_container">
        <!-- Formulario de Registro -->
        <form class=" formulario-mediano registro_form" action="registro_empre.php" name="formRegister" autocomplete="off" method="POST" class="formulario" id="formulario">

            <h1>Registro de Empresa</h1>
            <div class="form-group">
                <label>Nit de Empresa</label>
                <input type="text" placeholder="Ingrese Nit de Empresa" class="form-control" name="nit_empre" title="Debe ser de 10 dígitos" required minlength="7" maxlength="12" pattern="[0-9\-]*" onkeyup="limpiarNoPermitidos(this)">
            </div>

            <div class="form-group">
                <label>Nombre de Empresa</label>
                <input type="text" placeholder="Ingrese Nombre de Empresa" class="form-control" name="nom_empre" title="Debe ser de 40 letras" required oninput="validarLetrasConEspacios(this)" required oninput="validarLetras(this)" minlength="6" maxlength="50">
            </div>

            <div class="form-group">
                <label>Direeción de Empresa</label>
                <input type="varchar" placeholder="Ingrese Direccion de Empresa" class="form-control" name="direcc_empre" title="Debe ser de 30 letras" required oninput="validateForm(this)" required oninput="validarLetrasConEspacios(this)" required oninput="validarLetras(this)" minlength="6" maxlength="30">
            </div>

            <div class="form-group">
                <label> Telefono de Empresa</label>
                <input type="number" placeholder="Ingrese Telefono de Empresa" class="form-control" name="telefono" required onkeyup="espacios(this)" minlength="8" maxlength="14">
            </div>

            <div class="form-group">
                <label> Correo de Empresa</label>
                <input type="email" placeholder="Ingrese Correo de Empresa" class="form-control" name="correo_empre" required onkeyup="espacios(this)" minlength="6" maxlength="50">
            </div>
            <input type="submit" name="MM_register" value="Registro" class="btn-primary"></input>
            <input type="hidden" name="MM_register" value="formRegister">
        </form>
    </div>