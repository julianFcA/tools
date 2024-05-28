<?php 

//debemos ponerle contraseña al phpadmi, HACER RESPALDO A TODAS LAS BASES DE DATOS
//copiar los archivos mysqldump y mysql de la carpeta bin de mysql

$mysqlDatabaseName ='herramientas';
$mysqlUserName ='root';
$mysqlPassword ='';
$mysqlHostName = 'localhost';
$mysqlExportpath = 'respaldo.sql';

//por favor, no haga ningun cambio en los siguientes puntos
//Exportacion de la base de datos y salida de estatus

$command ='mysqldump --opt -h' .$mysqlHostName.' -u' .$mysqlUserName.' --password="' .$mysqlPassword.'" ' .$mysqlDatabaseName.' > ' .$mysqlExportpath;
exec($command,$output,$worker);
switch($worker){
    case 0:
        echo '<script>alert("La base de datos <b>' . $mysqlDatabaseName . '</b> se ha almacenado correctamente en la siguiente ruta: ' . getcwd() . '/' . $mysqlExportpath . '");</script>';

        echo '<script>alert("El Respaldo de la Base de Datos se Descargo Con Exito ");</script>';
        echo '<script>window.location="./../index.php"</script>';

        break;
        case 1:
            echo '<script>alert("se ha producido un error al exportar <b>' .$mysqlDatabaseName . '</b> a' .getcwd().'/' .$mysqlExportpath .'");</script>';

            echo '<script>alert("Se Ha Producido un Error al Exportar ");</script>';
            echo '<script>window.location="./../index.php"</script>';
            break;
            case 2:
                echo '<script>alert("Se ha producido un error de exportacion, compruebe la siguiente informacion : <br/><br/><table><tr><td>Nombre de la base de datos: </td><td><b> ' . $mysqlDatabaseName . '</b></td></tr><tr><td>Nombre de usuario MySQL: </td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td> contraseña MySQL: </td><td><b> NOTSHOW </b></td></tr><tr><td> Nombre de host MySQL:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>");</script>';

                echo '<script>alert("Se ha producido un error de exportacion, compruebe la siguiente informacion: 1. Nombre de la base de datos : <b> ' . $mysqlDatabaseName . '</b> , 2. Nombre de usuario MySQL: <b>' .$mysqlUserName .'</b> , 3. contraseña MySQL y 4. Nombre de host MySQL: <b>' .$mysqlHostName .'</b>");</script>';
                echo '<script>window.location="./../index.php"</script>';
            break;
            
}

?>