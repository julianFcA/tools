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
$nit= $_SESSION['nit_empre'] ;


// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
$sql ="SELECT herramienta.codigo_barra_herra, herramienta.nombre_herra, herramienta.descripcion, herramienta.imagen, herramienta.cantidad, herramienta.esta_herra, tp_herra.nom_tp_herra, marca_herra.nom_marca
FROM empresa 
INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre 
LEFT JOIN herramienta ON empresa.nit_empre = herramienta.nit_empre 
INNER JOIN tp_herra ON herramienta.id_tp_herra = tp_herra.id_tp_herra 
INNER JOIN marca_herra ON herramienta.id_marca = marca_herra.id_marca 
WHERE empresa.nit_empre = '$nit' 
AND herramienta.id_tp_herra >= 1 
AND marca_herra.id_marca >= 1";

// Ejecuta la consulta
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Herramientas</title></head><body>';
    $html .= '<h1>Reporte de Herramientas</h1>';
    // Continúa con el resto del HTML para la tabla y los resultados

    // Crea una variable para almacenar el HTML de la tabla
    $html .= '<table border="1"><tr><th>Código de Barras</th><th>Nombre de Herramienta</th><th>Descripción</th><th>Imagen</th><th>Cantidad</th><th>Estado de Herramienta</th><th>Tipo de Herramienta</th><th>Marca</th></tr>';

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
    $html2pdf->output('reporte_herramientas.pdf', 'D'); // Genera el PDF y lo descarga

} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./herramienta.php"</script>';
}

// Cierra la conexión
$conn->close();
?>
