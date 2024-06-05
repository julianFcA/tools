<?php

    // creamos una clase para realizar la conexion a la base de datos

    class Database
    {
        // Variable para declarar el parametro del servidor
        private $localhost = "localhost";
        private $database = "herramientas_1";
        private $username = "root";
        private $userpassword = "";
        private $charset ="utf8";

        // MANEJO DE EXCEPCIONES TRY AND CATCH


        function conectar()
        {
            try{
                $conn = "mysql:host=".$this->localhost.";dbname=".$this->database.";charset=".$this->charset;
                $option=[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

                $pdo= new PDO($conn,$this->username,$this->userpassword,$option);
                return $pdo;

            }catch(PDOException $e ){
                echo 'ERROR DE CONEXION A LA BASE DE DATOS:'.$e ->getMessage();
                exit;
            }
        }
    }


?>