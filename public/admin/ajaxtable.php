<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

// SQL server connection information
$sql_details = array(
    'user' => 'root', // tu usuario de base de datos
    'pass' => '', // tu contraseña
    'db'   => 'julian', // tu base de datos
    'host' => 'localhost' // tu host
);


// DB table to use
$table = 'usuario';

// Table's primary key
$primaryKey = 'documento';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier.
$columns = array(
    array( 'db' => 'nombre', 'dt' => 0 ),
    array( 'db' => 'apellido', 'dt' => 1 ),
    array( 'db' => 'documento', 'dt' => 2 ),
    array( 'db' => 'correo', 'dt' => 3 ),
    array( 'db' => 'codigo_barras', 'dt' => 4 ),
    array(
        'db' => 'fecha_registro',
        'dt' => 5,
        'formatter' => function( $d, $row ) {
            return date('jS M y', strtotime($d));
        }
    ),
    array( 'db' => 'nom_forma', 'dt' => 6 ),
    array( 'db' => 'ficha', 'dt' => 7 ),
    array( 'db' => 'tp_jornada', 'dt' => 8 ),
    array(
        'db' => 'documento',
        'dt' => 9,
        'formatter' => function( $d, $row ) {
            return "<button class='btn btn-success'>Ver</button>";
        }
    )
);
require( 'ssp.class.php' );
// Output data
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>
