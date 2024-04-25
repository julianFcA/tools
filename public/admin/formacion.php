<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM formacion WHERE formacion.id_forma >= 1  ";
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
                                                <h4 class="card-title">Actividad | Formaciones</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <!-- Tabla HTML para mostrar los resultados -->
                                                    <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>N°</th>
                                                                <th>Formacion</th>
                                                                <th>Accion</th>
                                                                <!-- <th colspan="2">Acción</th> -->
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
                                                                    <td><?= $entrada["id_forma"] ?></td>
                                                                    <td><?= $entrada["nom_forma"] ?></td>
                                                                    <!-- revisar bien este form -->
                                                                    <td>
                                                                        <form method="GET" action="elim_forma.php">
                                                                            <input type="hidden" name="id_forma" value="<?= $entrada["id_forma"] ?>">
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

    <form action="subir_excel_forma.php" method="post" enctype="multipart/form-data" style="max-width: 300px;">
        <input type="file" name="archivo_excel" accept=".xls,.xlsx" style="width: 100%;">
        <button type="submit" name="submit" style="background-color: orange; color: white; width: 100%;">Subir archivo</button>
    </form>
    <br><br>

    <h1>Estructura del archivo Excel para subir formaciones</h1>
    <h6 class="text-black">Para subir un archivo CSV a nuestra base de datos, por favor sigue la siguiente estructura:</h6>
    <br>
    <div class="card-body">
        <table id="example3" class="table table-striped table-bordered" style="width:80%; max-width: 80%;">
            <thead>
                <tr>
                    <th>primera columna</th>
                    <th>segunda columna</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>numeros descendentes empieza desde el 1</td>
                    <td>Nombre de formacion</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>