<?php
require_once './../../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

if(!isset($_GET["indice"])) return;
$indice = $_GET["indice"];

array_splice($_SESSION["carrito"], $indice, 1);
header("Location: ./venta_p.php?status=3");
?>