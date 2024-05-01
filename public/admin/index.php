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
// Muestra el número de resultados obtenidos


// Convierte los resultados a JSON para el console.log
$userdata = json_encode($resultado_pagina);




?>
<script>
 
let dataTable;
let dataTableIsInitialized = false;
var json_data = <?php echo $userdata; ?>;

const dataTableOptions = {
    lengthMenu: [5, 10, 15, 20, 100, 200, 500],
    columnDefs: [
        { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6] },
        { orderable: false, targets: [5, 6] }, // Deshabilita la ordenación en las columnas 5 y 6
        { searchable: true, targets: [0, 1] }  // Habilita explícitamente la búsqueda en las columnas 0 y 1
    ],
    pageLength: 3,
    destroy: true,
    language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "Ningún usuario encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún usuario encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};


const initDataTable = async () => {
    if (dataTableIsInitialized) {
        dataTable.destroy();
    }

    await listUsers();

    dataTable = $("#datatable_users").DataTable(dataTableOptions);

    dataTableIsInitialized = true;
};

const listUsers = async () => {
    try {
        // Cambia la URL al archivo PHP que devuelve los datos de usuario
       

        let content = '';
        json_data.forEach((json_data) => {
            content += `
                <tr>
                    <td>${json_data.nombre}</td>
                    <td>${json_data.apellido}</td>
                    <td>${json_data.documento}</td>
                    <td>${json_data.codigo_barras}</td>
                    <td>${json_data.fecha_registro}</td>
                    <td>${json_data.nom_forma}</td>
                    <td>${json_data.ficha}</td>
                    <td>${json_data.tp_jornada}</td>
                    <td>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>`;
        });
        document.getElementById('tableBody_users').innerHTML = content;
    } catch (ex) {
        alert(ex);
    }
};

window.addEventListener("load", async () => {
    await initDataTable();
});

console.log('Datos obtenidos:', json_data);
</script>
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
                                            <div class="container my-4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <table id="datatable_users" class="table table-striped">
                                                            <caption>
                                                                DataTable.js Demo
                                                            </caption>
                                                            <thead>
                                                                <tr>
                                                                    <th class="centered">Nombre</th>
                                                                    <th class="centered">Apellido</th>
                                                                    <th class="centered">Documento</th>
                                                                    <th class="centered">Codigo de Barras</th>
                                                                    <th class="centered">Fecha de Registro</th>
                                                                    <th class="centered">Formación</th>
                                                                    <th class="centered">Ficha</th>
                                                                    <th class="centered">Jornada</th>
                                                                    <th class="centered">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tableBody_users"></tbody>
                                                        </table>
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
