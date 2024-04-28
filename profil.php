<?php
    session_start();

    
    if(isset($_SESSION["username"])){
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

        $profilPic = $users[$userIndex]['profilPic'];

        $cartLength = $users[$userIndex]['cart']['quantity'];
        $isAdmin = !$users[$userIndex]['admin'] ? '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>' : '<li><a class=" nav-link"  href="./megrendelesek.php">Megrendelések</a></li>';


        if($profilPic == '') {
            $profilPic = './Images/profilPic.jpeg';
        }

    }else {
        $isAdmin = false;
        $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
    }
    





    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_fullName"])) {
            $newFullName = $_POST["new_fullName"];
            $users[$userIndex]['fullName'] = $newFullName;
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_email"])) {
            $newEmail = $_POST["new_email"];
            $users[$userIndex]['email'] = $newEmail;
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_address"])) {
            $newAddress = $_POST["new_address"];
            $users[$userIndex]['address'] = $newAddress;
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["modify_phone"])) {
            $newPhone = $_POST["new_phone"];
            $users[$userIndex]['phone'] = $newPhone;
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            header('Location: profil.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["delete_account"])) {
            unset($users[$userIndex]);
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
            session_unset();    
            session_destroy();
            header('Location: index.php');

        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
            $uploadDirectory = "profile_pictures/";
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFilePath = $uploadDirectory . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath);
            $profilPic = $targetFilePath;
            $users[$userIndex]['profilPic'] = $profilPic;
            file_put_contents('./adatbázis/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));
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
            Főoldal
        </button>
        <ul>
            <li ><a class="nav-link" href="./index.php">Főoldal</a></li>
            <li><a class="nav-link" href="./rolunk.php">Rólunk</a></li>
            <li><a class="nav-link" href="./galeria.php">Galéria</a></li>
            <li><a class="current" href="./profil.php">Profil</a></li>
            <?php
                echo $isAdmin;
            ?>
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

            </div>
    </div>

    
    <div class="content">
        <div class="adatok">
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
                    <p><?php echo '' ?></p>
                    <input type="password" name="new_password" value="********">
                    <button type="submit" name="modify_password">Módosítás</button>
                </div>
                <div>
                    <label>Profil törlése</label>
                    <button type="submit" name="delete_account">Törlés</button>
                </div>
            </form>
        </div>
        
        <div class="adatok">
            <img src="<?php echo $profilPic ?>" alt="Profilkép">
            <p><?php echo $username; ?></p>
            <form method="post" action="profil.php" enctype="multipart/form-data">
                <input type="file" name="profile_picture" accept="image/*">
                <input type="submit" value="Upload">
            </form>
            <p class="uzenetek"><a href="./uzenetek.php">Üzenetek</a></p>
            <h3>Aktív felhasználók:</h3>
            <?php
        
        
        foreach ($users as $account) {
            echo '<ul>';
            echo '<li><a href="user_profile.php?username=' . $account['username'] . '">' . $account['username'] . '</a></li>';
            echo '</ul>';
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
