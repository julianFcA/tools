<?php
require_once 'template.php';

// Número de filas por página
$porPagina = 10; // Puedes ajustar esto según tus necesidades
// Página actual
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcula el offset basado en la página actual
$empieza = ($pagina - 1) * $porPagina;

// Consulta para obtener el número total de filas sin paginación
$totalRowsQuery = $conn->query("SELECT COUNT(*) as count FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE empresa.nit_empre > 0 AND usuario.id_rol = 1 AND licencia != '65e5b3e7a66b7'");
$totalRows = $totalRowsQuery->fetch(PDO::FETCH_ASSOC)['count'];

// Preparar la consulta SQL con paginación
$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.licencia, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE empresa.nit_empre > 0 AND usuario.id_rol = 1 AND licencia != '65e5b3e7a66b7' LIMIT :porPagina OFFSET :empieza";

// Preparar la consulta
$userEntry = $conn->prepare($query);
// Enlazar los parámetros
$userEntry->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
$userEntry->bindParam(':empieza', $empieza, PDO::PARAM_INT);
// Ejecutar la consulta
$userEntry->execute();

// Obtener los resultados paginados
$resultado_pagina = $userEntry->fetchAll(PDO::FETCH_ASSOC);

?>


<style>
    section img {
        padding: 0 0 0 5%;
        max-width: 10%;
    }

    section .letra {
        color: #000;
    }
</style>
<br>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licencia</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>

<div class="content-body container-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Actividad de Empresas | Estado de Licencia</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Tabla HTML para mostrar los resultados -->
                            <table id="example3" class="table table-striped table-bordered" style="width:100%">
                               <thead>
                                    <tr>
                                        <th>Nit Empresa</th>
                                        <th>Nombre de Empresa</th>
                                        <th>Direccion de Empresa</th>
                                        <th>Telefono de Empresa</th>
                                        <th>Correo de Empresa</th>
                                        <th>Nombre de Administrador</th>
                                        <th>Apellido de Administrador</th>
                                        <th>Numero de Identificación</th>
                                        <th>Correo de Administrador</th>
                                        <th>Fecha de Regristro de Administrador</th>
                                        <th>Codigo de Barras de Administrador</th>
                                        <th>Numero de Licencia</th>
                                        <th>Fecha de Inicio de Licencia</th>
                                        <th>Fecha de Fin de Licencia</th>
                                        <th>Estado Actual</th>
                                        <th>Acción</th>
                                        <th colspan="2">Actualizar Datos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultado_pagina as $entrada) {

                                        // Determinar la clase CSS y el estado del botón según el estado_servi
                                        $estadoClase = '';
                                        $color = '';
                                        $mensaje = '';
                                        $botonInactivo = '';
                                        $botonCancelar = '';
                                        $activo = '';

                                        // Comprobar si la hora de finalización ha pasado
                                        $horaFinalizacionPasada = strtotime($entrada["fecha_fin"]) < strtotime("now");

                                        // Si la licencia está activa y la hora de finalización ha pasado
                                        if ($entrada["esta_licen"] == 'activo' && $horaFinalizacionPasada) {
                                            // Actualizar el estado de la licencia en la base de datos a 'inactivo'
                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'inactivo' WHERE licencia = :licencia");
                                            $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                            $updateEstado->execute();

                                            // Actualizar las variables para reflejar el nuevo estado
                                            $estadoClase = 'table-warning';
                                            $botonInactivo = 'disabled';
                                            $color = 'orange';
                                            $mensaje = 'Bloqueado';
                                        } elseif ($entrada["esta_licen"] == 'inactivo' && !$horaFinalizacionPasada) {
                                            // Si la licencia está inactiva y la hora de finalización no ha pasado
                                            // Actualizar el estado de la licencia en la base de datos a 'activo'
                                            $updateEstado = $conn->prepare("UPDATE licencia SET esta_licen = 'activo' WHERE licencia = :licencia");
                                            $updateEstado->bindParam(':licencia', $entrada["licencia"], PDO::PARAM_INT);
                                            $updateEstado->execute();

                                            // Actualizar las variables para reflejar el nuevo estado
                                            $estadoClase = 'table-success';
                                            $activo = 'disabled';
                                            $color = 'green';
                                            $mensaje = 'Disponible';
                                        } elseif ($entrada["esta_licen"] == 'inactivo' && $horaFinalizacionPasada) {
                                            // Si la licencia está inactiva y la hora de finalización ha pasado
                                            // No es necesario hacer nada aquí, simplemente mantener el estado inactivo
                                            $color = 'orange';
                                            $mensaje = 'Inactivo';
                                        } 
                                        {

                                            // Actualiza las variables para reflejar el nuevo estado
                                            $estadoClase = 'table-success';
                                            $activo = 'activo';
                                            $color = 'green';
                                            $mensaje = 'Disponible';
                                        }

                                        if ($entrada["esta_licen"] == 'inactivo') {
                                            $estadoClase = '';
                                            $botonInactivo = 'disabled';
                                            $color = 'orange';
                                            $mensaje = 'Esta inactivo';
                                        } elseif ($entrada["esta_licen"] == 'cancelado') {
                                            $estadoClase = '';
                                            $botonCancelar = 'disabled';
                                            $color = 'red';
                                            $mensaje = 'Esta cancelado';
                                        } elseif ($entrada["esta_licen"] == 'activo') {
                                            $estadoClase = '';
                                            $activo = 'disabled';
                                            $color = 'green';
                                            $mensaje = 'activo';
                                        }
                                    ?>
                                        <tr class="<?= $estadoClase ?>" style="color: <?php echo $color; ?>">
                                            <td><?= $entrada["nit_empre"] ?></td>
                                            <td><?= $entrada["nom_empre"] ?></td>
                                            <td><?= $entrada["direcc_empre"] ?></td>
                                            <td><?= $entrada["telefono"] ?></td>
                                            <td><?= $entrada["correo_empre"] ?></td>
                                            <td><?= $entrada["nombre"] ?></td>
                                            <td><?= $entrada["apellido"] ?></td>
                                            <td><?= $entrada["documento"] ?></td>
                                            <td><?= $entrada["correo"] ?></td>
                                            <td><?= $entrada["fecha_registro"] ?></td>
                                            <td><img src="../images/<?= $entrada["codigo_barras"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;"><br><?= $entrada["codigo_barras"] ?></td>
                                            <td><?= $entrada["licencia"] ?></td>
                                            <td><?= $entrada["fecha_ini"] ?></td>
                                            <td><?= $entrada["fecha_fin"] ?></td>
                                            <td><?= $entrada["esta_licen"] ?></td>
                                            <!-- revisar bien este form -->
                                            <td>
                                                <form method="GET" action="renovar.php">
                                                    <input type="hidden" name="nit_empre" value="<?= $entrada["nit_empre"] ?>">
                                                    <button class="btn btn-success" type="submit" name="acti" <?= $activo ?>>Renovar</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="actu_empre.php">
                                                    <input type="hidden" name="nit_empre" value="<?= $entrada["nit_empre"] ?>">
                                                    <button class="btn btn-primary" type="submit" name="actu">Actualizar Datos de Empresa</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="actu_admin.php">
                                                    <input type="hidden" name="documento" value="<?= $entrada["documento"] ?>">
                                                    <button class="btn btn-primary" type="submit" name="actu">Actualizar Datos de Administrador</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php
                                    $totalPaginas = ceil($totalRows / $porPagina);
                                    for ($i = 1; $i <= $totalPaginas; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='index.php?pagina=$i'>$i</a></li>";
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <section class="d-flex align-items-center">
        <div class="ml-3">

            <a href="copia/respaldo.php"><img src="../images/copia.png" alt="Imagen"></a>
            <a class="letra"> COPIA DE SEGURIDAD</a>


            <a href="excel.php"><img src="../images/excel.png" alt="Imagen 2"></a>
            <a class="letra" href="excel.php"> EXCEL</a>

            <a href="pdf.php"><img src="../images/pdf.png" alt="Imagen 1"></a>
            <a class="letra" href="pdf.php"> PDF</a>

        </div>
    </section>
</div>
<br><br>

<script>
     $(document).ready(function() {
        $('#example3').DataTable({
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>
