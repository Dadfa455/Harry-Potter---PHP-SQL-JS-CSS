<?php
    class Database {
        public function connectionDB() {
            $db_host = "localhost";
            $db_name = "projekt_skola";
            $db_user = "david";
            $db_password = "admin123";
            
            $connection = "mysql:host=" . $db_host . "; dbname=" . $db_name . "; charset=utf8";

            try {
                $db = new PDO($connection, $db_user, $db_password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $db;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }
?>