<?php
require_once 'template.php';

// Número de filas por página
$limit = 20; // Número de filas por página

// Página actual
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$nit= $_SESSION['nit_empre'] ;

// Consulta para obtener los datos de la página actual
$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre,usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada,  tp_docu.nom_tp_docu, deta_ficha.ficha, estado_usu.* FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha INNER JOIN formacion ON ficha.id_forma = formacion.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu WHERE empresa.nit_empre ='$nit' AND ficha.ficha >=1 AND jornada.id_jornada >=1 AND usuario.id_rol = 3 LIMIT :limit OFFSET :offset";

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
                                                                <th>Acción</th>
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
                                                                $botonInactivo = '';
                                                                $botonCancelar = '';
                                                                $activo = '';

                                                                // Verificar el estado del usuario
                                                                switch ($entrada["id_esta_usu"]) {
                                                                    case 1:
                                                                        // Usuario activo
                                                                        $estadoClase = 'table-success';
                                                                        $color = 'green';
                                                                        $mensaje = 'Activo';
                                                                        $botonActivar = 'disabled';
                                                                        break;
                                                                    case 2:
                                                                        // Usuario inactivo con licencia pasada
                                                                        $estadoClase = 'table-warning';
                                                                        $color = 'orange';
                                                                        $mensaje = 'Bloqueado';
                                                                        break;
                                                                    case 'activo':
                                                                        // Licencia activa
                                                                        // Actualizar el estado de la licencia en la base de datos a 'inactivo'
                                                                        $updateEstado = $conn->prepare("UPDATE usuario SET id_esta_usu = '2' WHERE documento = :documento");
                                                                        $updateEstado->bindParam(':documento', $entrada["documento"], PDO::PARAM_INT);
                                                                        $updateEstado->execute();

                                                                        $estadoClase = 'table-warning';
                                                                        $botonInactivo = 'disabled';
                                                                        $color = 'orange';
                                                                        $mensaje = 'Bloqueado';
                                                                        break;
                                                                    case 'inactivo':
                                                                        // Licencia inactiva
                                                                        // Actualizar el estado de la licencia en la base de datos a 'activo'
                                                                        $updateEstado = $conn->prepare("UPDATE usuario SET id_esta_usu = '1' WHERE documento = :documento");
                                                                        $updateEstado->bindParam(':documento', $entrada["documento"], PDO::PARAM_INT);
                                                                        $updateEstado->execute();

                                                                        $estadoClase = 'table-success';
                                                                        $activo = 'disabled';
                                                                        $color = 'green';
                                                                        $mensaje = 'Disponible';
                                                                        break;
                                                                    case 'cancelado':
                                                                        $estadoClase = '';
                                                                        $botonCancelar = 'disabled';
                                                                        $color = 'red';
                                                                        $mensaje = 'Cancelado';
                                                                        break;
                                                                    default:
                                                                        // Cualquier otro estado
                                                                        $estadoClase = '';
                                                                        $color = 'orange';
                                                                        $mensaje = 'Inactivo';
                                                                        break;
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
            <a href="excel_ap.php" class="mr-2">
                <img src="../../images/excel1.png" alt="Imagen 2" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="excel_ap.php" class="letra" style="font-size: 14px;">EXCEL</a>
        </div>
        <!-- Agregamos un espacio horizontal -->
        <div style="width: 10px;"></div>
        <div class="ml-3">
            <a href="pdf_ap.php" class="mr-2">
                <img src="../../images/pdf1.png" alt="Imagen 1" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="pdf_ap.php" class="letra" style="font-size: 14px;">PDF</a>
        </div>
    </section>
</div>