<?php
// Incluye la librería PhpSpreadsheet
require '../vendor/autoload.php';

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

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta los datos
$sql = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, usuario.nombre AS nombre_administrador, usuario.apellido AS apellido_administrador, usuario.documento, usuario.correo AS correo_administrador, usuario.fecha_registro, usuario.codigo_barras, licencia.licencia, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen 
        FROM empresa 
        INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre 
        LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  
        INNER JOIN rol ON usuario.id_rol = rol.id_rol 
        WHERE empresa.nit_empre > 0 AND usuario.id_rol = 1 AND licencia.licencia != '65e5b3e7a66b7'";
        
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Añadir un título
    $sheet->setCellValue('A1', 'Licencias');
    $sheet->mergeCells('A1:O1'); // Ajustar el rango según el número de columnas
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Encabezados personalizados de columna
    $headers = [
        'Nit Empresa', 'Nombre de Empresa', 'Direccion de Empresa', 'Telefono de Empresa', 'Correo de Empresa', 'Nombre de Administrador', 'Apellido de Administrador', 'Numero de Identificación', 'Correo de Administrador', 'Fecha de Registro de Administrador', 'Codigo de Barras de Administrador', 'Numero de Licencia', 'Fecha de Inicio de Licencia', 'Fecha de Fin de Licencia', 'Estado Actual'
    ];

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
        $sheet->setCellValue('A' . $rowNum, $row['nit_empre']);
        $sheet->setCellValue('B' . $rowNum, $row['nom_empre']);
        $sheet->setCellValue('C' . $rowNum, $row['direcc_empre']);
        $sheet->setCellValue('D' . $rowNum, $row['telefono']);
        $sheet->setCellValue('E' . $rowNum, $row['correo_empre']);
        $sheet->setCellValue('F' . $rowNum, $row['nombre_administrador']);
        $sheet->setCellValue('G' . $rowNum, $row['apellido_administrador']);
        $sheet->setCellValue('H' . $rowNum, $row['documento']);
        $sheet->setCellValue('I' . $rowNum, $row['correo_administrador']);
        $sheet->setCellValue('J' . $rowNum, $row['fecha_registro']);
        $sheet->setCellValue('K' . $rowNum, $row['codigo_barras']);
        $sheet->setCellValue('L' . $rowNum, $row['licencia']);
        $sheet->setCellValue('M' . $rowNum, $row['fecha_ini']);
        $sheet->setCellValue('N' . $rowNum, $row['fecha_fin']);
        $sheet->setCellValue('O' . $rowNum, $row['esta_licen']);
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
