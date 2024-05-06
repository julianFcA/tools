<?php
require_once('./../../vendor/autoload.php');

session_start(); // Inicia la sesión si no está iniciada

// Verifica si el documento está definido en la sesión
if (!isset($_SESSION['documento'])) {
    die("Error: No se ha proporcionado un documento en la sesión.");
}

$documento = $_SESSION['documento'];

// Incluye la clase que necesitamos del espacio de nombres
use Spipu\Html2Pdf\Html2Pdf;

// Conecta a la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "herramientas";
$documento = $_SESSION['documento'] ;

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $dbname);


// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL
$sql ="SELECT usuario.nombre,
usuario.apellido,
usuario.documento,
usuario.correo,
usuario.codigo_barras,
usuario.fecha_registro,
formacion.nom_forma,
jornada.tp_jornada,
deta_ficha.ficha,
deta_ficha.id_deta_ficha,
tp_docu.nom_tp_docu
FROM usuario
INNER JOIN tp_docu ON usuario.id_tp_docu = tp_docu.id_tp_docu
INNER JOIN rol ON usuario.id_rol = rol.id_rol
INNER JOIN deta_ficha ON deta_ficha.documento = usuario.documento
INNER JOIN ficha ON deta_ficha.ficha = ficha.ficha
INNER JOIN formacion ON formacion.id_forma = ficha.id_forma
INNER JOIN jornada ON ficha.id_jornada = jornada.id_jornada
WHERE ficha.ficha > 0
AND jornada.id_jornada > 1
AND deta_ficha.id_deta_ficha >= 1
AND usuario.id_rol = 3 
AND usuario.documento = $documento";

// Ejecuta la consulta
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Agrega un título al reporte
    $html = '<html><head><title>Reporte de Instructores</title></head><body>';
    $html .= '<h1>Reporte de Instructores</h1>';
    // Continúa con el resto del HTML para la tabla y los resultados

    // Crea una variable para almacenar el HTML de la tabla
    $html .= '<table border="1"><tr><th>Nombre Usuario</th><th>Apellido Usuario</th><th>Documento Usuario</th><th>Correo Usuario</th><th>Código de Barras</th><th>Fecha Registro</th><th>Formacion</th><th>Ficha</th><th>Jornada</th></tr>';

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
    $html2pdf->output('reporte_instructores.pdf', 'D'); // Genera el PDF y lo descarga

} else {
    echo '<script>alert("No se encontraron resultados.");</script>';
    echo '<script>window.location="./index.php"</script>';
}

// Cierra la conexión
$conn->close();
?>
