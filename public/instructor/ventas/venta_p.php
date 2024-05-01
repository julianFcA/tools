<?php
require_once './../../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');


if (isset($_GET['documento'])) {
    $control = $conn->prepare("SELECT * FROM herramienta WHERE codigo_barra_herra >= 1");
    $control->execute();
    $query = $control->fetch();

    $control2 = $conn->prepare("SELECT * FROM usuario WHERE documento = :documento AND id_rol = 3");
    $control2->bindParam(':documento', $_GET['documento']); // Enlazar el parámetro :documento
    $control2->execute();
    $query2 = $control2->fetch();

    date_default_timezone_set('America/Bogota');
    $fechaActual = date('Y-m-d');
    $hora = date("H:i:s");
}

?>


<body class="bg-gradient-primary">
<a class="btn btn success" href="../index.php" style="margin-left: 3.6%; margin-top:0%; position:absolute;">  
    <i class="bi bi-chevron-left" style="padding:10px 14px 10px 10px; color:#fff; font-size:15px; background-color:#0d6efd; border-radius:10px;"> REGRESAR</i>
    </a>
    <form method="get" >
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-8">
                        <div class="p-3">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Venta de Productos</h1>
                            </div>  
                                <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label>Fecha: </label>
                                            
                                            <h2 name="fecha" value=""><?php echo $fechaActual; ?></h2>
                                            
                                            
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Hora: </label>
                                            <h2   name="hora" value=""><?php echo $hora; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="p-3">
                <div class="text-center">
                    <div class="form-group row">
                        <div class="col-sm-4 mb-0 mb-sm-0">
                            <label for="codigo">Cantidad Agregar</label>
                            <input autocomplete="off" min="1" pattern="(?=.*\e){1,3}" title="No se admiten letras"  maxlength="3" oninput="maxlengthNumber(this);" autofocus class="form-control" name="canti" type="number" id="codigo" placeholder="Digete la cantidad" required>
                        </div>
                        <script>
                                            function maxlengthNumber(obj) {
                                                console.log(obj.value);
                                                if (obj.value.length > obj.maxLength) {
                                                    obj.value = obj.value.slice(0, obj.maxLength);
                                                }
                                            }
                        </script>

                                <script>
                                            $(function() {
                                            $('input[type=number]').keypress(function(key) {
                                                if(key.charCode < 48 || key.charCode > 57) return false;
                                            });
                                        });

                                </script>


                        <div class="col-sm-4 mb-0 mb-sm-0">
                            <label for="codigo">Código de barras o Nombre del producto:</label>
                            <input autocomplete="off" autofocus class="form-control" pattern="[A-Za-z]"  title="Solo se pueden ingresar letras" maxlength="15" name="codigo" type="text" id="codigo" placeholder="Ingrese sobre el producto" required>
                        </div>
                        <div class="col-sm-4 mb-0 mb-sm-0">
                        <button type="submit"  name="consul" class="btn btn-primary  btn-block">Consultar</button>
                        <input type="hidden" name="validar_V">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['validar_V'])){
                    $codigo = $_GET["codigo"];
                    $canti = $_GET['canti'];
                    



                    $statement = $conex->prepare("SELECT * FROM productos WHERE id_producto = '$codigo' or nom_producto LIKE '%$codigo%'");
                    $statement->execute();
                    $resultados = $statement->fetchAll();

                    if ($canti == ""){
                        ?>
                        <div class="alert alert-warning">
                                <strong>Error:</strong> Ingrese la cantidad a comprar del producto
                            </div>
                        <?php
                    }
                    if ($codigo == ""){
                        ?>
                        <div class="alert alert-warning">
                                <strong>Error:</strong> Ingrese el codigo o nombre del producto
                            </div>
                        <?php
                    }
                    elseif($resultados){
    
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Existencia</th>
                        <th>Cantidad Agregar</th>
                        <th>Precio</th>
                        <th>Agregar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($resultados as $pro){ 
                            
                        ?>
                    <tr>
                        <td><?= $pro['id_producto'] ?></td>
                        <td><?= $pro['cod_producto'] ?></td>
                        <td><?= $pro['nom_producto'] ?></td>
                        <td><?= $pro['can_final']?></td>
                        <td><?= $_GET['canti']?></td>
                        <td><?= $pro['precio']?></td>
                        <td><a class="btn btn-success" name="agregar" href='agregarAlCarrito.php?id=<?php echo $pro['id_producto']?>&canti=<?php echo $canti?>'><i class="bi bi-cart-check-fill"></i></a></td>
                    </tr>
                    <?php 
                    }
            } 
            else{ 
                ?>
                <div class="alert alert-warning">
                        <strong>Error:</strong> El producto que buscas no existe
                    </div>
                <?php
            }
        }
                    ?>
                </tbody>
            </table>
        <?php
        if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [] ;
        $granTotal = 0;
        ?>
        <div class="col-xs-12">
            <h1>Vender</h1>
            <?php
                if(isset($_GET["status"])){
                    if($_GET["status"] === "1"){
                        ?>
                            <div class="alert alert-success">
                                <strong>¡Correcto!</strong> Venta realizada correctamente
                            </div>
                        <?php
                    }else if($_GET["status"] === "2"){
                        ?>
                        <div class="alert alert-info">
                                <strong>Venta cancelada</strong>
                            </div>
                        <?php
                    }else if($_GET["status"] === "3"){
                        ?>
                        <div class="alert alert-info">
                                <strong>Ok</strong> Producto quitado de la lista
                            </div>
                        <?php
                    }else if($_GET["status"] === "4"){
                        ?>
                        <div class="alert alert-warning">
                                <strong>Error:</strong> El producto que buscas no existe
                            </div>
                        <?php
                    }else if($_GET["status"] === "5"){
                        ?>
                        <div class="alert alert-danger">
                                <strong>Error: </strong>El producto está agotado
                            </div>
                        <?php
                    }else{
                        ?>
                        <div class="alert alert-danger">
                                <strong>Error:</strong> Algo salió mal mientras se realizaba la venta
                            </div>
                        <?php
                    }
                }
            ?>
            <br>
            <br><br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($_SESSION["carrito"] as $indice => $producto){ 
                            $granTotal += $producto->total;
                        ?>
                    <tr>
                        <td><?php echo $producto->id_producto ?></td>
                        <td><?php echo $producto->cod_producto ?></td>
                        <td><?php echo $producto->nom_producto ?></td>
                        <td><?php echo $producto->cantidad ?></td>
                        <td><?php echo $producto->precio ?></td>
                        <td><?php echo $producto->total ?></td>
                        <td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice?>"><i class="bi bi-cart-x"></i></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h3>Total: <?php echo $granTotal ; ?></h3>
            <div class="p-3">
                <div class="text-center">
                    <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Documento del cliente</label>
                    <input type="number" min="900000000" pattern="(?=.*\e)[0-9]{6,10}" title="Solo se aceptan numeros" maxlength="10" oninput="maxlengthNumber(this);" class="form-control " id="exampleFirstName" name="doc_cli" required >
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <input type="hidden" name="docu" >
                    <button type="submit"  name="consul" class="btn btn-primary btn-user btn-block">Consultar</button>
                </div> 
            </div>
        </div>
    </div>
        <?php
        if (isset($_GET['consul'])){

                                        
                                    
if ($_GET['doc_cli'] == "") {
    ?>
    <div class="alert alert-danger">
        <strong>Error:</strong> INGRESE EL NUMERO DE DOCUMENTO DEL CLIENTE
    </div>
    <?php

}else{

    $cli = $_GET['doc_cli'];

    $consu = $conex->prepare("SELECT * FROM usuarios WHERE documento = '$cli' AND tipo_usuario = 3");
    $consu ->execute();
    $ho = $consu->fetch();

    if($ho){ 

?>
    <div class="p-3">
        <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>NOMBRE DEL CLIENTE</label>
                    <h2><?php echo $ho['nom_completo']?></h2>
                </div>    
            </div>
        </div>
    </div>
                <a class="btn btn-success" name="total" href='terminarVenta.php?total=<?php echo $granTotal?>&docu=<?php echo $ho['documento']?>'>Terminar venta</a>
                <a href="./cancelarVenta.php" class="btn btn-danger">Cancelar venta</a>

                <?php
}
else {
    ?>
    <div class="alert alert-danger">
        <strong>Error:</strong> NO HAY NINGUN CLIENTE CON ESE NUMERO DE DOCUMENTO
    </div>
    <?php
    }
    }
}

?>
            </form>
        </div>
        </form>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>