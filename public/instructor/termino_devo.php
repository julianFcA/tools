<?php
require_once 'template.php';

// Verifica si se ha enviado un formulario POST y si se han seleccionado herramientas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['herramienta']) && is_array($_POST['herramienta'])) {
    // Almacena las herramientas seleccionadas en la variable de sesión
    $_SESSION['herramientas'] = $_POST['herramienta'];
} else {
    redirectToPrestamoPage("Debes seleccionar al menos una herramienta del inventario.");
    echo '<script>window.location="./index.php"</script>';
}

$documento = $_POST['documento'];

// Consulta para recuperar los detalles de las herramientas seleccionadas
$query = "SELECT herramienta.*, 
                 tp_herra.nom_tp_herra, 
                 marca_herra.nom_marca, 
                 prestamo_herra.*, 
                 detalle_prestamo.* 
          FROM herramienta 
          INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra
          INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca 
          INNER JOIN detalle_prestamo ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra  
          INNER JOIN prestamo_herra ON detalle_prestamo.id_presta = prestamo_herra.id_presta 
          WHERE prestamo_herra.documento = $documento AND herramienta.codigo_barra_herra IN (";


// Construye la parte dinámica de la consulta con marcadores de posición
$placeholders = implode(',', array_fill(0, count($_SESSION['herramientas']), '?'));

// Completa la consulta
$query .= $placeholders . ")";

// Prepara la consulta
$stmt = $conn->prepare($query);

// Enlaza los valores a los marcadores de posición
$stmt->execute($_SESSION['herramientas']);

// Función para redireccionar con un mensaje
function redirectToPrestamoPage($message)
{
    echo "<script>alert('$message');</script>";
    echo '<script>window.location="./index.php"</script>';
    exit();
}

?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="tab-list">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="card-header">
                        <div class="content-body container-table">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Devolución de Herramienta</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="devolu.php" method="post"
                                                    onsubmit="return validarFormulario()">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Codigo De Barras</th>
                                                                    <th>Tipo de Herramienta</th>
                                                                    <th>Nombre De Herramienta</th>
                                                                    <th>Marca</th>
                                                                    <th>Imagen</th>
                                                                    <th>Cantidad Prestada</th>
                                                                    <th>Fecha de Entrega</th>
                                                                    <th>Cantidad a Devolver</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                function actualizarEstado($conn, $codigo_barra_herra, $cantidad)
                                                                {
                                                                    // Actualizar el estado de la herramienta dependiendo de la cantidad
                                                                    $estado = ($cantidad == 0) ? 'prestado' : 'disponible';
                                                                    $sql = "UPDATE herramienta SET esta_herra = :estado WHERE codigo_barra_herra = :codigo_barra";
                                                                    $stmt = $conn->prepare($sql);
                                                                    $stmt->bindParam(':estado', $estado);
                                                                    $stmt->bindParam(':codigo_barra', $codigo_barra_herra);
                                                                    $stmt->execute();
                                                                }

                                                                while ($entrada = $stmt->fetch(PDO::FETCH_ASSOC)):

                                                                    ?>
                                                                <tr style="background-color: <?= $colorFondo ?>;">
                                                                    <td><?= $entrada["codigo_barra_herra"] ?></td>
                                                                    <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                    <td><?= $entrada["nombre_herra"] ?></td>
                                                                    <td><?= $entrada["nom_marca"] ?></td>
                                                                    <td class="image-container">
                                                                        <?php
                                                                            $checkboxDisabled = ($entrada["cantidad"] == 0) ? 'disabled' : '';
                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                        <img src="<?= $imageUrl ?>"
                                                                            alt="Imagen de herramienta"
                                                                            style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                    </td>
                                                                    <td><?= $entrada["cant_herra"] ?></td>
                                                                    <td><?= $entrada["fecha_entrega"] ?></td>
                                                                    <td>
                                                                        <input type="number"
                                                                            value="<?= $entrada["cant_herra"] ?>"
                                                                            class="form-control" name="cantidad"
                                                                            title="deben ser por lo menos una herramienta"
                                                                            required minlength="1" maxlength="2"
                                                                            data-disponible="<?= $entrada['cant_herra'] ?>"
                                                                            data-codigo-barra="<?= $entrada['codigo_barra_herra'] ?>">
                                                                    </td>
                                                                </tr>
                                                                <?php endwhile ?>
                                                            </tbody>
                                                        </table>

                                                        <input type="submit" name="MM_register"
                                                            value="Devolver Herramienta" class="btn btn-orange"
                                                            style="width: 50%;">
                                                        <input type="hidden" name="documento"
                                                            value="<?php echo $documento ?>">
                                                </form>
                                            </div>
                                            <a href="./devolucion.php" class="btn btn-warning btn-sm mt-2" style="width: 10%;">Volver</a>
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
<script>
function validarFormulario() {
    // Obtener todas las entradas de cantidad
    var cantidadInputs = document.querySelectorAll('input[name^="cantidad"]');

    // Verificar si alguna cantidad devuelta es mayor que la cantidad prestada
    for (var i = 0; i < cantidadInputs.length; i++) {
        var cantidadInput = cantidadInputs[i];
        var cantidadDevuelta = parseInt(cantidadInput.value);
        var cantidadPrestada = parseInt(cantidadInput.getAttribute('data-disponible'));

        if (cantidadDevuelta > cantidadPrestada) {
            alert("La cantidad devuelta no puede ser mayor que la cantidad prestada.");
            return false; // Evitar que el formulario se envíe
        }
    }
    return true; // Permitir que el formulario se envíe
}
</script>