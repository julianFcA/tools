<?php
require_once('./../../vendor/autoload.php');

// Incluye la clase que necesitamos del espacio de nombres
use Spipu\Html2Pdf\Html2Pdf;

// Conecta a la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "herramientas";
session_start();
$nit= $_SESSION['nit_empre'];

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
$query ="SELECT usuario.nombre, usuario.apellido, usuario.documento, usuario.correo, usuario.codigo_barras, usuario.fecha_registro, formacion.nom_forma, jornada.tp_jornada, entrada_usu.fecha_entrada, tp_docu.nom_tp_docu, deta_ficha.ficha 
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
$result = $conn->query($query);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Ingreso de Aprendices</title></head><body>';
    $html .= '<h1>Reporte de Ingreso de Aprendices</h1>';
    // Continúa con el resto del HTML para la tabla y los resultados

    // Crea una variable para almacenar el HTML de la tabla
    $html .= '<table border="1"><tr><th>NIT</th><th>Nombre Empresa</th><th>Dirección</th><th>Teléfono</th><th>Correo</th><th>Licencia</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado Licencia</th><th>Nombre Usuario</th><th>Apellido Usuario</th><th>Documento Usuario</th><th>Correo Usuario</th><th>Código de Barras</th><th>Fecha Registro</th></tr>';

    // Itera sobre los resultados y agrega filas a la tabla
    while($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        foreach($row as $value) {
            $html .= '<td>' . $value . '</td>';
        }
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
