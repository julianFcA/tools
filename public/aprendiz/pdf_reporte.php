<?php
require_once('./../../vendor/autoload.php');

session_start(); // Inicia la sesión si no está iniciada

// Verifica si el documento está definido en la sesión
if (!isset($_SESSION['documento'])) {
    die("Error: No se ha proporcionado un documento en la sesión.");
}

$docu = $_SESSION['documento'];


// Incluye la clase que necesitamos del espacio de nombres
use Spipu\Html2Pdf\Html2Pdf;

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

// Consulta SQL
$sql = "SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, tp_docu.nom_tp_docu, deta_ficha.ficha, prestamo_herra.*, detalle_prestamo.*, herramienta.*, reporte.*, deta_reporte.*
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
INNER JOIN reporte ON detalle_prestamo.id_deta_presta = reporte.id_deta_presta
INNER JOIN deta_reporte ON deta_reporte.id_reporte = reporte.id_reporte
WHERE usuario.documento = '$docu' AND ficha.ficha >= 1 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3 AND detalle_prestamo.estado_presta = 'reportado' OR detalle_prestamo.estado_presta = 'bloqueado' OR detalle_prestamo.estado_presta = 'reportado una parte'";

// Ejecuta la consulta
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Aprendiz</title>';
    $html .= '<style>
                table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
                th, td { padding: 4px; text-align: left; border: 1px solid #ddd; font-size: 8px; word-wrap: break-word; }
                th { background-color: #f2f2f2; }
                tr { page-break-inside: avoid; page-break-after: auto; }
                h1 { text-align: center; font-size: 12px; }
            </style>';
    $html .= '</head><body>';
    $html .= '<h1>Reporte de Aprendiz</h1>';

    // Crea una variable para almacenar el HTML de la tabla
    $html .= '<table><thead><tr><th>Nombre Aprendiz</th><th>Apellido Aprendiz</th><th>Tipo de Documento</th><th>Documento</th><th>Formacion</th><th>Ficha</th><th>Jornada</th><th>Herramienta</th><th>N° de Prestamo</th><th>Fecha de Adquisición</th><th>Dias de Prestamo</th><th>Fecha de Entrega</th><th>Estado de Prestamo</th><th>Descripcion</th></tr></thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['nombre']) . '</td>
                    <td>' . htmlspecialchars($row['apellido']) . '</td>
                    <td>' . htmlspecialchars($row['nom_tp_docu']) . '</td>
                    <td>' . htmlspecialchars($row['documento']) . '</td>
                    <td>' . htmlspecialchars($row['nom_forma']) . '</td>
                    <td>' . htmlspecialchars($row['ficha']) . '</td>
                    <td>' . htmlspecialchars($row['tp_jornada']) . '</td>
                    <td>' . htmlspecialchars($row['nombre_herra']) . '</td>
                    <td>' . htmlspecialchars($row['id_presta']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_adqui']) . '</td>
                    <td>' . htmlspecialchars($row['dias']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_entrega']) . '</td>
                    <td>' . htmlspecialchars($row['estado_presta']) . '</td>
                    <td>' . htmlspecialchars($row['descripcion']) . '</td>
                  </tr>';
    }
    $html .= '</tbody></table></body></html>';

    $html2pdf = new Html2Pdf('L', 'LETTER', 'es', true, 'UTF-8', array(5, 5, 5, 5));
    $html2pdf->writeHTML($html);
    $html2pdf->output('reporte_aprendiz.pdf', 'D');
} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./index.php"</script>';
}

$conn->close();
?>
