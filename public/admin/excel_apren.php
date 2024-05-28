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
$password = "";
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
$sql = "SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, entrada_usu.fecha_entrada, tp_docu.nom_tp_docu, deta_ficha.ficha 
        FROM empresa 
        INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre 
        LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  
        INNER JOIN rol ON usuario.id_rol = rol.id_rol 
        INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento 
        INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha 
        INNER JOIN formacion ON ficha.id_forma = formacion.id_forma 
        INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada 
        INNER JOIN entrada_usu ON usuario.documento = entrada_usu.documento 
        INNER JOIN (
            SELECT documento, MAX(fecha_entrada) AS ultima_entrada 
            FROM entrada_usu 
            GROUP BY documento
        ) ultima_entrada ON entrada_usu.documento = ultima_entrada.documento AND entrada_usu.fecha_entrada = ultima_entrada.ultima_entrada 
        INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
        WHERE empresa.nit_empre='$nit' AND ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3";

$result = $conn->query($sql);

// Si hay datos en la tabla
if ($result->num_rows > 0) {
    // Añadir un título
    $sheet->setCellValue('A1', 'Ingreso de Aprendices');
    $sheet->mergeCells('A1:K1'); // Ajustar el rango según el número de columnas
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Encabezados personalizados de columna
    $headers = ['Nombre', 'Apellido', 'Tipo de documento', 'Número de Identificación', 'Formación', 'Ficha', 'Jornada', 'Ultimo Ingreso'];

    $sheet->fromArray($headers, null, 'A2');

    // Aplica formato a los encabezados
    $headerStyle = [
        'font' => ['bold' => true],
        'fill' => ['fillType' => Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0F0F0']],
        'borders' => ['allBorders' => ['borderStyle' => Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A2:K2')->applyFromArray($headerStyle);

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
        $sheet->setCellValue('H' . $rowNum, $row['fecha_entrada']);
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
$filename = 'ingreso_aprendices.xlsx';

// Establece las cabeceras para indicar que se va a descargar un archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Escribe el archivo en la salida
$writer->save('php://output');

// Cierra la conexión a la base de datos
$conn->close();
?>
