<?php
    require "../classes/Database.php";
    require "../classes/Student.php";
    require "../classes/Auth.php";

    session_start();

    $database = new Database();
    $connection = $database->connectionDB();


    $students = Student::getAllStudents($connection, "id, first_name, second_name");
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

    <link rel="stylesheet" href="../css/admin-students.css">
    <link rel="stylesheet" href="../query/admin-students-query.css">
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
        <section class="main-heading">
            <h1>Seznam žáků školy</h1>
        </section>

        <section class="filter">
            <input type="text" class="filter-input">
        </section>

        <section>
            <?php if(empty($students)): ?>
                <p class="not_found">Žádní žáci nebyli nalezeni</p>
            <?php else: ?>
                <div class="all-students">
                    <?php foreach($students as $one_student): ?>
                        <div class="one-student">
                            <h2><?php echo htmlspecialchars($one_student["first_name"]). " " .htmlspecialchars($one_student["second_name"]) ?></h2>
                            <a href="one-student.php?id=<?= $one_student['id'] ?>">Více informací</a>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </section>
    </main>

    <?php require "../assets/footer.php"; ?>
    <script src="../js/header.js"></script>
    <script src="../js/filter.js"></script>
</body>
</html>