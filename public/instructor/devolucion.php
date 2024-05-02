<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

if (isset($_POST['documento'])) {
    $documento_usuario = $_POST['documento'];

    $query = "SELECT 
        herramienta.*, 
        tp_herra.nom_tp_herra, 
        marca_herra.nom_marca, 
        prestamo_herra.*, 
        detalle_prestamo.* 
    FROM herramienta 
    INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra
    INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca 
    INNER JOIN detalle_prestamo ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra  
    INNER JOIN prestamo_herra ON detalle_prestamo.id_presta = prestamo_herra.id_presta
    WHERE prestamo_herra.documento = :documento AND
          herramienta.id_tp_herra >= 1 AND 
          marca_herra.id_marca >= 1";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':documento', $documento_usuario);
    $result = $stmt->execute();
    $resultado_pagina = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="content-wrapper">
    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <!-- Main content starts -->
        <div class="tab-list">
            <!-- Row Starts -->
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
                                                <form action="termino_devo.php" method="post">
                                                    <div class="table-responsive">
                                                        <!-- Tabla HTML para mostrar los resultados -->
                                                        <table id="example3" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Codigo De Barras</th>
                                                                    <th>Tipo de Herramienta</th>
                                                                    <th>Nombre De Herramienta</th>
                                                                    <th>Marca</th>
                                                                    <th>Imagen</th>
                                                                    <th>Fecha de Adquisición</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Dias</th>
                                                                    <th>Fecha de Entrega</th>
                                                                    <th>Seleccionar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($resultado_pagina as $entrada) {
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
                                                                    <td><?= $entrada["fecha_adqui"] ?></td>
                                                                    <td><?= $entrada["cant_herra"] ?></td>
                                                                    <td><?= $entrada["dias"] ?></td>
                                                                    <td><?= $entrada["fecha_entrega"] ?></td>
                                                                    <td><input type="checkbox" name="herramienta[]"
                                                                            value="<?= $entrada['codigo_barra_herra'] ?>"
                                                                            onclick="checkLimit()"
                                                                            <?= $checkboxDisabled ?>></td>
                                                                    <!-- Campos ocultos para enviar cantidades e IDs de herramientas -->
                                                                    <input type="hidden" name="cantidades[]"
                                                                        value="<?= $entrada['cant_herra'] ?>">
                                                                    <input type="hidden" name="herramienta_ids[]"
                                                                        value="<?= $entrada['codigo_barra_herra'] ?>">
                                                                </tr>
                                                                <?php }; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-orange" style="width: 50%;"
                                                        name="documento" value="<?php echo $documento_usuario ?>"
                                                        onclick="prepareAndRedirect()">Devolver Herramientas</button>
                                                </form>
                                                <br>
                                                <a href="./index.php" class="btn btn-warning btn-sm mt-2" style="width: 10%;">Volver</a>
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
function checkLimit() {
    const maxSelections = 3;
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let checkedCount = 0;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checkedCount++;
            if (checkedCount > maxSelections) {
                checkbox.checked = false; // Desmarcar checkbox si se supera el límite
            }
        }
    });
}

function prepareAndRedirect() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selectedToolIds = [];
    const selectedToolQuantities = [];

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedToolIds.push(checkbox.value);
            const quantityInput = document.querySelector(
                `input[name="cantidades[]"][value="${checkbox.value}"]`);
            selectedToolQuantities.push(quantityInput.value);
        }
    });

    const toolsInput = document.querySelector('input[name="herramienta_ids"]');
    const quantitiesInput = document.querySelector('input[name="cantidades"]');
    toolsInput.value = selectedToolIds.join(',');
    quantitiesInput.value = selectedToolQuantities.join(',');
}
</script>