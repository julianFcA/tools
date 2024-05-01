<?php
require_once 'template.php';

$limit = 100; // Número de filas por página
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;


$query = "SELECT usuario.nombre,usuario.apellido,usuario.documento,usuario.correo,usuario.codigo_barras,usuario.fecha_registro,formacion.nom_forma,jornada.tp_jornada, deta_ficha.ficha, deta_ficha.id_deta_ficha, deta_ficha.documento FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN ficha ON deta_ficha.ficha = ficha.ficha INNER JOIN formacion ON formacion.id_forma = ficha.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada WHERE ficha.ficha > 0 AND jornada.id_jornada > 1 AND deta_ficha.id_deta_ficha >= 1 AND usuario.id_rol = 2";

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
                                                <h4 class="card-title">Actividad | Instructores</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">

                                                    <table id="example" class="display" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Documento</th>
                                                                <th>Correo</th>
                                                                <th>Código de Barras</th>
                                                                <th>Fecha de Registro</th>
                                                                <th>Formación</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Documento</th>
                                                                <th>Correo</th>
                                                                <th>Código de Barras</th>
                                                                <th>Fecha de Registro</th>
                                                                <th>Formación</th>
                                                                <th>Ficha</th>
                                                                <th>Jornada</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>





                                                </div>
                                                <!-- <div class="text-center" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group me-2" role="group" aria-label="First group" aling>
                                                            <?php
                                                            for ($i = 1; $i <= $total_paginas; $i++) {
                                                                echo "<a class='btn btn-primary' href='index.php?pagina=" . $i . "'> " . $i . " </a>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div> -->
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


<script>
    new DataTable('#example', {
        ajax: './ajaxtable.php',
        processing: true,
        serverSide: true
    });

    $(document).ready(function() {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "ajaxtable.php",
            "columns": [{
                    "data": "nombre"
                },
                {
                    "data": "apellido"
                },
                {
                    "data": "documento"
                },
                {
                    "data": "correo"
                },
                {
                    "data": "codigo_barras"
                },
                {
                    "data": "fecha_registro"
                },
                {
                    "data": "nom_forma"
                },
                {
                    "data": "ficha"
                },
                {
                    "data": "tp_jornada"
                },
                {
                    "data": null,
                    "defaultContent": "<button>Acción</button>"
                }
            ]
        });
    });
</script>