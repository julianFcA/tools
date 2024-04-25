<?php
require_once 'template.php';

$empresa = $conn->prepare("SELECT nit_empre, nom_empre FROM empresa WHERE nit_empre > 1");
$empresa->execute();
$empresas = $empresa->fetchAll();  // Cambiado de fetch() a fetchAll()

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formreg") {
    // Obtener datos del formulario
    $nit_empre = $_POST["nit_empre"];
    $licencia = uniqid();

    $fecha_ini = date('Y-m-d H:i:s');

    $fecha_fin = date('Y-m-d H:i:s', strtotime('+1 year'));

    $validar_nit = $conn->prepare("SELECT * FROM licencia WHERE nit_empre = ?");
    $validar_nit->execute([$nit_empre]);
    

    if ($nit_empre == "") {
        echo '<script>alert("EXISTEN CAMPOS VACÍOS");</script>';
        echo '<script>window location="crear.php"</script>';
    } 
    else {
      $insertsql = $conn->prepare("INSERT INTO licencia (licencia, esta_licen, fecha_ini, fecha_fin, nit_empre) VALUES (?, 'activo', ?, ?, ?)");
      $insertsql->execute([$licencia, $fecha_ini, $fecha_fin, $nit_empre]); // Solo se pasan $licencia y $nit_empre
      echo '<script>alert("Registro exitoso");</script>';
      echo '<script>window.location = "licencia.php";</script>';


    }
}
?>

<body>
  <div class="registro_container">
      <form method="post" class="formulario-pequeño registro_form">
        <div class="form-group">
            <label for="empresa">Empresa:</label>
            <select class="form-control" id="nit" name="nit_empre" required>
                <option value="" disabled selected>Selecciona la empresa</option> <!-- Placeholder -->
                <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo $empresa['nit_empre']; ?>"><?php echo $empresa['nom_empre']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <input type="hidden" name="MM_insert" value="formreg">
            <button type="submit">Asignar</button>
        </div>
    </form>
  </div>
</body>


