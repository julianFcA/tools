<?php
require_once '../../database/conn.php';
$database = new Database();
$conn = $database->conectar();
session_start();
$lista = $conn->prepare("SELECT * FROM licencia, empresa WHERE licencia.nit_empre = empresa.nit_empre AND esta_licen IN ('activo', 'inactivo')");

$lista->execute();
$listas = $lista->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Licencias</title>
</head>
<body>
    <a href="registrar.php">Crear una licencia</a>
    <table>
        <thead>
            <tr>
                <th>Licencia</th>
                <th>Nombre de Empresa</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listas as $lista) { ?>
                <tr>
                    <td><?= $lista["licencia"] ?></td>
                    <td><?= $lista["nom_empre"] ?></td>
                    <td><?= $lista["fecha_ini"] ?></td>
                    <td><?= $lista["fecha_fin"] ?></td>
                    <td><?= $lista["esta_licen"] ?></td>
                    <td>
                        <a href="activar_licencia.php?id=<?= $lista["licencia"] ?>" class="">Activar</a>
                        <a href="desactivar_licencia.php?id=<?= $lista["licencia"] ?>" class="">Desactivar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Botón de Cerrar Sesión -->
</body>
</html>
