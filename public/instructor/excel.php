<?php
// Incluye la librería PhpSpreadsheet
require '../../vendor/autoload.php';
// ini_set('extension', 'zip');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

// Crea un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();

// Obtén una instancia de la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Conecta a la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "herramientas";
session_start();
$nit= $_SESSION['nit_empre'];

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define las tablas que deseas exportar a Excel
$tablas = array("usuario");

// Itera sobre cada tabla
foreach ($tablas as $tabla) {
    // Consulta los datos de la tabla actual
    $sql ="SELECT usuario.nombre,usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada,  tp_docu.nom_tp_docu, deta_ficha.ficha, estado_usu.* FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha INNER JOIN formacion ON ficha.id_forma = formacion.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu WHERE empresa.nit_empre ='$nit' AND ficha.ficha >=1 AND jornada.id_jornada >=1 AND usuario.id_rol = 3 ";
    $result = $conn->query($sql);

    // Si hay datos en la tabla
    if ($result->num_rows > 0) {
        // Encabezados de columna
        $columnas = array();
        while ($row = $result->fetch_assoc()) {
            // Si aún no has obtenido los encabezados de columna, obténlos ahora
            if (empty($columnas)) {
                $columnas = array_keys($row);
                $sheet->fromArray($columnas, null, 'A1');

                // Aplica formato a los encabezados
                $headerStyle = [
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']],
                    'borders' => ['allBorders' => ['borderStyle' => Style\Border::BORDER_THIN]],
                ];
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($headerStyle);
            }
            // Agrega los datos a la hoja
            $sheet->fromArray($row, null, 'A' . ($sheet->getHighestRow() + 1));
        }
    }
}

// Autoajustar el ancho de las columnas
foreach(range('A', $sheet->getHighestDataColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Crea un objeto Writer para escribir el archivo
$writer = new Xlsx($spreadsheet);

// Define el nombre del archivo de Excel a exportar
$filename = 'reporte_excel.xlsx';

// Establece las cabeceras para indicar que se va a descargar un archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Escribe el archivo en la salida
$writer->save('php://output');

// Cierra la conexión a la base de datos
$conn->close();
?>
