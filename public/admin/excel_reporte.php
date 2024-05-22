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
$sql = "SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, tp_docu.nom_tp_docu, deta_ficha.ficha, prestamo_herra.*, detalle_prestamo.*, herramienta.*, reporte.*, deta_reporte.*
        FROM  empresa
        INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre
        LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre
        INNER JOIN rol ON usuario.id_rol = rol.id_rol
        INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento
        INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha
        INNER JOIN formacion ON ficha.id_forma = formacion.id_forma
        INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada
        INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu
        INNER JOIN prestamo_herra ON usuario.documento = prestamo_herra.documento
        INNER JOIN detalle_prestamo ON prestamo_herra.id_presta = detalle_prestamo.id_presta
        INNER JOIN herramienta ON herramienta.codigo_barra_herra = detalle_prestamo.codigo_barra_herra
        INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
        INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
        WHERE empresa.nit_empre= '$nit'
        AND ficha.ficha >= 1
        AND jornada.id_jornada >= 1
        AND usuario.id_rol = 3
        AND (detalle_prestamo.estado_presta = 'reportado' OR detalle_prestamo.estado_presta = 'bloqueado' OR detalle_prestamo.estado_presta = 'reportado una parte' OR detalle_prestamo.estado_presta = 'tarde')";
$result = $conn->query($sql);

// Si hay datos en la tabla
if ($result->num_rows > 0) {
    // Añadir un título
    $sheet->setCellValue('A1', 'Reporte de Aprendices');
    $sheet->mergeCells('A1:O1'); // Ajustar el rango según el número de columnas
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Encabezados personalizados de columna
    $headers = ['Nombre', 'Apellido', 'Tipo de documento', 'Documento', 'Formación', 'Ficha', 'Jornada', 'Nombre de Herramienta', 'N° de Préstamo', 'Fecha de Adquisición', 'Días', 'Fecha de Entrega', 'Estado de Préstamo', 'Cantidad', 'Descripción'];

    $sheet->fromArray($headers, null, 'A2');

    // Aplica formato a los encabezados
    $headerStyle = [
        'font' => ['bold' => true],
        'fill' => ['fillType' => Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']],
        'borders' => ['allBorders' => ['borderStyle' => Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A2:O2')->applyFromArray($headerStyle);

    // Iterar sobre los resultados y agregar filas
    $rowNum = 3; // Comienza en la fila 3
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
        $sheet->setCellValue('M' . $rowNum, $row['estado_presta']);
        $sheet->setCellValue('N' . $rowNum, $row['cant_herra']);
        $sheet->setCellValue('O' . $rowNum, $row['descripcion']);
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
$filename = 'reporte_aprendices.xlsx';

// Establece las cabeceras para indicar que se va a descargar un archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Escribe el archivo en la salida
$writer->save('php://output');

// Cierra la conexión a la base
?>
