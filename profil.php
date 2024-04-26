<?php
    session_start();
    
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];

        $users = json_decode(file_get_contents('adatbázis/felhasznalok.json'), true);
        $username = $_SESSION["username"];
        $userIndex = array_search($username, array_column($users, 'username'));

        $regOrProf = '<li><a class="nav-link" href="./profil.php">Profil</a></li>';

        $username = $users[$userIndex]['username'];
        $email = $users[$userIndex]['email'];
        $address = $users[$userIndex]['address'];
        $phone = $users[$userIndex]['phone'];
        $fullName = $users[$userIndex]['fullName'];

        $cartLength = $users[$userIndex]['cart']['quantity'];

        if($profilPic == '') {
            $profilPic = './Images/profilPic.jpeg';
        }
    }else {
        $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
    }
    





    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_email"])) {
            $newEmail = $_POST["new_email"];
            $users[$userIndex]['email'] = $newEmail;
            file_put_contents('adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_address"])) {
            $newAddress = $_POST["new_address"];
            $users[$userIndex]['address'] = $newAddress;
            file_put_contents('adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_phone"])) {
            $newPhone = $_POST["new_phone"];
            $users[$userIndex]['phone'] = $newPhone;
            file_put_contents('adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }

    // Kijelentkezes gomb
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
        session_unset();    
        session_destroy();  
        header("Location: bejelentkezes.php");
        exit();
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
            <li><a class=" nav-link" href="./rendeles.php">Rendelés</a></li>
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

        <div class="main">
            <div class="content-main">

                <?php
                echo '<h2>Welcome ' . $username . '! </h2>';
            ?>

            </div>
    </div>

    
    <div class="content">
        <div class="main">
        <h2>Adatok</h2>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Display Username -->
        <div>
            <label>Felhasználónév:</label>
            <p><?php echo $username ?></p>
            <label>Teljes név:</label>
            <p><?php echo $fullName ?></p>
            <input type="text" name="new_fullName" value="Teljes név">
            <button type="submit" name="modify_fullName">Módosítás</button>
        </div>

        <!-- Display Email -->
        <div>
            <label>Email:</label>
            <p><?php echo $email ?></p>
            <input type="text" name="new_email" value="e-mail cím">
            <button type="submit" name="modify_email">Módosítás</button>
        </div>

        <!-- Modify Address -->
        <div>
            <label>Cím:</label>
            <p><?php echo $address; ?></p>
            <input type="text" name="new_address" value="Cím">
            <button type="submit" name="modify_address">Módosítás</button>
        </div>

        <!-- Modify Phone Number -->
        <div>
            <label>Telefonszám:</label>
            <p><?php echo $phone; ?></p>
            <input type="text" name="new_phone" value="telefonszám">
            <button type="submit" name="modify_phone">Módosítás</button>
        </div>

        <!-- Modify Password -->
        <div>
            <label>Jelszó:</label>
            <input type="password" name="new_password" value="********">
            <button type="submit" name="modify_password">Módosítás</button>
        </div>
    </form>
        </div>
    </div>

    <div>
        <h3>Profilkép és információk:</h3>
        <img src="<?php echo $profilPic ?>" alt="Profilkép">
        <p>Felhasználónév: <?php echo $username; ?></p>
        <p><a href="uzenetek.php">Üzenetek</a></p>
        <p><a href="delete_profile.php">Profil törlése</a></p>
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
