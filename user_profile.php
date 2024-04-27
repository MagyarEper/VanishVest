<?php

    $accountId = $_GET['username'];
    
    $users = json_decode(file_get_contents('./adatbázis/felhasznalok.json'), true);
    $userIndex = array_search($accountId, array_column($users, 'username'));

    $username = $users[$userIndex]['username'];
    $email = $users[$userIndex]['email'];
    $address = $users[$userIndex]['address'];
    $phone = $users[$userIndex]['phone'];
    $fullName = $users[$userIndex]['fullName'];

    $profilPic = $users[$userIndex]['profilPic'] !== '' ? $users[$userIndex]['profilPic'] : './Images/profilPic.jpeg';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["uzenet"])) {
            $messages = json_decode(file_get_contents('./adatbázis/uzenetek.json') , true);
            $new_message = [
            'sender' => $_POST['sender'],
            'reciver' => $username,
            'subject' => $_POST['subject'],
            'text' => $_POST['message']
              ];
            $messages[] = $new_message;
            file_put_contents('./adatbázis/uzenetek.json', json_encode($messages, JSON_PRETTY_PRINT));
            header('Location: profil.php');
        }
    }
    ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="./styles/profil.css">
    <link rel="stylesheet" href="./styles/altalanos.css">
    <link rel="icon" 
    type="image/png" 
    href="./Images/main-gallery-1.png"/>
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
            <li ><a class="current" href="./index.php">Főoldal</a></li>
            <li><a class=" nav-link" href="./rolunk.php">Rólunk</a></li>
            <li><a class=" nav-link" href="./galeria.php">Galéria</a></li>
            <li><a class="nav-link" href="./profil.php">Profil</a></li>
        </ul>
        <div class="mini-menu">
            <ul>
              <li><a href="./index.php">Főoldal</a></li>
              <li><a href="./rolunk.php">Rólunk</a></li>
              <li><a  href="./galeria.php">Galéria</a></li>
              <li><a  href="./profil.php">Profil</a></li>
              <li><a  href="./rendeles.php">Rendelés</a></li>
            </ul>
          </div>
        <h1 id="menu-h1">VANISH VEST</h1>

        <!-- kijelentkezes gomb -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="logout">Kijelentkezés</button>

    </form>
    </nav>
</header>
    <div class="content">
            <div class="adatok">
        <form>
            <div>
                    <?php
                    echo '<h1>' . $username . '\'s Profile</h1>';
                    ?>
                <label>Teljes név:</label>
                <p><?php echo $fullName ?></p>
            </div>

            <!-- Display Email -->
            <div>
                <label>Email:</label>
                <p><?php echo $email ?></p>
            </div>

            <!-- Modify Address -->
            <div>
                <label>Cím:</label>
                <p><?php echo $address; ?></p>
            </div>

            <!-- Modify Phone Number -->
            <div>
                <label>Telefonszám:</label>
                <p><?php echo $phone; ?></p>
            </div>
        </form>
        </div>
        <div class="adatok">
            <h3>Üzenet küldése:</h3>
            <form method="POST" action="user_profile.php">
                <label for="subject">Tárgy</label>
                <input type="text" name="subject" placeholder="tárgy">
                <label for="sender">Küldő</label>
                <input type="text" name="sender" placeholder="tárgy">
                <label for="message">Üzenet</label>
                <input type="text" name="message" placeholder="tárgy">
                <button type="submit" name="uzenet">Elküldés</button>
            </form>

            <img src="<?php echo $profilPic ?>" alt="Profilkép">
            <p><?php echo $username; ?></p>
        </div>
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
            <li><a href="./index.php">Főoldal</a></li>
            <li><a href="./rolunk.php">Rólunk</a></li>
            <li><a href="./galeria.php">Galéria</a></li>
            <li><a href="./regisztracio.php">Regisztráció</a></li>
            <li><a href="./rendeles.php">Rendelés</a></li>
        </ul>
        <ul class="footer-links">
            <li><p>Elérhetőségek:</p></li>
            <li><p>info@vanishvest.com</p></li>
            <li><p>+36 30 123 4567</p></li>
            <li><p>VanishVest Kft.</p></li>
            <li><p>1234 Budapest, Rejtett utca 5.</p></li>
        </ul>
    </div>
</footer>
</body>
</html>