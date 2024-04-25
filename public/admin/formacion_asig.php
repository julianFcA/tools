<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT deta_ficha.*, ficha.ficha, formacion.nom_forma, jornada.tp_jornada
          FROM ficha
          INNER JOIN deta_ficha ON deta_ficha.ficha = ficha.ficha
          INNER JOIN formacion ON ficha.id_forma = formacion.id_forma
          INNER JOIN jornada ON jornada.id_jornada = ficha.id_jornada
          WHERE ficha.ficha > :ficha
          AND formacion.id_forma >= 1
          AND jornada.id_jornada >= 1
          LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($query);
// Se debe definir $ficha_value con el valor real que se desea comparar
$ficha_value = 0; // Se puede cambiar este valor según sea necesario
$stmt->bindParam(':ficha', $ficha_value, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$resultado_pagina = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                                <h4 class="card-title">Actividad | Formaciones Asignadas</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!-- Tabla HTML para mostrar los resultados -->
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>ficha</th>
                                                                <th>Formacion</th>
                                                                <th>Jornada</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($resultado_pagina as $entrada) { ?>
                                                                <tr>
                                                                    <td><?= $entrada["ficha"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <td><?= $entrada["tp_jornada"] ?></td>
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
</div>
