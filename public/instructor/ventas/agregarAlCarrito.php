<?php
require_once './../../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

if (isset($_GET["agregar"]))return;
	$codigo = $_GET["id"];
	$canti = $_GET["canti"];
	$docu = $_GET["docu"];
	$sentencia = $conn->prepare("SELECT * FROM herramienta WHERE codigo_barra_herra = ?  LIMIT 1;");
	$sentencia->execute([$codigo]);
	$producto = $sentencia->fetch(PDO::FETCH_OBJ);

if($producto){
	if($producto->can_final = 0){
		header("Location: ./venta_p.php?status=5");
		exit;
	}
	$indice = false;
	for ($i = 0 ; $i < count($_SESSION["carrito"]); $i++) { 
		if($_SESSION["carrito"][$i]->id_producto === $codigo){
			$indice = $i;
			break;
		}
	}
	if($indice === FALSE){
		$producto->cantidad = $canti;
		$producto->total = $producto->precio * $canti ;
		array_push($_SESSION["carrito"], $producto);

	}else{
		$_SESSION["carrito"][$indice]->cantidad = $canti;
		$_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precio;
	}
	header("Location: ./venta_p.php");
}else header("Location: ./venta_p.php?status=4");

?>