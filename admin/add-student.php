<?php
require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Student.php";
require "../classes/Auth.php";

session_start();

$first_name = null;
$second_name = null;
$age = null;
$life = null;
$college = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $age = $_POST["age"];
    $life = $_POST["life"];
    $college = $_POST["college"];

    // $connection = connectionDB();
    $database = new Database();
    $connection = $database->connectionDB();
    
    $id = Student::createStudent($connection, $first_name, $second_name, $age, $life, $college);

    if($id){
        Url::redirectUrl("/skola-projekt/admin/one-student.php?id=$id");
    } else {
        echo "Žák nebyl vytvořen";
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/admin-add-student.css">
    <link rel="stylesheet" href="../query/admin-add-student-query.css">
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

    <?php require "../assets/admin-header.php"; ?>

    <main>
        <h1>Přidat žáka</h1>
        <section class="form">
            <?php require "../assets/form-student.php"; ?>
        </section>
    </main>

    <?php require "../assets/footer.php"; ?>
    <script src="../js/header.js"></script>
</body>
</html>