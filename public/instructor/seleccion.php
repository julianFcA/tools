<?php
require_once 'template.php';

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["herramientas"])) {
    // Recibir los IDs de las herramientas seleccionadas
    $herramientasSeleccionadas = unserialize(urldecode($_GET["herramientas"]));
    // Aquí puedes hacer lo que necesites con los IDs recibidos, por ejemplo, realizar consultas adicionales o mostrar los detalles de las herramientas
} else {
    // Si no se reciben las herramientas seleccionadas, puedes mostrar un mensaje de error o realizar otra acción
}
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
} else {
    // Inicializa la variable $resultado_pagina con un array vacío
    $resultado_pagina = [];
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
                                                <h4 class="card-title">Agregar Cantidad</h4>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                                                                    <th>Cantidad</th>
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
                                                                        <td><?= $entrada["cantidad"] ?></td>
                                                                        <td><input type='checkbox' style="background-color: orange; color: white; width: 100%;" name='seleccion[]' value="<?= $entrada['codigo_barra_herra'] ?>"></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <input type="submit" name="submit" value="Prestar" class="btn-primary" style="width: 50%">
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

