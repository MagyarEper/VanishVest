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

        $isAdmin = !$users[$userIndex]['admin'] ? '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>' : '<li><a class=" nav-link"  href="./megrendelesek.php">Megrendelések</a></li>';

        $cartLength = $users[$userIndex]['cart']['quantity'];
        $navButton = '<i style="font-size:25px;padding:5px"class="fa fa-shopping-cart"></i>';
    }else {
        $cartLength = "";
        $isAdmin = '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>';
        $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
        $navButton = '<a style="color: #ffffff" href="./bejelentkezes.php">Bejelentkezes</a>';
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="./styles/fooldal.css">
    <link rel="stylesheet" href="./styles/altalanos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <li ><a class="current" href="./index.php">Főoldal</a></li>
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
              <li><a  href="./galeria.php">Galéria</a></li>
              <li><a  href="./regisztracio.php">Regisztráció</a></li>
              <li><a  href="./rendeles.php">Rendelés</a></li>
            </ul>
          </div>
        <h1 id="menu-h1">VANISH VEST</h1>
        <button id="callToAction"><?php echo $navButton ?> <?php echo $cartLength ?></button>

    </nav>
</header>

    <div class="content">
        <div class="main">
            <img id="banner" src="./Images/bannerImage.png" alt="banner ">
            <div class="content-main">
                <p id="jobb-p">Fedezze fel a láthatatlanság új dimenzióit az VanishVest segítségével!</p>
                <img src="./Images/logo3.png" alt="Vanish Vest Logo" class="logo">
                <p id="bal-p">Mert néha a legjobb dolog az, ha senki sem látja, hogy ott vagyunk.</p>
            </div>
        </div>
    </div>

    <div class="gallery-container">
        <h1 id="galleryh1">GALERIA</h1>
        <div class="gallery">
            <img src="./Images/main-gallery-1.png" alt="Photo 1">
            <img id="middle-image" src="./Images/main-gallery-2.png" alt="Photo 2">
            <img src="./Images/main-gallery-3.png" alt="Photo 3">
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
