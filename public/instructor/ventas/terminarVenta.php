<?php
require_once './../../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

if(!isset($_GET["total"])) exit;

date_default_timezone_set('America/Bogota');


$total = $_GET["total"];
$ahora = date("Y-m-d H:i:s");
$hora = date(" H:i:s");
$doc = $_GET["docu"];
$doc_c = $_SESSION['docu'];
echo $total.$doc;


$sentencia = $conn->prepare("INSERT INTO venta(doc_coach,doc_cliente,fecha,hora,total) VALUES (?,?,?,?,?);");
$sentencia->execute([$doc_c,$doc,$ahora,$hora,$total]);

$sentencia = $conn->prepare("SELECT id_venta FROM venta ORDER BY id_venta DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id_venta;

$conn->beginTransaction();
$sentencia = $conn->prepare("INSERT INTO det_venta(id_productos, id_venta, cantidad) VALUES (?, ?, ?);");
$sentenciaExistencia = $conn->prepare("UPDATE productos SET can_final = can_final - ? WHERE id_producto = ?;");
foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	$sentencia->execute([$producto->id_producto, $idVenta, $producto->can_inicial]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id_producto]);
}
$conn->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: ./venta_p.php?status=1");
?>