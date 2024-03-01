<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();

$empresa = $conn->prepare("SELECT nit_empre, nom_empre FROM empresa");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formreg") {
    // Obtener datos del formulario
    $nit_empre = $_POST["nit_empre"];
    $licencia = uniqid();
    $esta_licen=2;

    $validar_nit = $conn->prepare("SELECT * FROM licencia WHERE nit_empre = ?");
    $validar_nit->execute([$nit_empre]);
    

    if ($nit_empre == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="crear.php"</script>';
    } 
    else {
        $insertsql = $conn->prepare("INSERT INTO licencia ( licencia, esta_licen, nit_empre) VALUES (?, ?, ?, ?)");
        $insertsql->execute([$licencia, $esta_licen, $nit_empre]);
        echo '<script>alert ("Registro exitoso");</script>';
        echo '<script> window.location= "licencia.php"</script>';

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <div class="form-group">
            <label for="empresa">Empresa:</label>
            <select class="form-control" id="nit" name="nit_empre" required>
                <option value="" disabled selected>Selecciona la empresa</option> <!-- Placeholder -->
                <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo $empresa['nit_empre']; ?>"><?php echo $empresa['nom_empre']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="MM_insert" value="formreg">
            <button type="submit">registrar</button>
        </div>
    </form>
</body>

</html>
