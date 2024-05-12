<?php
require_once './../../database/conn.php';
require_once './../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

$database = new Database();
$conn = $database->conectar();
session_start();
date_default_timezone_set('America/Bogota');

$nit = $_SESSION['nit_empre'];

if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["archivo_excel"]["name"]);
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($file_extension == "xls" || $file_extension == "xlsx") {
        if (move_uploaded_file($_FILES["archivo_excel"]["tmp_name"], $target_file)) {
            $spreadsheet = IOFactory::load($target_file);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); 
                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue(); 
                }

                // Verificar si ya existe un registro con los mismos valores en id_forma o nom_forma
                $sql_check = "SELECT COUNT(*) AS count FROM formacion WHERE id_forma = ? OR nom_forma = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->execute([$data[0], $data[1]]);
                $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

                if ($result_check['count'] > 0) {
                    // Si ya existe, muestra un mensaje de error y no inserta el registro
                    echo '<script>alert("El registro ya existe en la base de datos. Se el nombre de la formacion o si ingreso numeros en la primera columna tal vez tambien sea eso.");';
                    echo 'window.location = "./formacion.php";</script>';
                } else {
                    // Si no existe, procede con la inserción
                    $sql_insert = "INSERT INTO formacion (id_forma, nom_forma, nit_empre) VALUES (?, ?, '$nit')";
                    $stmt_insert = $conn->prepare($sql_insert);
                    
                    if ($stmt_insert->execute([$data[0], $data[1]])) {
                        // Inserción exitosa
                    } else {
                        // Error al insertar
                        echo '<script>alert("Hubo un error al subir el archivo.");';
                        echo 'window.location = "./formacion.php";</script>';
                    }
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
?>
