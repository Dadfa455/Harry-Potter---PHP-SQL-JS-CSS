<?php
    require "../classes/Auth.php";
    require "../classes/Image.php";
    require "../classes/Database.php";

    session_start();

    $db = new Database();
    $connection = $db->connectionDB();

    $user_id = $_SESSION["logged_in_user_id"];

    $allImages = Image::getImagesByUserId($connection, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/admin-photos.css">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php
        if (!Auth::isLoggedIn() ){
            die("<h1 class='die'>Nepovolený přístup</h1>");
        }
    ?>
    
    <?php require "../assets/admin-header.php"; ?>

    <main>
        <?php if($role === "admin"): ?>
            <section class="upload-photos">
                <h1>Fotky</h1>
                <form action="upload-photos.php" method="post" enctype="multipart/form-data">
                    <label for="choose-file" id="choose-file-text">Vybrat obrázek</label>
                    <input type="file" id="choose-file" name="image" require>
                    <input type="submit" class="upload-file" value="Nahrát obrázek" name="submit">
                </form>
            </section>

            <section class="images">
                <article>
                    <?php
                        foreach ($allImages as $one_image) { ?>
                            <div>
                                <div>
                                    <img src="../uploads/<?=$user_id; ?>/<?=$one_image["image_name"]; ?>" alt=<?=$one_image["image_name"]; ?>>
                                </div>
                                <div class="images-btn">
                                    <a class="image-btn-download" href="../uploads/<?=$user_id; ?>/<?=$one_image["image_name"]; ?>" download="Stažený soubor">Stáhnout</a>
                                    <a class="image-btn-delete" href="delete-photo.php?id=<?=$user_id; ?>&image_name=<?=$one_image["image_name"]; ?>">Smazat</a>
                                </div>
                            </div>
                        <?php }
                    ?>
                </article>
            </section>
        <?php else: ?>
            <section>
                <h1>Obsah této stránky je k dispozici pouze administrátorům</h1>
            </section>
        <?php endif; ?>
    </main>

    <?php require "../assets/footer.php"; ?>

    <script src="../js/header.js"></script>
</body>
</html>