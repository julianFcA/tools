<?php
require_once './../../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];

header("Location: ./venta_p.php?status=2");
?>