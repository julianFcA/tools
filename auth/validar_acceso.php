<?php

// getJornada.php
try {
    require_once '../database/conn.php';  // Ajusta según la ubicación real y método de inclusión

    $database = new Database();
    $conn = $database->conectar();
        // Obtener el valor de nit_empre desde el formulario
        $nit_empre = $_POST['nit_empre'] ?? '';
        echo $nit_empre;
    
        // Consulta SQL para verificar el código
        $sql = "SELECT * FROM empresa INNER JOIN licencia ON empresa.nit_empre = licencia.nit_empre WHERE licencia.esta_licen = 'activo' AND empresa.nit_empre = :nit_empre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nit_empre', $nit_empre);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Comprobar si se encontró una coincidencia
        if ($resultado) {
            // La contraseña es correcta y el NIT de la empresa está activo
            echo json_encode(array('acceso_permitido' => true));
        } else {
            // La contraseña es incorrecta o el NIT de la empresa no está activo
            echo json_encode(array('acceso_permitido' => false));
        }
    } catch (PDOException $e) {
        // Captura cualquier excepción PDO (error de base de datos)
        echo json_encode(array('error' => 'Error de base de datos: ' . $e->getMessage()));
    } catch (Exception $e) {
        // Captura cualquier otra excepción
        echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
    }
    

?>