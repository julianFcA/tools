<?php
require_once 'template.php';

$docu = $_SESSION['documento'];

$limit = 100; // Número de filas por página
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Página actual

// Calcula el offset basado en la página actual
$offset = ($page - 1) * $limit;

$query = "SELECT empresa.*, herramienta.*, tp_herra.nom_tp_herra, marca_herra.* 
    FROM empresa 
    INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre 
    LEFT JOIN herramienta ON empresa.nit_empre = herramienta.nit_empre 
    INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra 
    INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca 
    WHERE empresa.nit_empre = :nit 
    AND tp_herra.id_tp_herra >= 1 
    AND marca_herra.id_marca >= 1";

$result = $conn->prepare($query);
$result->bindParam(':nit', $nit, PDO::PARAM_STR);
$result->execute();
// Definir el número de resultados por página y la página actual
$porPagina = 20; // Puedes ajustar esto según tus necesidades
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
$empieza = ($pagina - 1) * $porPagina;
// Inicializa la variable $resultado_pagina
$resultado_pagina = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<?php 
$permiso = "SELECT detalle_prestamo.*, prestamo_herra.* FROM prestamo_herra INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta WHERE detalle_prestamo.estado_presta = 'prestado' OR detalle_prestamo.estado_presta = 'reportado una parte' AND prestamo_herra.documento = :documento";
$permi = $conn->prepare($permiso);
$permi->bindParam(':documento', $docu, PDO::PARAM_STR);
$permi->execute();

$hayPrestamo = $permi->rowCount() > 0; // Si la consulta devuelve filas, hay un préstamo activo

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
                                                <h4 class="card-title">Prestamo de Herramienta</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="termino_prestamo.php" method="post">
                                                    <div class="table-responsive">
                                                        <!-- Tabla HTML para mostrar los resultados -->
                                                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Codigo De Barras</th>
                                                                    <th>Tipo de Herramienta</th>
                                                                    <th>Nombre De Herramienta</th>
                                                                    <th>Marca</th>
                                                                    <th>Imagen</th>
                                                                    <th>Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Estado de Herramienta</th>
                                                                    <th>Seleccionar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                function actualizarEstado($conn, $codigo_barra_herra, $cantidad)
                                                                {
                                                                    // Actualizar el estado de la herramienta dependiendo de la cantidad
                                                                    $estado = ($cantidad == 0) ? 'prestado' : 'disponible';
                                                                    $sql = "UPDATE herramienta SET esta_herra = :estado WHERE codigo_barra_herra = :codigo_barra";
                                                                    $stmt = $conn->prepare($sql);
                                                                    $stmt->bindParam(':estado', $estado);
                                                                    $stmt->bindParam(':codigo_barra', $codigo_barra_herra);
                                                                    $stmt->execute();
                                                                }

                                                                foreach ($resultado_pagina as $entrada) {
                                                                    // Actualizar el estado y la cantidad de la herramienta
                                                                    actualizarEstado($conn, $entrada["codigo_barra_herra"], $entrada["cantidad"]);

                                                                    // Definir el color de fondo según el estado de la herramienta
                                                                    $colorFondo = ($entrada["esta_herra"] == 'disponible') ? '#c3e6cb' : '#f5c6cb';
                                                                ?>
                                                                    <tr style="background-color: <?= $colorFondo ?>;">
                                                                        <td><img src="../../images/<?= $entrada["codigo_barra_herra"] ?>.png" style="max-width: 300px; height: auto; border: 2px solid #ffffff;">
                                                                        </td>
                                                                        <td><?= $entrada["nom_tp_herra"] ?></td>
                                                                        <td><?= $entrada["nombre_herra"] ?></td>
                                                                        <td><?= $entrada["nom_marca"] ?></td>
                                                                        <td class="image-container">
                                                                            <?php
                                                                            $checkboxDisabled = ($entrada["cantidad"] == 0) ? 'disabled' : '';
                                                                            $imageUrl = '../../images/' . $entrada["imagen"];
                                                                            ?>
                                                                            <img src="<?= $imageUrl ?>" alt="Imagen de atracción">
                                                                        </td>
                                                                        <td><?= $entrada["descripcion"] ?></td>
                                                                        <td><?= $entrada["cantidad"] ?></td>
                                                                        <td><?= $entrada["esta_herra"] ?></td>
                                                                        <td><input type="checkbox" name="herramienta[]" value="<?php echo $entrada['codigo_barra_herra']; ?>" onclick="checkLimit()" <?= $checkboxDisabled ?>></td>
                                                                    </tr>
                                                                <?php }; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>

                                                    <button type="submit" class="btn btn-orange" style="width: 50%;" name="documento" value="<?php echo $_SESSION['documento'] ?>" onclick="prepareAndRedirect()" <?php if ($hayPrestamo) echo 'disabled'; ?>>Seleccionar Herramientas</button>
                                                </form>
                                                <br>
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
<script>
    function checkLimit() {
        const maxSelections = 3;
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let checkedCount = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedCount++;
                if (checkedCount > maxSelections) {
                    checkbox.checked = false; // Desmarcar checkbox si se supera el límite
                }
            }
        });
    }
</script>