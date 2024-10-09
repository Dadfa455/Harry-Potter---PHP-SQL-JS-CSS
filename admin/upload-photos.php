<?php
    require "../classes/Auth.php";
    require "../classes/Database.php";
    require "../classes/Url.php";
    require "../classes/Image.php";

    session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/general.css">
    <title>Document</title>
</head>
<body>
    <?php
        if (!Auth::isLoggedIn() ){
            die("
                <main class='login'>
                    <div>
                        <h1 class='die'>Nepovolený přístup</h1>
                        <a href='../signin.php'>Zpět na přihlášení</a>
                    </div>
                </main>
            ");
        }
    ?>
</body>
</html>

<?php
    $user_id = $_SESSION["logged_in_user_id"];

    if (isset($_POST["submit"]) && isset($_FILES["image"])) {
        $db = new Database();
        $connection = $db->connectionDB();
        
        $image_name = $_FILES["image"]["name"];
        $image_size = $_FILES["image"]["size"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];

        if (!$error) {
            if ($image_size > 9000000) {
                Url::redirectUrl("/skola-projekt/errors/error-page.php?error_text=Váš soubor je příliš velký");
            } else {
                $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                $allowed_extensions = ["jpg", "jpeg", "png"];

                if (in_array($image_extension, $allowed_extensions)) {
                    // sestavujeme unikátní název obrázku
                    $image_name = uniqid("IMG-", true) . "." . $image_extension;

                    if (!file_exists("../uploads/" . $user_id)) {
                        mkdir("../uploads/" . $user_id, 0777, true);
                    }

                    $image_upload_path = "../uploads/" . $user_id . "/" . $image_name;

                    move_uploaded_file($image_tmp_name, $image_upload_path);

                    // Vložení obrázku do databáze
                    if (Image::insertImage($connection, $user_id, $image_name)) {
                        Url::redirectUrl("/skola-projekt/admin/photos.php");
                    }
                } else {
                    Url::redirectUrl("/skola-projekt/errors/error-page.php?error_text=Koncovka vašeho souboru není podporovaná");
                }
            }
        } else {
            Url::redirectUrl("/skola-projekt/errors/error-page.php?error_text=Vložit obrázek se bohužel nepodařilo");
        }
    }
?>