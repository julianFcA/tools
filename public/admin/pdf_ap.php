<?php
require_once('./../../vendor/autoload.php');

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
$sql = "SELECT empresa.nit_empre, empresa.nom_empre, empresa.direcc_empre, empresa.telefono, empresa.correo_empre, licencia.fecha_ini, licencia.fecha_fin, licencia.esta_licen, usuario.nombre,usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma ,jornada.tp_jornada,  tp_docu.nom_tp_docu, deta_ficha.ficha, estado_usu.* FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre LEFT JOIN usuario ON empresa.nit_empre = usuario.nit_empre  INNER JOIN rol ON usuario.id_rol = rol.id_rol INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento INNER JOIN estado_usu ON estado_usu.id_esta_usu = usuario.id_esta_usu INNER JOIN ficha ON ficha.ficha = deta_ficha.ficha INNER JOIN formacion ON ficha.id_forma = formacion.id_forma INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu WHERE empresa.nit_empre > 0 AND ficha.ficha >=1 AND jornada.id_jornada >=1 AND usuario.id_rol = 3 ";

// Ejecuta la consulta
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Ingreso de Aprendices</title></head><body>';
    $html .= '<h1>Reporte de Ingreso de Aprendices</h1>';
    // Crea una tabla para mostrar los resultados
    $html .= '<table border="1"><tr><th>Nombre Usuario</th><th>Apellido Usuario</th><th>Tipo de Documento</th><th>Documento Usuario</th><th>Formacion</th><th>Ficha</th><th>Jornada</th></tr>';

    // Itera sobre los resultados y agrega filas a la tabla
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['nombre'] . '</td>';
        $html .= '<td>' . $row['apellido'] . '</td>';
        $html .= '<td>' . $row['nom_tp_docu'] . '</td>';
        $html .= '<td>' . $row['documento'] . '</td>';
        $html .= '<td>' . $row['nom_forma'] . '</td>';
        $html .= '<td>' . $row['ficha'] . '</td>';
        $html .= '<td>' . $row['tp_jornada'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table></body></html>';

    // Crea un objeto HTML2PDF con tamaño de hoja Carta (Letter)
    $html2pdf = new Html2Pdf('P', 'Letter');

    // Genera el PDF
    $html2pdf->writeHTML($html); // Inserta el HTML en el PDF
    $html2pdf->output('reporte_ingreso_aprendices.pdf', 'D'); // Genera el PDF y lo descarga

} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./ingreso_apren.php"</script>';
}

// Cierra la conexión
$conn->close();
?>