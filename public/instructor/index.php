<?php
require_once 'template.php';

// Número de filas por página
$limit = 20; // Número de filas por página

// Página actual
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

// Consulta para obtener los datos de la página actual
$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre,usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada,  tp_docu.nom_tp_docu, deta_ficha.ficha, estado_usu. * FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha INNER JOIN formacion ON ficha.id_forma = formacion.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu WHERE empresa.nit_empre > 0 AND ficha.ficha >=1 AND jornada.id_jornada >=1 AND usuario.id_rol = 3 LIMIT :limit OFFSET :offset"; // Agregar los marcadores de posición de límite y desplazamiento

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
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
                                                <h4 class="card-title">Actividad de Aprendices</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!-- Tabla HTML para mostrar los resultados -->
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre de Aprendiz</th>
                                                                <th>Numero de Identificación</th>
                                                                <th>Correo de Instructor</th>
                                                                <th>Codigo de Barras de Administrador</th>
                                                                <th>Fecha de Registro</th>
                                                                <th>Formacion</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
                                                                <th colspan="3">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($resultado_pagina as $entrada) { ?>
                                                                <?php
                                                                // Inicializar variables
                                                                $estadoClase = '';
                                                                $color = '';
                                                                $mensaje = '';
                                                                $botonActivar = '';

                                                                // Verificar el estado del usuario
                                                                if ($entrada["id_esta_usu"] == 1) {
                                                                    // Usuario inactivo, bloquear el botón de activar
                                                                    $estadoClase = '';
                                                                    $color = 'green';
                                                                    $mensaje = 'Activo';
                                                                    $botonActivar = 'disabled';
                                                                } else {
                                                                    // Usuario en cualquier otro estado, habilitar el botón de activar
                                                                    $estadoClase = 'table-success';
                                                                    $color = 'orange';
                                                                    $mensaje = 'Inactivo';
                                                                    $botonActivar = '';
                                                                }
                                                                ?>
                                                                <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                                                    <td><?= $entrada["nombre"] ?></td>
                                                                    <td><?= $entrada["documento"] ?></td>
                                                                    <td><?= $entrada["correo"] ?></td>
                                                                    <td><img src="../../images/<?= $entrada["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><?= $entrada["codigo_barras"] ?>
                                                                    </td>
                                                                    <td><?= $entrada["fecha_registro"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <td><?= $entrada["ficha"] ?></td>
                                                                    <td><?= $entrada["tp_jornada"] ?></td>
                                                                    <!-- revisar bien este form -->
                                                                    <td>
                                                                        <form method="post" action="./prestamo.php">
                                                                            <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                            <button class="btn btn-success" type="submit" name="prest">Prestar Herramienta</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form method="POST" action="./devolucion.php">
                                                                            <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                            <button class="btn btn-orange" type="submit" name="devolv">Devolver Herramienta</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form method="POST" action="./estado.php">
                                                                            <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                            <button class="btn btn-primary" type="submit" name="activar" <?= $botonActivar ?>>Activar</button>
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