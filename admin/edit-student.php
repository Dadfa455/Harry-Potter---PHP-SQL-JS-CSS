<?php
    require "../classes/Database.php";
    require "../classes/Url.php";
    require "../classes/Student.php";
    require "../classes/Auth.php";

    session_start();

    $database = new Database();
    $connection = $database->connectionDB();

    $role = $_SESSION["role"];

    if (isset($_GET["id"]) ){
        $one_student = Student::getStudent($connection, $_GET["id"]);

        if ($one_student) {
            $first_name = $one_student["first_name"];
            $second_name = $one_student["second_name"];
            $age = $one_student["age"];
            $life = $one_student["life"];
            $college = $one_student["college"];
            $id = $one_student["id"];
        } else {
            die("Student nenalezen");
        }

    } else {
        die("ID není zadáno, student nebyl nalezen");
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $second_name = $_POST["second_name"];
        $age = $_POST["age"];
        $life = $_POST["life"];
        $college = $_POST["college"];

        if(Student::updateStudent($connection, $first_name, $second_name, $age, $life, $college, $id)){
            Url::redirectUrl("/skola-projekt/admin/one-student.php?id=$id");
        };
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/admin-edit-student.css">
    <link rel="stylesheet" href="../query/admin-edit-student-query.css">
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
        <?php if($role === "admin"): ?>
            <h1>Upravit žáka</h1>
            <section class="form">
                <?php require "../assets/form-student.php"; ?>
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