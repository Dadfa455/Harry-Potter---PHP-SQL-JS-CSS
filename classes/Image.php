<?php
    class Image {
        public static function insertImage($connection, $user_id, $image_name) {

            $sql = "INSERT INTO image (user_id, image_name) 
            VALUES (:user_id, :image_name)";

            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);

            try {
                if ($stmt->execute()) {
                    return true;
                } else {
                    throw new Exception("Přidání obrázku selhalo");
                }
            } catch (Exception $e) {
                error_log("Chyba u funce insertImage, insert image se nepovedl\n", 3, "../errors/error.log");
                echo "Chyba: " . $e->getMessage();
            }
        }

        public static function getImagesByUserId($connection, $user_id) {
            $sql = "SELECT * FROM image WHERE user_id = :user_id";

            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $images;
        }

        public static function deletePhotoFromDirectory($path) {
            try {
                // Kontrole existence souboru

                if (!file_exists($path)) {
                    throw new Exception("Soubor neexistuje");
                }

                // Smazání souboru
                if (unlink($path)) {
                    return true;
                } else {
                    throw new Exception("Při mazání souboru došlo k cchybě");
                }
            } catch (Exception $e) {
                error_log("Chyba u funce deletePhotoFromDirectory, deletePhotoFromDirectory se nepovedl\n", 3, "../errors/error.log");
                echo "Chyba: " . $e->getMessage();
            }
        }

        public static function deletePhotoFromDatabase($connection, $image_name) {
            $sql = "DELETE FROM image WHERE image_name = :image_name";
            $stmt = $connection->prepare($sql);
            
            try {
                $stmt->bindParam(":image_name", $image_name, PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    throw new Exception("Obrázek se nepodařilo smazat z databáze");
                }
            } catch (Exception $e) {
                error_log("Chyba u funce deletePhotoFromDatabase, deletePhotoFromDatabase se nepovedl\n", 3, "../errors/error.log");
                echo "Chyba: " . $e->getMessage();
            }
        }
    }
?>