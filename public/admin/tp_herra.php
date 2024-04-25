<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM herramienta";

// $query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre, usuario.documento, usuario.correo, usuario.codigo_barras,usuario.ficha, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN formacion ON usuario.ficha = formacion.ficha INNER JOIN jornada ON formacion.id_jornada = jornada.id_jornada WHERE empresa.nit_empre > 0 AND usuario.id_rol = 3";

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
                                                                <th>Dodigo De Barras</th>
                                                                <th>Tipo de Herramienta</th>
                                                                <th>Nombre De Herramienta</th>
                                                                <th>Marca</th>
                                                                <th>Imagen</th>
                                                                <th>Estado de Herramienta</th>
                                                                <th colspan="2">Acción</th>
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

                                                                // $horaFinalizacionPasada = strtotime($entrada["fecha_fin"]) > strtotime("now");

                                                                // if ($entrada["esta_licen"] == 'inactivo' || $horaFinalizacionPasada) {
                                                                //     $estadoClase = 'table-warning';
                                                                //     $botonInactivo = 'disabled';
                                                                //     $color = 'orange';
                                                                //     $mensaje = 'Bloqueado';

                                                                //     // Actualizar el estado en la base de datos
                                                                //     if ($horaFinalizacionPasada) {
                                                                //         $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = :licencia");
                                                                //         $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                                                //         $updateEstado->execute();
                                                                //     } else {
                                                                //         // Si la hora de finalización no ha pasado, pero el estado es 'inactivo', cambia a 'activo'
                                                                //         $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'activo' WHERE licencia = :licencia");
                                                                //         $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                                                //         $updateEstado->execute();
                                                                //     }

                                                                //         // Actualiza las variables para reflejar el nuevo estado
                                                                //         $estadoClase = 'table-success';
                                                                //         $activo = 'Activo';
                                                                //         $color = 'green';
                                                                //         $mensaje = 'Disponible';
                                                                //     }

                                                                // if ($entrada["esta_licen"] == 'inactivo') {
                                                                //     $estadoClase = '';
                                                                //     $botonInactivo = 'disabled';
                                                                //     $color = 'orange';
                                                                //     $mensaje = 'Esta inactivo';
                                                                // } elseif ($entrada["esta_licen"] == 'cancelado') {
                                                                //     $estadoClase = '';
                                                                //     $botonCancelar = 'disabled';
                                                                //     $color = 'red';
                                                                //     $mensaje = 'Esta cancelado';
                                                                // } elseif ($entrada["esta_licen"] == 'activo') {
                                                                //     $estadoClase = '';
                                                                //     $activo = 'disabled';
                                                                //     $color = 'green';
                                                                //     $mensaje = 'activo';
                                                                // }
                                                                // 
                                                                ?> -->
                                                                <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                                    <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barra_herra"] ?></td>
                                                                    <td><?= $entrada["id_tp_herra"] ?></td>
                                                                    <td><?= $entrada["nombre_herra"] ?></td>
                                                                    <td><?= $entrada["marca"] ?></td>
                                                                    <td><?= $entrada["descripcion"] ?></td>
                                                                    <td class="image-container">
                                                                        <?php
                                                                        $imageUrl = '../../images/' . $entrada["imagen"];
                                                                        ?>
                                                                        <img src="<?= $imageUrl ?>" alt="Imagen de atracción">
                                                                    </td>
                                                                    <td><?= $entrada["esta_herra"] ?></td>
                                                                    <!-- revisar bien este form -->
                                                                    <td>
                                                                        <form method="GET" action="actu_herra.php">
                                                                            <input type="hidden" name="codigo_barra_herra" value="<?= $entrada["codigo_barra_herra"] ?>">
                                                                            <button class="btn btn-danger" type="submit" name="actu">Actualizar </button>
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
</div>