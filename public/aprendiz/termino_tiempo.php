<?php
require_once 'template.php';
$documento = $_SESSION['documento'];

// Verifica si se ha enviado un formulario POST y si se han seleccionado herramientas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_deta_presta']) && is_array($_POST['id_deta_presta'])) {
    // Almacena las herramientas seleccionadas en la variable de sesión
    $_SESSION['id_presta'] = $_POST['id_deta_presta'];
} else {
    redirectToPrestamoPage("Debes seleccionar al menos una herramienta del inventario.");
    echo '<script>window.location="./index.php"</script>';
}
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
          WHERE prestamo_herra.documento = $documento AND detalle_prestamo.id_deta_presta IN (";
// Construye la parte dinámica de la consulta con marcadores de posición
$placeholders = implode(',', array_fill(0, count($_SESSION['id_presta']), '?'));
// Completa la consulta
$query .= $placeholders . ")";
// Prepara la consulta
$stmt = $conn->prepare($query);
// Enlaza los valores a los marcadores de posición
$stmt->execute($_SESSION['id_presta']);
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
                                                <h4 class="card-title">Prestamo de Herramienta</h4>

                                            </div>
                                            <div class="card-body">
                                                <form action="prestar_tiempo.php" method="post" onsubmit="return validarFormulario()">
                                                    <class="table-responsive">
                                                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Codigo De Barras</th>
                                                                    <th>Tipo de Herramienta</th>
                                                                    <th>Nombre De Herramienta</th>
                                                                    <th>Marca</th>
                                                                    <th>Imagen</th>
                                                                    <th>Cantidad Prestada</th>
                                                                    <th>Fecha de Entrega</th>
                                                                    <th>Cantidad </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                                while ($entrada = $stmt->fetch(PDO::FETCH_ASSOC)) :

                                                                ?>
                                                                    <tr style="background-color: <?= $colorFondo ?>;">
                                                                        <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barra_herra"] ?>
                                                                    </td>
                                                                        <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                        <td><?= $entrada["nombre_herra"] ?></td>
                                                                        <td><?= $entrada["nom_marca"] ?></td>
                                                                        <td class="image-container">
                                                                            <?php
                                                                            $checkboxDisabled = ($entrada["cantidad"] == 0) ? 'disabled' : '';
                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                            <img src="<?= $imageUrl ?>" alt="Imagen de herramienta" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                        </td>
                                                                        <td><?= $entrada["cant_herra"] ?></td>
                                                                        <td><?= $entrada["fecha_entrega"] ?></td>
                                                                        <td>
                                                                            <input type="number" placeholder="Ingrese cantidad que desea" value="<?= $entrada['cant_herra'] ?>" class="form-control" name="cantidad[<?= $entrada['id_deta_presta'] ?>]" title="deben ser por lo menos una herramienta" required minlength="1" maxlength="2" data-disponible="<?= $entrada['cant_herra'] ?>" data-codigo-barra="<?= $entrada['id_deta_presta'] ?>">

                                                                            <input type="hidden" name="herramienta" value="<?php echo $entrada["codigo_barra_herra"] ?>">
                                                                            <input type="hidden" name="documento" value="<?php echo $entrada["documento"] ?>">
                                                                        </td>
                                                                    </tr>
                                                                <?php endwhile ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        <div class="form-group">
                                                            <label> Dias De Prestamo <a href=""></a></label>
                                                            <select class="form-control" name="dias" id="dias"
                                                                style="width: 50%;" required>
                                                            </select>
                                                        </div>
                                                        
                                                        <input type="submit" name="action" value="Mas Tiempo" class="btn btn-success" style="width: 30%; display: inline-block; margin-right: 2%;">
                                                        <input type="hidden" name="MM_register"
                                                        value="<?php echo $_SESSION['documento'] ?>">
                                                </form>
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

<script>
    var select = document.getElementById('dias');

    // Agregar un event listener para el cambio en el select
    select.addEventListener('change', function () {
        // Obtener el valor seleccionado del select
        var seleccionado = parseInt(select.value);

        // Mostrar el número seleccionado
        var resultadoDiv = document.getElementById('resultado');
        resultadoDiv.textContent = "Número seleccionado: " + seleccionado;
    });

    // Llenar el select con opciones del 1 al 7
    for (var i = 1; i <= 7; i++) {
        var option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        select.appendChild(option);
    }

    function validarFormulario() {
        var herramientas = document.querySelectorAll('input[name^="cantidad"]');
        var mensajeError = "";

        herramientas.forEach(function (herramienta) {
            var cantidad = parseInt(herramienta.value);
            var cantidadDisponible = parseInt(herramienta.dataset.disponible);

            if (isNaN(cantidad) || cantidad <= 0) {
                mensajeError += "La cantidad ingresada debe ser mayor que cero.\n";
            } else if (cantidad > cantidadDisponible) {
                mensajeError +=
                    "La cantidad ingresada es mayor que la cantidad disponible para la herramienta con código de barras " +
                    herramienta.dataset.codigoBarra + ".\n";
            } else if (cantidad > 100) {
                mensajeError += "Solo se permiten cantidades 15 para cada herramienta.\n";
            }
        });

        if (mensajeError !== "") {
            alert(mensajeError);
            return false; // Evitar el envío del formulario
        }

        return true; // Permitir el envío del formulario si todas las validaciones pasan
    }
</script>
