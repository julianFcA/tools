<?php
require_once 'template.php';

$documento = $_SESSION['documento'];

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$documento = $_SESSION['documento'] ;

$query = "SELECT usuario.nombre,
usuario.apellido,
usuario.documento,
usuario.correo,
usuario.codigo_barras,
usuario.fecha_registro,
formacion.nom_forma,
jornada.tp_jornada,
deta_ficha.ficha,
deta_ficha.id_deta_ficha,
tp_docu.nom_tp_docu
FROM usuario
INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu
INNER JOIN rol ON usuario.id_rol = rol.id_rol
INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento
INNER JOIN ficha ON deta_ficha.ficha = ficha.ficha
INNER JOIN formacion ON formacion.id_forma = ficha.id_forma
INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada
WHERE ficha.ficha > 0
AND jornada.id_jornada > 1
AND deta_ficha.id_deta_ficha >= 1
AND usuario.id_rol = 3 
AND usuario.documento = $documento";



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
                                                <h4 class="card-title">Actividad | Aprendiz</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!-- Tabla HTML para mostrar los resultados -->
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre de Aprendiz</th>
                                                                <th>Apellido de Aprendiz</th>
                                                                <th>Tipo de Documento</th>
                                                                <th>Numero de Identificación</th>
                                                                <th>Correo de Aprendiz</th>
                                                                <th>Codigo de Barras de Aprendiz</th>
                                                                <th>Fecha de Registro</th>
                                                                <th>Formacion</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
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

                                                                    // Actualiza las variables para reflejar el nuevo estado
                                                                    $estadoClase = 'table-success';
                                                                    $activo = 'Activo';
                                                                    $color = 'green';
                                                                    $mensaje = 'Disponible';
                                                                }

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
                                                                ?>
                                                                <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                                    <td><?= $entrada["nombre"] ?></td>
                                                                    <td><?= $entrada["apellido"] ?></td>
                                                                    <td><?= $entrada["nom_tp_docu"] ?></td>
                                                                    <td><?= $entrada["documento"] ?></td>
                                                                    <td><?= $entrada["correo"] ?></td>
                                                                    <td><img src="../../images/<?= $entrada["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barras"] ?></td>
                                                                    <td><?= $entrada["fecha_registro"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <td><?= $entrada["ficha"] ?></td>
                                                                    <td><?= $entrada["tp_jornada"] ?></td>
                                                                    <!-- revisar bien este form -->
                                                                    <!-- <td>
                                                                            <form method="GET" action="actu_instru.php">
                                                                                <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                                <button class="btn btn-danger" type="submit" name="actu">Actualizar Datos</button>
                                                                            </form>
                                                                        </td> -->
                                                                    <!-- <td>
                                                                            <form method="GET" action="elim_instru.php">
                                                                                <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                                <button class="btn btn-danger" type="submit" name="elimin">Eliminar</button>
                                                                            </form>
                                                                        </td> -->
                                                                </tr>
                                                            <?php  ?>
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
            <a href="excel.php" class="mr-2">
                <img src="../../images/excel1.png" alt="Imagen 2" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="excel.php" class="letra" style="font-size: 14px;">EXCEL</a>
        </div>
        <!-- Agregamos un espacio horizontal -->
        <div style="width: 10px;"></div>
        <div class="ml-3">
            <a href="pdf.php" class="mr-2">
                <img src="../../images/pdf1.png" alt="Imagen 1" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="pdf.php" class="letra" style="font-size: 14px;">PDF</a>
        </div>
    </section>
</div>