<?php
require_once 'template.php';

// Obtener el documento del usuario logueado
$documento_cliente = $_SESSION['documento'];

// Obtener la fecha actual en formato 'Y-m-d H:i:s'
$fecha_adqui = date('Y-m-d H:i:s');
$hora_finalizacion = date('Y-m-d 23:00', strtotime($fecha_adqui));

// Definir $id_esta_servi con un valor apropiado según tu lógica de negocio
$id_esta_servi = 1; // Puedes cambiar el valor según tu lógica de negocio

// Obtener el ID de venta único
$id_servi = generarIDVenta();

// Consultar información de la atracción si se proporciona 'id_atrac'
$columnas = array();  // Inicializar $columnas para evitar errores
if (isset($_GET['id_atrac'])) {
    $consulta_tipo = $conn->prepare("SELECT * FROM atracciones WHERE id_atrac = :id_atrac");
    $consulta_tipo->bindParam(':id_atrac', $_GET['id_atrac']);
    $consulta_tipo->execute();
    $columnas = $consulta_tipo->fetch(PDO::FETCH_ASSOC);
}

// Obtener el nombre de la atracción si se proporciona 'id_atrac'
$nombre_atraccion = array();
if (isset($columnas['nombre_atra'])) {
    $nombre_atraccion = $columnas['nombre_atra'];
}

// Consultar información del usuario si se proporciona 'documento'
$documento = array();  // Inicializar $documento para evitar errores
if (isset($_GET['documento'])) {
    $consulta = $conn->prepare("SELECT * FROM usuario WHERE documento = :documento");
    $consulta->bindParam(':documento', $_GET['documento']);
    $consulta->execute();
    $documento = $consulta->fetch();
}

// Función para generar un ID único de venta
function generarIDVenta()
{
    $random_number = mt_rand(100000, 999999); // Generar un número aleatorio de 6 dígitos
    return date('Ymd') . $random_number; // Concatenar el número aleatorio con la fecha actual
}

if (isset($_POST['agregar']) && isset($_POST['id_atrac']) && isset($_POST['cant_servicios'])) {
    $id_atrac = $_POST['id_atrac'];
    $cant_servicios = $_POST['cant_servicios'];

    // Obtener información del producto de la base de datos
    $sql_producto = $conn->prepare("SELECT * FROM atracciones WHERE id_atrac = ?");
    $sql_producto->execute([$id_atrac]);
    $producto = $sql_producto->fetch(PDO::FETCH_ASSOC);

    if (isset($producto['cant_servicios']) && is_numeric($producto['cant_servicios']) && $producto['cant_servicios'] >= $cant_servicios)  {
        $_SESSION['error_msg'] = "Cantidad no disponible";
        // Resto del código...
    } else {
        // Agregar el producto al carrito
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Verificar si el producto ya está en el carrito
        if (isset($_SESSION['carrito'][$id_atrac])) {
            // Si el producto ya está en el carrito, actualizamos la cantidad
            $_SESSION['carrito'][$id_atrac]['cant_servicios'] += $cant_servicios;
        } else {
            // Si el producto no está en el carrito, lo agregamos
            $_SESSION['carrito'][$id_atrac] = array(
                'id_atrac' => $id_atrac,
                'nombre' => $producto['nombre_atra'],
                'precio' => $producto['precio'],
                'cant_servicios' => $cant_servicios
            );
        }
    }
}

// Limpiar el carrito
if (isset($_POST['limpiar_carrito'])) {
    unset($_SESSION['carrito']);
    // No redirigir directamente, sino agregar un parámetro en la URL
    header("Location: index.php?limpiar_carrito=true");
    exit();
}

// Obtener el nombre de la atracción si se proporciona 'id_atrac'
$nombre_atraccion = '';
if (isset($_GET['id_atrac'])) {
    $consulta_tipo = $conn->prepare("SELECT nombre_atra FROM atracciones WHERE id_atrac = :id_atrac");
    $consulta_tipo->bindParam(':id_atrac', $_GET['id_atrac']);
    $consulta_tipo->execute();
    $nombre_atraccion = $consulta_tipo->fetchColumn();
}

// Terminar la venta
if (isset($_POST['terminar_venta']) && isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    // Inicializar total de la venta
    $total_venta = 0;

    // Crear la compra_servicio
    $sql_insert_compra = $conn->prepare("INSERT INTO compra_servicio (fecha_adqui, hora_finalizacion, documento,id_esta_servi, total) VALUES (?, ?, ?, ?, ?)");

    // Verificar que $id_esta_servi no sea nulo antes de ejecutar la consulta
    if ($id_esta_servi !== null) {
        $sql_insert_compra->execute([$fecha_adqui, $hora_finalizacion, $documento_cliente, $id_esta_servi, $total_venta]);
    } else {
        // Manejar el caso donde $id_esta_servi es nulo
        echo 'Error: $id_esta_servi es nulo';
        // Puedes agregar más lógica aquí según tus necesidades
    }

    // Obtener el ID de la compra recién creada
    $id_servi = $conn->lastInsertId();

    // Agregar los detalles de los productos en detalle_servicio
    foreach ($_SESSION['carrito'] as $producto_id => $producto) {
        $subtotal = $producto['precio'] * $producto['cant_servicios'];

        $total_venta += $subtotal;

        $sql_insert_detalle = $conn->prepare("INSERT INTO detalle_servicio (id_servi, id_atrac, cant_servicios, subtotal) VALUES (?, ?, ?, ?)");
        $sql_insert_detalle->execute([$id_servi, $producto['id_atrac'], $producto['cant_servicios'], $subtotal]);

        // Actualizar la cantidad de servicios en atracciones si la columna existe
        if (columnExists($conn, 'atracciones', 'cant_servicios')) {
            $sql_update_atraccion = $conn->prepare("UPDATE atracciones SET cant_servicios = cant_servicios - ? WHERE id_atrac = ?");
            $sql_update_atraccion->execute([$producto['cant_servicios'], $producto['id_atrac']]);
        }
    }

    // Actualizar el total en la compra_servicio
    $sql_update_compra = $conn->prepare("UPDATE compra_servicio SET total = ? WHERE id_servi = ?");
    $sql_update_compra->execute([$total_venta, $id_servi]);

    // Vaciar el carrito después de completar la venta
    unset($_SESSION['carrito']);

    // Redirigir a una página de confirmación o listado de ventas
    echo '<script>alert("Compra Exitosa");</script>';
    header("Location: atrac_compradas.php?venta_completada=true");
    exit;
}

// Función para verificar si una columna existe en una tabla
function columnExists($conn, $table, $column)
{
    $result = $conn->query("SHOW COLUMNS FROM $table LIKE '$column'");
    return ($result->fetchColumn() !== false);
}
?>

    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Nueva Compra</li>
                    <!-- <li class="breadcrumb-item"><a href="#">Listado de Ventas</a></li> -->
                </ol>
            </div>
        </div>

        <!-- Formulario de Compra -->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Nueva Compra
                    </div>
                    <div class="card-body">
                        <form method="POST" name="formreg" id="signup-form" class="signup-form"
                            enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                                    <!-- Campos para actualizar -->
                                    <div class="form-group">
                                        <input type="hidden" name="id_atrac" class="form-control" value="<?php echo isset($columnas['id_atrac']) ? $columnas['id_atrac'] : ''; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="nombre_atra" placeholder="Ingrese Nombre de Atraccion" class="form-control" value="<?php echo $nombre_atraccion; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" name="cant_servicios" class="form-control" value="1" placeholder="Ingrese la Cantidad" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="agregar" class="btn btn-info">Agregar al carrito</button>
                                <button type="submit" name="limpiar_carrito" class="btn btn-danger">Limpiar Carrito</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carrito de Compras -->
        <div class="row mt-4">
            <div class="col-12">
                <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) { ?>
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Carrito de Compras
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Atracción</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_SESSION['carrito'] as $producto_id => $producto) { ?>
                                        <tr>
                                            <td><?php echo isset($producto['nombre']) ? $producto['nombre'] : 'Nombre no disponible'; ?></td>
                                            <td><?php echo $producto['cant_servicios']; ?></td>
                                            <td><?php echo $producto['precio']; ?></td>
                                            <td><?php echo $producto['cant_servicios'] * $producto['precio']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                                        <td>
                                            <?php
                                            $total_venta = 0;
                                            foreach ($_SESSION['carrito'] as $producto) {
                                                $total_venta += $producto['cant_servicios'] * $producto['precio'];
                                            }
                                            echo number_format($total_venta, 2);
                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        </div>

        <!-- Botón para Terminar la Venta -->
        <div class="row mt-4">
            <div class="col-12">
                <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) { ?>
                    <form method="POST" class="form-container">
                        <div class="form-group">
                            <label>Documento del Cliente</label>
                            <input type="text" name="usuario" class="form-control" placeholder="Ingrese Documento del Cliente" value="<?php echo $documento_cliente; ?>" required readonly>
                        </div>
                        <button type="submit" name="terminar_venta" class="btn btn-success">Terminar Compra</button>
                    </form>
                <?php } ?>
            </div>
        </div>


    </div>

    
