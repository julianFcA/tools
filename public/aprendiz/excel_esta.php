<?php
require '../../vendor/autoload.php';
session_start();

if (!isset($_SESSION['documento'])) {
    die("Error: No se ha proporcionado un documento en la sesión.");
}

$docu = $_SESSION['documento'];

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "herramientas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define las tablas que deseas exportar a Excel

// Consulta los datos de la tabla actual
$sql ="SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, tp_docu.nom_tp_docu, deta_ficha.ficha, prestamo_herra.*, detalle_prestamo.*, herramienta.*
FROM usuario 
INNER JOIN rol ON usuario.id_rol = rol.id_rol 
INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento 
INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha 
INNER JOIN formacion ON ficha.id_forma = formacion.id_forma 
INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada  
INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento 
INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta
INNER JOIN herramienta ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra  
WHERE usuario.documento= '$docu' AND ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sheet->setCellValue('A1', 'Estado de Prestamos');
    $sheet->mergeCells('A1:O1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $headers = ['Nombre', 'Apellido', 'Tipo de documento', 'Documento', 'Formación', 'Ficha', 'Jornada', 'Herramienta','N° De Prestamo', 'Fecha de Adquisición' , 'Días', 'Fecha de Entrega', 'Cantidad Adquirida', 'Estado de Prestamo', 'Cantidad Devuelta'];

    $sheet->fromArray($headers, null, 'A2');

    $headerStyle = [
        'font' => ['bold' => true],
        'fill' => ['fillType' => Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']],
        'borders' => ['allBorders' => ['borderStyle' => Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A2:O2')->applyFromArray($headerStyle);

    $rowNum = 3;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $row['nombre']);
        $sheet->setCellValue('B' . $rowNum, $row['apellido']);
        $sheet->setCellValue('C' . $rowNum, $row['nom_tp_docu']);
        $sheet->setCellValue('D' . $rowNum, $row['documento']);
        $sheet->setCellValue('E' . $rowNum, $row['nom_forma']);
        $sheet->setCellValue('F' . $rowNum, $row['ficha']);
        $sheet->setCellValue('G' . $rowNum, $row['tp_jornada']);
        $sheet->setCellValue('H' . $rowNum, $row['nombre_herra']);
        $sheet->setCellValue('I' . $rowNum, $row['id_presta']);
        $sheet->setCellValue('J' . $rowNum, $row['fecha_adqui']);
        $sheet->setCellValue('K' . $rowNum, $row['dias']);
        $sheet->setCellValue('L' . $rowNum, $row['fecha_entrega']);
        $sheet->setCellValue('M' . $rowNum, $row['cant_herra']);
        $sheet->setCellValue('N' . $rowNum, $row['estado_presta']);
        $sheet->setCellValue('O' . $rowNum, $row['cant_devolucion']);
        $rowNum++;
    }
}

foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);

$filename = 'estado_prestamos.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>
