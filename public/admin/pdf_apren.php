<?php
require_once('./../../vendor/autoload.php');

// Incluye la clase que necesitamos del espacio de nombres
use Spipu\Html2Pdf\Html2Pdf;


// Conecta a la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "herramientas";
session_start();
$nit= $_SESSION['nit_empre'] ;


// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
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
        INNER JOIN (SELECT documento, MAX(fecha_entrada) AS ultima_entrada FROM entrada_usu GROUP BY documento) ultima_entrada 
            ON entrada_usu.documento = ultima_entrada.documento AND entrada_usu.fecha_entrada = ultima_entrada.ultima_entrada 
        INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu 
        WHERE empresa.nit_empre= '$nit' AND ficha.ficha > 0 AND jornada.id_jornada >= 1 AND usuario.id_rol = 3";

// Ejecuta la consulta
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $html = '<html><head><title>Ingreso Aprendices</title>';
    $html .= '<style>
                table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
                th, td { padding: 5px; text-align: left; border: 1px solid #ddd; font-size: 9px; word-wrap: break-word; }
                th { background-color: #f2f2f2; }
                tr { page-break-inside: avoid; page-break-after: auto; }
                h1 { text-align: center; font-size: 14px; }
            </style>';
    $html .= '</head><body>';
    $html .= '<h1>Ingreso Aprendices</h1>';
    $html .= '<table><thead><tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo de Documento</th>
                <th>Documento</th>
                <th>Formación</th>
                <th>Ficha</th>
                <th>Jornada</th>
                <th>Ultimo Ingreso</th>
             </tr></thead><tbody>';


    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['nombre']) . '</td>
                    <td>' . htmlspecialchars($row['apellido']) . '</td>
                    <td>' . htmlspecialchars($row['nom_tp_docu']) . '</td>
                    <td>' . htmlspecialchars($row['documento']) . '</td>
                    <td>' . htmlspecialchars($row['nom_forma']) . '</td>
                    <td>' . htmlspecialchars($row['ficha']) . '</td>
                    <td>' . htmlspecialchars($row['tp_jornada']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_entrada']) . '</td>
                  </tr>';
    }
    $html .= '</tbody></table></body></html>';

    $html2pdf = new Html2Pdf('P', 'Letter', 'es', true, 'UTF-8', array(5, 5, 5));
    $html2pdf->writeHTML($html);
    $html2pdf->output('ingreso_aprendices.pdf', 'D');
} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./index.php"</script>';
}

$conn->close();
?>
