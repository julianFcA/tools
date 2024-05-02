<?php
require_once 'template.php';

// Verifica si se ha enviado un formulario POST y si se han seleccionado herramientas
if (isset($_POST['accion']) && isset($_POST['documento'])) {
    $documento = $_POST['documento'];
    $accion = $_POST['accion'];

    // Si la acción es "buen estado"
    if ($accion === "Devulto") {
        // Actualizar el estado del préstamo a devuelto
        actualizarEstadoPrestamo($conn, $documento, 'devuelto');

        // Insertar registro en detalle_pretamo con cantidad devuelta, herramienta y estado devuelto
        foreach ($_SESSION['herramientas'] as $codigo_barra_herra) {
            insertarDetallePrestamo($conn, $codigo_barra_herra, $documento, 'devuelto');
        }
    }
    // Si la acción es "reportar daño"
    elseif ($accion === "reportado" && isset($_POST['detalle_danio'])) {
        // Actualizar el estado del préstamo a dañado
        actualizarEstadoPrestamo($conn, $documento, 'danado');

        // Registrar detalle de reporte
        $detalle_danio = $_POST['detalle_danio'];
        registrarDetalleReporte($conn, $documento, $detalle_danio);
    }
}

// Función para actualizar el estado del préstamo
function actualizarEstadoPrestamo($conn, $documento, $estado)
{
    $sql = "UPDATE detalle_prestamo SET estado = :estado WHERE id_presta = :documento";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':documento', $documento);
    $stmt->execute();
}

// Función para insertar registro en detalle_pretamo
function insertarDetallePrestamo($conn, $codigo_barra_herra, $id_prestamo, $estado)
{
    // Obtener la cantidad devuelta para esta herramienta
    $cantidad_devuelta = $_POST['cantidad'][$codigo_barra_herra];

    // Insertar registro en detalle_pretamo
    $sql = "INSERT INTO detalle_prestamo (codigo_barra_herra, id_prestamo, estado, cant_herra) 
            VALUES (:codigo_barra_herra, :id_prestamo, :estado, :cantidad_devuelta)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo_barra_herra', $codigo_barra_herra);
    $stmt->bindParam(':id_prestamo', $id_prestamo);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cantidad_devuelta', $cantidad_devuelta);
    $stmt->execute();
}

// Función para registrar el detalle del reporte
function registrarDetalleReporte($conn, $documento, $detalle_danio)
{
    // Aquí deberías insertar los detalles del reporte en la tabla detalle_reporte
}

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
                                                <h4 class="card-title">Devolución de Herramienta</h4>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" onsubmit="return validarFormulario()" class="mb-3">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                            <!-- Cabezal de la tabla -->
                                                        </table>
                                                    </div>

                                                    <!-- Botones -->
                                                    <div class="row">
                                                        <!-- Botón para marcar como buen estado -->
                                                        <div class="col">
                                                            <button type="submit" name="accion" value="Devulto" class="btn btn-success btn-block">Devolver Herramientas</button>
                                                        </div>

                                                        <!-- Botón para reportar daño -->
                                                        <div class="col">
                                                            <button type="submit" name="accion" value="reportado" class="btn btn-danger btn-block">Reportar Daño o Anomalia</button>
                                                        </div>
                                                    </div>

                                                    <!-- Input oculto para pasar el documento -->
                                                    <input type="hidden" name="documento" value="<?= $documento; ?>">

                                                    <!-- Enlace como botón -->
                                                    <a href="./termino_devo.php" class="btn btn-warning btn-sm mt-2" style="width: 10%;">Volver</a>
                                                </form>
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