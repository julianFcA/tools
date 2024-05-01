<?php
require_once 'template.php';

// Consulta SQL
$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada, tp_docu.nom_tp_docu, deta_ficha.ficha 
          FROM empresa 
          INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre 
          LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  
          INNER JOIN rol ON usuario.id_rol = rol.id_rol 
          INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento 
          INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha 
          INNER JOIN formacion ON ficha.id_forma = formacion.id_forma 
          INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada 
          INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
          WHERE empresa.nit_empre > 0 AND ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 2";

$result = $conn->query($query);

// Obtener todos los resultados de la consulta
$resultado_pagina = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="tab-list">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="card-header">
                        <div class="content-body container-table">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Actividad | Instructores</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre de Instructor</th>
                                                                <th>Apellido de Instructor</th>
                                                                <th>Numero de Identificación</th>
                                                                <th>Correo de Instructor</th>
                                                                <th>Codigo de Barras de Administrador</th>
                                                                <th>Fecha de Registro</th>
                                                                <th>Formacion</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
                                                                <th>Asignación de Formación</th>
                                                                <th colspan="2">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($resultado_pagina as $entrada) { ?>
                                                                <tr>
                                                                    <td><?= $entrada["nombre"] ?></td>
                                                                    <td><?= $entrada["apellido"] ?></td>
                                                                    <td><?= $entrada["documento"] ?></td>
                                                                    <td><?= $entrada["correo"] ?></td>
                                                                    <td>
                                                                        <img src="../../images/<?= $entrada["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                        <?= $entrada["codigo_barras"] ?>
                                                                    </td>
                                                                    <td><?= $entrada["fecha_registro"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <td><?= $entrada["ficha"] ?></td>
                                                                    <td><?= $entrada["tp_jornada"] ?></td>
                                                                    <td>
                                                                        <form method="GET" action="asigna.php">
                                                                            <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                            <button class="btn btn-success" type="submit" name="asigna">Asignación</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form method="GET" action="actu_instru.php">
                                                                            <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                                            <button class="btn btn-primary" type="submit" name="actu">Actualizar Datos</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form method="GET" action="elim_asigna.php">
                                                                            <input type="hidden" name="ficha" value="<?= $entrada["ficha"] ?>">
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
            <a href="excel.php" class="mr-2">
                <img src="../../images/excel1.png" alt="Imagen 2" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="excel.php" class="letra" style="font-size: 14px;">EXCEL</a>
        </div>
        <div style="width: 10px;"></div>
        <div class="ml-3">
            <a href="pdf.php" class="mr-2">
                <img src="../../images/pdf1.png" alt="Imagen 1" class="img-fluid" style="max-height: 30px;">
            </a>
            <a href="pdf.php" class="letra" style="font-size: 14px;">PDF</a>
        </div>
    </section>
</div>
