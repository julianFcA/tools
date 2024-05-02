<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

if (isset($_POST['documento'])) {
    $query = "SELECT herramienta.*, 
    tp_herra.nom_tp_herra, 
    marca_herra.*, 
    prestamo_herra.*, 
    detalle_prestamo.*, 
    herramienta.* 
    FROM herramienta 
    INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra
    INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca 
    INNER JOIN detalle_prestamo ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra  
    INNER JOIN prestamo_herra ON detalle_prestamo.id_presta = prestamo_herra.id_presta
    WHERE herramienta.id_tp_herra >= 1 AND marca_herra.id_marca >= 1";

    $result = $conn->query($query);
    // Definir el número de resultados por página y la página actual
    $porPagina = 20; // Puedes ajustar esto según tus necesidades
    $pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
    $empieza = ($pagina - 1) * $porPagina;
    // Inicializa la variable $resultado_pagina
    $resultado_pagina = $result->fetchAll(PDO::FETCH_ASSOC);
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
                                                <h4 class="card-title">Prestamo de Herramienta</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="termino_devo.php" method="post">
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
                                                                    <th>Estado de Prestamo</th>
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
                                                                        <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                        </td>
                                                                        <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                        <td><?= $entrada["nombre_herra"] ?></td>
                                                                        <td><?= $entrada["nom_marca"] ?></td>
                                                                        <td class="image-container">
                                                                            <?php
                                                                            $checkboxDisabled = ($entrada["cantidad"] == 0) ? 'disabled' : '';
                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                            <img src="<?= $imageUrl ?>" alt="Imagen de atracción">
                                                                        </td>
                                                                        <td><?= $entrada["fecha_adqui"] ?></td>
                                                                        <td><?= $entrada["cant_herra"] ?></td>
                                                                        <td><?= $entrada["estado_prestamo"] ?><td>
                                                                        <td><?= $entrada["fecha_entrega"] ?></td>
                                                                        <td><input type="checkbox" name="herramienta[]" value="<?php echo $entrada['codigo_barra_herra']; ?>" onclick="checkLimit()" <?= $checkboxDisabled ?>></td>
                                                                    </tr>
                                                                <?php }; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-orange" style="width: 50%;" name="documento" value="<?php echo $_POST['documento'] ?>" onclick="prepareAndRedirect()">Devolver Herramientas</button>
                                                </form>
                                                <br>
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
</script>