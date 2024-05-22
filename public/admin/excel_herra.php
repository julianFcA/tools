<?php
// Incluye la librería PhpSpreadsheet
require '../../vendor/autoload.php';

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
$nit = $_SESSION['nit_empre'];

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta los datos de la tabla actual
$sql = "SELECT herramienta.codigo_barra_herra, tp_herra.nom_tp_herra, herramienta.nombre_herra, marca_herra.nom_marca, herramienta.descripcion, herramienta.cantidad, herramienta.esta_herra
        FROM empresa
        INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre
        LEFT JOIN herramienta ON empresa.nit_empre = herramienta.nit_empre
        INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra
        INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca
        WHERE empresa.nit_empre = '$nit'
        AND tp_herra.id_tp_herra >= 1
        AND marca_herra.id_marca >= 1";
$result = $conn->query($sql);

// Si hay datos en la tabla
if ($result->num_rows > 0) {
    // Añadir un título
    $sheet->setCellValue('A1', 'Reporte de Herramientas');
    $sheet->mergeCells('A1:G1'); // Ajustar el rango según el número de columnas
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Encabezados personalizados de columna
    $headers = ['Código de Barras', 'Tipo de Herramienta', 'Nombre de Herramienta', 'Marca', 'Descripción', 'Cantidad', 'Estado de Herramienta'];

    $sheet->fromArray($headers, null, 'A2');

    // Aplica formato a los encabezados
    $headerStyle = [
        'font' => ['bold' => true],
        'fill' => ['fillType' => Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']],
        'borders' => ['allBorders' => ['borderStyle' => Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A2:G2')->applyFromArray($headerStyle);

    // Iterar sobre los resultados y agregar filas
    $rowNum = 3; // Comienza en la fila 3
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $row['codigo_barra_herra']);
        $sheet->setCellValue('B' . $rowNum, $row['nom_tp_herra']);
        $sheet->setCellValue('C' . $rowNum, $row['nombre_herra']);
        $sheet->setCellValue('D' . $rowNum, $row['nom_marca']);
        $sheet->setCellValue('E' . $rowNum, $row['descripcion']);
        $sheet->setCellValue('F' . $rowNum, $row['cantidad']);
        $sheet->setCellValue('G' . $rowNum, $row['esta_herra']);
        $rowNum++;
    }
}

// Autoajustar el ancho de las columnas
foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Crea un objeto Writer para escribir el archivo
$writer = new Xlsx($spreadsheet);

// Define el nombre del archivo de Excel a exportar
$filename = 'reporte_herramientas.xlsx';

// Establece las cabeceras para indicar que se va a descargar un archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Escribe el archivo en la salida
$writer->save('php://output');

// Cierra la conexión a la base de datos
$conn->close();
?>
