<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = ("SELECT herramienta.* , tp_herra.nom_tp_herra, marca_herra.* FROM herramienta INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca WHERE herramienta.id_tp_herra >= 1 AND marca_herra.id_marca >= 1");

$result = $conn->query($query);

// Definir el número de resultados por página y la página actual
$porPagina = 20; // Puedes ajustar esto según tus necesidades
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$empieza = ($pagina - 1) * $porPagina;

// Inicializa la variable $resultado_pagina
$resultado_pagina = $result->fetchAll(PDO::FETCH_ASSOC);

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
                                                <h4 class="card-title">Actividad | Herramientas</h4>
                                            </div>
                                            <div class="card-body">
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
                                                                <th>Descripción</th>
                                                                <th>Cantidad</th>
                                                                <th>Estado de Herramienta</th>
                                                                <th colspan="2">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            function actualizarEstado($conn, $codigo_barra_herra, $estado)
                                                            {
                                                                $sql = "UPDATE herramienta SET esta_herra = :estado WHERE codigo_barra_herra = :codigo_barra";
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->bindParam(':estado', $estado);
                                                                $stmt->bindParam(':codigo_barra', $codigo_barra_herra);
                                                                $stmt->execute();
                                                            }
                                                            
                                                            foreach ($resultado_pagina as $entrada) {
                                                                // Actualizar el estado de la herramienta dependiendo de la cantidad
                                                                if ($entrada["cantidad"] == 0) {
                                                                    actualizarEstado($conn, $entrada["codigo_barra_herra"], 'prestado');
                                                                } else {
                                                                    actualizarEstado($conn, $entrada["codigo_barra_herra"], 'disponible');
                                                                }
                                                            
                                                                // Definir el color de fondo según el estado de la herramienta
                                                                $colorFondo = ($entrada["esta_herra"] == 'disponible') ? '#c3e6cb' : '#f5c6cb';
                                                            ?>
                                                                <tr style="background-color: <?= $colorFondo ?>;">
                                                                    <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barra_herra"] ?></td>
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
                                                                    <!-- revisar bien este form -->
                                                                    <td>
                                                                        <form method="GET" action="actu_herra.php">
                                                                            <input type="hidden" name="codigo_barra_herra" value="<?= $entrada["codigo_barra_herra"] ?>">
                                                                            <button class="btn btn-success" type="submit" name="actu">Actualizar </button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form method="GET" action="elim_herra.php">
                                                                            <input type="hidden" name="codigo_barra_herra" value="<?= $entrada["codigo_barra_herra"] ?>">
                                                                            <button class="btn btn-danger" type="submit" name="elimin">Eliminar</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
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
    <section class="d-flex align-items-center">
        <div class="ml-3">
            <a href="excel_herra.php" class="mr-2">
                <img src="../../images/excel1.png" alt="Imagen 2" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="excel_herra.php" class="letra" style="font-size: 14px;">EXCEL</a>
        </div>
        <!-- Agregamos un espacio horizontal -->
        <div style="width: 10px;"></div>
        <div class="ml-3">
            <a href="pdf_herra.php" class="mr-2">
                <img src="../../images/pdf1.png" alt="Imagen 1" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="pdf_herra.php" class="letra" style="font-size: 14px;">PDF</a>
        </div>
    </section>
</div>