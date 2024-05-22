<?php
require '../../vendor/autoload.php';
session_start();

if (!isset($_SESSION['documento'])) {
    die("Error: No se ha proporcionado un documento en la sesión.");
}

$nit = $_SESSION['nit_empre'];
$documentoSession = $_SESSION['documento'];

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

$sql = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre,usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada,  tp_docu.nom_tp_docu, deta_ficha.ficha, estado_usu.* FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha INNER JOIN formacion ON ficha.id_forma = formacion.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu WHERE empresa.nit_empre ='$nit' AND ficha.ficha >=1 AND jornada.id_jornada >=1 AND usuario.id_rol = 3 AND usuario.documento='$documentoSession'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sheet->setCellValue('A1', 'Mis Datos');
    $sheet->mergeCells('A1:O1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $headers = ['Nombre', 'Apellido', 'Tipo de documento', 'Documento', 'Correo', 'Codigo de Barras', 'Fecha de Registro', 'Formación', 'Ficha', 'Jornada'];

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
        $sheet->setCellValue('E' . $rowNum, $row['correo']);
        $sheet->setCellValue('F' . $rowNum, $row['codigo_barras']);
        $sheet->setCellValue('G' . $rowNum, $row['fecha_registro']);
        $sheet->setCellValue('H' . $rowNum, $row['nom_forma']);
        $sheet->setCellValue('I' . $rowNum, $row['ficha']);
        $sheet->setCellValue('J' . $rowNum, $row['tp_jornada']);
        $rowNum++;
    }
}

foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);

$filename = 'reporte.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>