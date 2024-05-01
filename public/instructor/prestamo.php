<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

if (isset($_GET['documento'])) {
    $query = "SELECT herramienta.*, tp_herra.nom_tp_herra, marca_herra.* FROM herramienta INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca WHERE herramienta.id_tp_herra >= 1 AND marca_herra.id_marca >= 1";
    $result = $conn->query($query);
    // Definir el número de resultados por página y la página actual
    $porPagina = 20; // Puedes ajustar esto según tus necesidades
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
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
                                                <form action="termino_prestamo.php" method="post">
                                                    <div class="table-responsive" >
                                                        <!-- Tabla HTML para mostrar los resultados -->
                                                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Codigo De Barras</th>
                                                                    <th>Tipo de Herramienta</th>
                                                                    <th>Nombre De Herramienta</th>
                                                                    <th>Marca</th>
                                                                    <th>Imagen</th>
                                                                    <th>Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Estado de Herramienta</th>
                                                                    <th>Seleccionar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($resultado_pagina as $entrada) { ?>
                                                                    <?php
                                                                    // Determinar la clase CSS y el estado del botón según el estado_servi
                                                                    $estadoClase = '';
                                                                    $color = '';
                                                                    $mensaje = '';
                                                                    $botonInactivo = '';
                                                                    $botonCancelar = '';
                                                                    $activo = '';
                                                                    ?>
                                                                    <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                                        <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"></td>
                                                                        <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                        <td><?= $entrada["nombre_herra"] ?></td>
                                                                        <td><?= $entrada["nom_marca"] ?></td>
                                                                        <td class="image-container">
                                                                            <?php
                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                            <img src="<?= $imageUrl ?>" alt="Imagen de atracción">
                                                                        </td>
                                                                        <td><?= $entrada["descripcion"] ?></td>
                                                                        <td><?= $entrada["cantidad"] ?></td>
                                                                        <td><?= $entrada["esta_herra"] ?></td>
                                                                        <td><input type="checkbox" name="herramienta[]" value="<?php echo $entrada['codigo_barra_herra']; ?>" onclick="checkLimit()"></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-orange" style="width: 50%;" onclick="prepareAndRedirect()">Seleccionar Herramientas</button>
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