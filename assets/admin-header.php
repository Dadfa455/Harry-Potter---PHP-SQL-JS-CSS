<?php
    if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] != "off") {
        $url_protocol = "https";
    } else {
        $url_protocol = "http";
    }

    $role = $_SESSION["role"];
?>

<header>
    <div class="logo">
        <a href="./students.php">
            <img src="../img/hogwarts-logo.png" alt="">
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="<?=$url_protocol;?>://<?=$_SERVER["HTTP_HOST"]; ?>/skola-projekt/admin/students.php">Seznam žáků</a></li>
            <li><a href="<?=$url_protocol;?>://<?=$_SERVER["HTTP_HOST"]; ?>/skola-projekt/admin/add-student.php">Přidat žáka</a></li>
            <?php if($role === "admin"): ?>
                <li><a href="<?=$url_protocol;?>://<?=$_SERVER["HTTP_HOST"]; ?>/skola-projekt/admin/photos.php">Fotky</a></li>
            <?php endif; ?>
            <li><a href="<?=$url_protocol;?>://<?=$_SERVER["HTTP_HOST"]; ?>/skola-projekt/admin/log-out.php">Odhlásit</a></li>
        </ul>
    </nav>
    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>