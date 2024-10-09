<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './vendor/PHPMailer/src/Exception.php';
    require './vendor/PHPMailer/src/PHPMailer.php';
    require './vendor/PHPMailer/src/SMTP.php';

    $first_name = "";
    $last_name = "";
    $email = "";
    $message = "";

    if (isset($_POST["submit"])) {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $errors = [];

        if (empty($first_name)) {
            $errors[] = "Jméno je povinné";
        }
        
        if (empty($last_name)) {
            $errors[] = "Příjmení je povinné";
        }
        
        if (empty($email)) {
            $errors[] = "Email je povinný";
        }
        
        if (empty($message)) {
            $errors[] = "Zpráva je povinná";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "E-mail je ve špatném formátu";
        }

        if (empty($errors)) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "dadfa455@gmail.com";
                $mail->Password = "cooyylavypkbiask";
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;

                $mail->CharSet = "utf8";
                $mail->Encoding = "base64";
            
                $mail->setFrom("dadfa455@gmail.com");
                $mail->addAddress($email);
                $mail->Subject = "Předmět";
                $mail->Body = "Křestní jméno: $first_name \nPříjmení: $last_name \nZpráva: $message";
            
                $mail->send();

                echo "Zpráva odeslána";

            } catch (Exception $e) {
                  echo "Zpráva nebyla odeslána: ", $mail->ErrorInfo;
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/footer.css">

    <link rel="stylesheet" href="./css/contact.css">

    <script src="https://kit.fontawesome.com/0fe3234472.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require "assets/header.php"; ?>

    <main>
        <section class="errors">
            <?php
                if (!empty($errors)) {
                    echo "<ul>";
                        foreach ($errors as $error) {
                            echo "<li>$error</li>";
                        }
                    echo "</ul>";
                }
            ?>
        </section>

        <section class="form">
            <form method="post">
                <h1>Kontaktuje nás</h1>
                <input type="text" value="<?=$first_name; ?>" name="first_name" placeholder="Křestní jméno"><br>
                <input type="text" value="<?=$last_name; ?>" name="last_name" placeholder="Příjmení"><br>
                <input type="text" value="<?=$email; ?>" name="email" placeholder="E-mail"><br>
                <textarea name="message" placeholder="Vaše zpráva"><?=$message; ?></textarea><br>
                <button class="btn" type="submit" name="submit">Odeslat dotaz</button>
            </form>
        </section>
    </main>

    <?php require "assets/footer.php"; ?>

    <script src="./js/header.js"></script>
</body>
</html>