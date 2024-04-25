<?php
require_once './../../database/conn.php';
require_once './../../vendor/autoload.php'; // Incluye el archivo de autoload de PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

// Verifica si se ha enviado un archivo
if (isset($_POST["submit"])) {
    // Ruta donde se guardarán los archivos subidos
    $target_dir = "uploads/";
    // Nombre del archivo subido
    $target_file = $target_dir . basename($_FILES["archivo_excel"]["name"]);
    // Obtiene la extensión del archivo
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo es un archivo Excel válido
    if ($file_extension == "xls" || $file_extension == "xlsx") {
        // Mueve el archivo desde la ubicación temporal al directorio de destino
        if (move_uploaded_file($_FILES["archivo_excel"]["tmp_name"], $target_file)) {
            // Carga el archivo Excel
            $spreadsheet = IOFactory::load($target_file);
            $worksheet = $spreadsheet->getActiveSheet();

            // Itera sobre las filas del archivo Excel
            foreach ($worksheet->getRowIterator() as $row) {
                // Obtén los valores de cada celda en la fila
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Permite iterar sobre todas las celdas, incluso si están vacías
                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); // Obtiene el valor de la celda
                }

                // Inserta los datos en la base de datos
                $sql = "INSERT INTO formacion (id_forma, nom_forma) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                // Suponiendo que los datos se encuentran en las columnas A y B, reemplaza los índices de $data con los índices de tus columnas
                if ($stmt->execute([$data[0], $data[1]])) {
                } else {
                    echo '<script>alert("Hubo un error al subir el archivo.");';
                    echo 'window.location = "./formacion.php";</script>';
                }
            }

            // Cierra la conexión a la base de datos
            $conn = null;

            echo '<script>alert("El archivo se ha subido y procesado correctamente.");';
            echo 'window.location = "./formacion.php";</script>';
        } else {
            echo '<script>alert("Hubo un error al subir el archivo.");';
            echo 'window.location = "./formacion.php";</script>';
        }
    } else {
        echo '<script>alert("El archivo debe ser un archivo Excel (.xls, .xlsx).");';
        echo 'window.location = "./formacion.php";</script>';
    }
}
