<?php
require_once('./../vendor/autoload.php');

// Incluye la clase que necesitamos del espacio de nombres
use Spipu\Html2Pdf\Html2Pdf;

// Conecta a la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "herramientas";

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
$query = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.licencia, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre INNER JOIN rol ON usuario.id_rol = rol.id_rol WHERE empresa.nit_empre > 0 AND usuario.id_rol = 1 AND licencia.licencia != '65e5b3e7a66b7'";

// Ejecuta la consulta
$result = $conn->query($query);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Empresas y Licencias</title>';
    $html .= '<style>
                table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
                th, td { padding: 4px; text-align: left; border: 1px solid #ddd; font-size: 8px; word-wrap: break-word; }
                th { background-color: #f2f2f2; }
                tr { page-break-inside: avoid; page-break-after: auto; }
                h1 { text-align: center; font-size: 12px; }
            </style>';
    $html .= '</head><body>';
    $html .= '<h1>Reporte de Empresas y Licencias</h1>';

    // Crea una variable para almacenar el HTML de la tabla
    $html .= '<table><thead><tr><th>NIT</th><th>Nombre Empresa</th><th>Dirección</th><th>Teléfono</th><th>Correo</th><th>Licencia</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado Licencia</th><th>Nombre Usuario</th><th>Apellido Usuario</th><th>Documento Usuario</th><th>Correo Usuario</th></tr></thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['nit_empre']) . '</td>
                    <td>' . htmlspecialchars($row['nom_empre']) . '</td>
                    <td>' . htmlspecialchars($row['direcc_empre']) . '</td>
                    <td>' . htmlspecialchars($row['telefono']) . '</td>
                    <td>' . htmlspecialchars($row['correo_empre']) . '</td>
                    <td>' . htmlspecialchars($row['licencia']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_ini']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_fin']) . '</td>
                    <td>' . htmlspecialchars($row['esta_licen']) . '</td>
                    <td>' . htmlspecialchars($row['nombre']) . '</td>
                    <td>' . htmlspecialchars($row['apellido']) . '</td>
                    <td>' . htmlspecialchars($row['documento']) . '</td>
                    <td>' . htmlspecialchars($row['correo']) . '</td>
                   
                  </tr>';
    }
    $html .= '</tbody></table></body></html>';

    $html2pdf = new Html2Pdf('L', 'LETTER', 'es', true, 'UTF-8', array(5, 5, 5, 5));
    $html2pdf->writeHTML($html);
    $html2pdf->output('reporte_empresas_con_licencia.pdf', 'D');
} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./index.php"</script>';
}

$conn->close();
?>
