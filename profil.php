<?php
    session_start();

    // Bejelentkezett statusz csekkolasa
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: login.php");
        exit();
    }

    // Display welcome message with username
    $_SESSION['msg'] = "Üdvözöljük, " . $_SESSION["username"] . "!";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check which button was clicked and update corresponding field
        if (isset($_POST["modify_address"])) {
            // Handle modification of address
            // Example: Update database or JSON file with new address
            $newAddress = $_POST["new_address"]; // Retrieve new address from form
            // Perform database or file update operation here
            $_SESSION["address"] = $newAddress; // Update session variable
            // Redirect back to profile page or display success message
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
            <li ><a class="current" href="./index.html">Főoldal</a></li>
            <li><a class=" nav-link" href="./rolunk.html">Rólunk</a></li>
            <li><a class=" nav-link" href="./galeria.html">Galéria</a></li>
            <li><a class="nav-link" href="./profil.php">Profil</a></li>
            <li><a class=" nav-link" href="./rendeles.html">Rendelés</a></li>
        </ul>
        <div class="mini-menu">
            <ul>
              <li><a href="./index.html">Főoldal</a></li>
              <li><a href="./rolunk.html">Rólunk</a></li>
              <li><a  href="./galeria.html">Galéria</a></li>
              <li><a  href="./profil.php">Profil</a></li>
              <li><a  href="./rendeles.html">Rendelés</a></li>
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
                echo '<h2>' . $_SESSION['msg'] . '</h2>';
                unset($_SESSION['msg']);
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
            <p><?php echo $_SESSION["username"] ?></p>
        </div>

        <!-- Display Email -->
        <div>
            <label>Email:</label>
            <p><?php echo $_SESSION["email"] ?></p>
        </div>

        <!-- Modify Address -->
        <div>
            <label>Cím:</label>
            <input type="text" name="new_address" value="<?php echo $address; ?>">
            <button type="submit" name="modify_address">Módosítás</button>
        </div>

        <!-- Modify Phone Number -->
        <div>
            <label>Telefonszám:</label>
            <input type="text" name="new_phone" value="<?php echo $phone; ?>">
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
        <img src="profile_picture.jpg" alt="Profilkép">
        <p>Felhasználónév: <?php echo $_SESSION["username"]; ?></p>
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
