<?php
require_once 'template.php';

$docu = $_SESSION['documento'];

$limit = 100; // Número de filas por página
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

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
          tp_herra.id_tp_herra >= 1 AND 
          marca_herra.id_marca >= 1 AND detalle_prestamo.estado_presta = 'prestado' or detalle_prestamo.estado_presta = 'incompleto' or detalle_prestamo.estado_presta = 'tarde'or detalle_prestamo.estado_presta = 'reportado una parte'";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':documento', $docu);
    $result = $stmt->execute();
    $resultado_pagina = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
$permiso = "SELECT detalle_prestamo.*, prestamo_herra.* FROM prestamo_herra INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta WHERE detalle_prestamo.estado_presta = 'tarde' OR detalle_prestamo.estado_presta = 'bloqueado' OR detalle_prestamo.estado_presta = 'reportado' AND prestamo_herra.documento = :documento";
$permi = $conn->prepare($permiso);
$permi->bindParam(':documento', $docu, PDO::PARAM_STR);
$permi->execute();

$hayPrestamo = $permi->rowCount() > 0; // Si la consulta devuelve filas, hay un préstamo activo

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
                                                <h4 class="card-title">Mas Tiempo de Prestamo de Herramienta</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="termino_tiempo.php" method="post">
                                                    <div class="table-responsive">
                                                        <!-- Tabla HTML para mostrar los resultados -->
                                                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
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

                                                                foreach ($resultado_pagina as $entrada) {
                                                                    // Actualizar el estado y la cantidad de la herramienta
                                                                    actualizarEstado($conn, $entrada["codigo_barra_herra"], $entrada["cantidad"]);

                                                                    // Definir el color de fondo según el estado de la herramienta
                                                                    $colorFondo = ($entrada["esta_herra"] == 'disponible') ? '#c3e6cb' : '#f5c6cb';


                                                                ?>
                                                                    <tr style="background-color: <?= $colorFondo ?>;">
                                                                        <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barra_herra"] ?>
                                                                        <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                        <td><?= $entrada["nombre_herra"] ?></td>
                                                                        <td><?= $entrada["nom_marca"] ?></td>
                                                                        <td class="image-container">
                                                                            <?php

                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                            <img src="<?= $imageUrl ?>" alt="Imagen de herramienta" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                        </td>
                                                                        <td><?= $entrada["fecha_adqui"] ?></td>
                                                                        <td><?= $entrada["cant_herra"] ?></td>
                                                                        <td><?= $entrada["dias"] ?></td>
                                                                        <td><?= $entrada["fecha_entrega"] ?></td>
                                                                        <td><input type="checkbox" name="id_deta_presta[]" value="<?= $entrada['id_deta_presta'] ?>" onclick="checkLimit()"></td>
                                                                        </td>
                                                                    </tr>
                                                                <?php }; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-orange" style="width: 50%;" name="documento" value="<?php echo $_SESSION['documento'] ?>" onclick="prepareAndRedirect()" <?php if ($hayPrestamo) echo 'disabled'; ?>>Pedir Mas Tiempo</button>
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