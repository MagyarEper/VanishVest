<?php
session_start();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    $users = json_decode(file_get_contents('./adatbázis/felhasznalok.json'), true);
    $username = $_SESSION["username"];
    $userIndex = array_search($username, array_column($users, 'username'));

    $regOrProf = '<li><a class="nav-link" href="./profil.php">Profil</a></li>';

    $username = $users[$userIndex]['username'];
    $email = $users[$userIndex]['email'];
    $address = $users[$userIndex]['address'];
    $phone = $users[$userIndex]['phone'];
    $fullName = $users[$userIndex]['fullName'];

    $isAdmin = !$users[$userIndex]['admin'] ? '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>' : '<li><a class=" nav-link"  href="./megrendelesek.php">Megrendelések</a></li>';

    $cartLength = $users[$userIndex]['cart']['quantity'];
    $navButton = '<i style="font-size:25px;padding:5px"class="fa fa-shopping-cart"></i>';
} else {
    $cartLength = "";
    $isAdmin = '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>';
    $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
    $navButton = '<a style="color: #ffffff" href="./bejelentkezes.php">Bejelentkezes</a>';
}
?>

<!DOCTYPE html>

<head>
    <html lang="hu">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üzenetek</title>
    <link rel="stylesheet" href="./styles/uzenetek.css">
    <link rel="stylesheet" href="./styles/altalanos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="./Images/main-gallery-1.png" />
    <script src="script.js"></script>
</head>

<body>
    <header>
        <!--Menu sáv-->
        <nav class="nav-menu">
            <button onclick="toggleMenu()" class="hambi">&#129517;</a>
                <p>Főoldal</p>
            </button>
            <ul>
                <li><a class="current" href="./index.php">Főoldal</a></li>
                <li><a class=" nav-link" href="./rolunk.php">Rólunk</a></li>
                <li><a class=" nav-link" href="./galeria.php">Galéria</a></li>
                <?php
                echo $regOrProf;
                ?>
                <?php
                echo $isAdmin;
                ?>


            </ul>
            <div class="mini-menu">
                <ul>
                    <li><a href="./index.php">Főoldal</a></li>
                    <li><a href="./rolunk.php">Rólunk</a></li>
                    <li><a href="./galeria.php">Galéria</a></li>
                    <li><a href="./regisztracio.php">Regisztráció</a></li>
                    <li><a href="./rendeles.php">Rendelés</a></li>
                </ul>
            </div>
            <h1 id="menu-h1">VANISH VEST</h1>
            <button id="callToAction"><?php echo $navButton ?>
                <p style="display:inline"><?php echo $cartLength ?></p>
            </button>

        </nav>
    </header>
    <div class="container">
        <div class="">
        <h1>Üzenetek</h1>
        <?php

        $json = file_get_contents('./adatbázis/uzenetek.json');
        $messageData = json_decode($json, true);

        foreach ($messageData as $message) {
            $targy = $message['subject'];
            $sender = $message['sender'];
            $recive = $message['reciver'];
            $text = $message['text'];

            if ($recive == $_SESSION['username']) {
                echo'<div class="uzenet">';
                    echo "<h3>Tárgy: </h3><p>$targy</p>";
                    echo "<h3>Küldő: </h3><p>$sender</p>";
                    echo "<h3>Üzenet: </h3><p>$text</p>";
                    echo "<h3>Válasz:<h3/>";
                    echo '<button><a href="user_profile.php?username=' . $sender . '">' . $sender . ' Válasz</a></button>';
                echo '</div>';
            }
        }

        ?>
        </div>
    </div>
    <footer>
        <div class="footer-text">
            <h2>VANISH VEST</h2>
            <h3>Legyél a láthatatlanság mestere velünk!</h3>
            <p>Ha szeretnél láthatatlanná válni, akkor ez a megoldás neked való! Rendelj most!</p>
        </div>

        <div class="separator"></div>

        <div class="footer-link-container">
            <p style="font-size: 50px;"> &#129517;</p>
            <ul id="foot-menu" class="footer-links">
                <li><a href="./index.html">Főoldal</a></li>
                <li><a href="./rolunk.html">Rólunk</a></li>
                <li><a href="./galeria.html">Galéria</a></li>
                <li><a href="./regisztracio.html">Regisztráció</a></li>
                <li><a href="./rendeles.html">Rendelés</a></li>
            </ul>
            <ul class="footer-links">
                <li>
                    <p>Elérhetőségek:</p>
                </li>
                <li>
                    <p>info@vanishvest.com</p>
                </li>
                <li>
                    <p>+36 30 123 4567</p>
                </li>
                <li>
                    <p>VanishVest Kft.</p>
                </li>
                <li>
                    <p>1234 Budapest, Rejtett utca 5.</p>
                </li>
            </ul>
        </div>
    </footer>
</body>

</html>