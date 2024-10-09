<?php
    $error_text = $_GET["error_text"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require "../assets/admin-header.php"; ?>
    <main>
        <section class="error">
            <p><?=$error_text; ?></p>
        </section>
    </main>
    <?php require "../assets/footer.php"; ?>

    <script src="../js/header.js"></script>
</body>
</html>