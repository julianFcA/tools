<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, entrada_usu.fecha_entrada, tp_docu.nom_tp_docu, deta_ficha.ficha, prestamo_herra.* 
          FROM usuario 
          INNER JOIN rol ON usuario.id_rol = rol.id_rol 
          INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento 
          INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha 
          INNER JOIN formacion ON ficha.id_forma = formacion.id_forma 
          INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada
          INNER JOIN prestamo_herra ON prestamo_herra.documento = usuario.documento 
          INNER JOIN entrada_usu ON usuario.documento = entrada_usu.documento 
          INNER JOIN (
              SELECT documento, MAX(fecha_entrada) AS ultima_entrada 
              FROM entrada_usu 
              GROUP BY documento
          ) ultima_entrada ON entrada_usu.documento = ultima_entrada.documento AND entrada_usu.fecha_entrada = ultima_entrada.ultima_entrada 
          INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
          WHERE ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3 
          LIMIT :limite OFFSET :inicio";

$stmt = $conn->prepare($query);
$stmt->bindValue(':limite', $limit, PDO::PARAM_INT);
$stmt->bindValue(':inicio', $offset, PDO::PARAM_INT);
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
                                                <h4 class="card-title">Actividad de Aprendices | Reporte de Prestamo</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!-- Tabla HTML para mostrar los resultados -->
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Tipo de Documento</th>
                                                                <th>Documento</th>
                                                                <th>Formación</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
                                                                <th>Dodigo De Barras Herramienta</th>
                                                                <th>Tipo de Herramienta</th>
                                                                <th>Marca</th>
                                                                <th>Nombre De Herramienta</th>
                                                                <th>Imagen</th>
                                                                <th>Prestamo</th>
                                                                <th>Fecha de Prestamo</th>
                                                                <th>Devolucion</th>
                                                                <th>Fecha de Devolucion</th>
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

                                                                $horaFinalizacionPasada = strtotime($entrada["dias"]) < strtotime("now");

                                                                // Si la licencia está activa y la hora de finalización ha pasado
                                                                if ($entrada["estado_prestamo"] == 'salvado' && $horaFinalizacionPasada) {
                                                                    // Actualizar el estado de la licencia en la base de datos a 'inactivo'
                                                                    $updateEstado = $conn->prepare("UPDATE prestamo_herra SET estado_prestamo = 'reportado' WHERE id_presta = :id_presta");
                                                                    $updateEstado->bindParam(':id_presta', $entrada["id_presta"], PDO::PARAM_INT);
                                                                    $updateEstado->execute();

                                                                    // Actualizar las variables para reflejar el nuevo estado
                                                                    $estadoClase = 'table-warning';
                                                                    $botonInactivo = 'disabled';
                                                                    $color = 'orange';
                                                                    $mensaje = 'reportado';
                                                                } elseif ($entrada["estado_prestamo"] == 'reportado' && !$horaFinalizacionPasada) {
                                                                    // Si la licencia está inactiva y la hora de finalización no ha pasado
                                                                    // Actualizar el estado de la licencia en la base de datos a 'activo'
                                                                    $updateEstado = $conn->prepare("UPDATE prestamo_herra SET estado_prestamo = 'salvado' WHERE id_presta = :id_presta");
                                                                    $updateEstado->bindParam(':id_presta', $entrada["id_presta"], PDO::PARAM_INT);
                                                                    $updateEstado->execute();

                                                                    // Actualizar las variables para reflejar el nuevo estado
                                                                    $estadoClase = 'table-success';
                                                                    $activo = 'disabled';
                                                                    $color = 'green';
                                                                    $mensaje = 'Disponible';
                                                                } elseif ($entrada["estado_prestamo"] == 'inactivo' && $horaFinalizacionPasada) {
                                                                    // Si la licencia está inactiva y la hora de finalización ha pasado
                                                                    // No es necesario hacer nada aquí, simplemente mantener el estado inactivo
                                                                    $color = 'orange';
                                                                    $mensaje = 'Inactivo';
                                                                } {

                                                                    // Actualiza las variables para reflejar el nuevo estado
                                                                    $estadoClase = 'table-success';
                                                                    $activo = 'activo';
                                                                    $color = 'green';
                                                                    $mensaje = 'Disponible';
                                                                }

                                                                if ($entrada["estado_prestamo"] == 'reportado') {
                                                                    $estadoClase = '';
                                                                    $botonCancelar = 'disabled';
                                                                    $color = 'red';
                                                                    $mensaje = 'reportado';
                                                                } elseif ($entrada["estado_prestamo"] == 'salvado') {
                                                                    $estadoClase = '';
                                                                    $activo = 'disabled';
                                                                    $color = 'green';
                                                                    $mensaje = 'paz y salvo';
                                                                }

                                                                ?>
                                                                <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                                    <td><?= $entrada["nombre"] ?></td>
                                                                    <td><?= $entrada["apellido"] ?></td>
                                                                    <td><?= $entrada["nom_tp_docu"] ?></td>
                                                                    <td><?= $entrada["documento"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <td><?= $entrada["ficha"] ?></td>
                                                                    <td><?= $entrada["tp_jornada"] ?></td>
                                                                    <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barra_herra"] ?></td>
                                                                    <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                    <td><?= $entrada["marca"] ?></td>
                                                                    <td><?= $entrada["nombre_herra"] ?></td>
                                                                    <td class="image-container">
                                                                        <?php
                                                                        $imageUrl = '../../images/' . $entrada["imagen"];
                                                                        ?>
                                                                        <img src="<?= $imageUrl ?>" alt="Imagen de atracción">
                                                                    </td>
                                                                    <td><?= $entrada["id_presta"] ?></td>
                                                                    <td><?= $entrada["fecha_adqui"] ?></td>
                                                                    <td><?= $entrada["esta_herra"] ?></td>
                                                                    <!-- revisar bien este form -->
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