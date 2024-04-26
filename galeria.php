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
        $navButton = '<i style="font-size:25px;padding:5px"class="fa fa-shopping-cart"></i>';

    }else {
        $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
        $navButton = '<a style="color: #ffffff" href="bejelentkezes.php">Bejelentkezes</a>';

    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galéria</title>
    <link rel="stylesheet" href="./styles/altalanos.css">
    <link rel="stylesheet" href="./styles/galeria.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" 
    type="image/png" 
    href="./Images/main-gallery-1.png"/>
    <script src="script.js"></script>
</head>
<body>
<header>
    <nav class="nav-menu">
        <button onclick="toggleMenu()" class="hambi">&#129517;</a>
            <p>Galéria</p>
        </button>
        <ul>
            <li ><a class=" nav-link" href="./index.php">Főoldal</a></li>
            <li><a class=" nav-link" href="./rolunk.php">Rólunk</a></li>
            <li><a class="current" href="./galeria.php">Galéria</a></li>
            <?php
                echo $regOrProf;
            ?>
            <li><a class=" nav-link" href="./rendeles.php">Rendelés</a></li>
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
        <button><?php echo $navButton ?><p style="display:inline"><?php echo $cartLength ?></p></button>
    </nav>
</header>

    <div class="main">
    <div class="gallery">
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak.jpeg" alt="Image 1">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(1).jpeg" alt="Image 1">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(2).jpeg" alt="Image 2">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(3).jpeg" alt="Image 3">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(4).jpeg" alt="Image 4">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(5).jpeg" alt="Image 1">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(6).jpeg" alt="Image 2">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(7).jpeg" alt="Image 3">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(8).jpeg" alt="Image 4">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(9).jpeg" alt="Image 1">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(10).jpeg" alt="Image 2">
        </div>
        <div class="image">
            <img src="./Images/peopl-in-invisible-cloak(11).jpeg" alt="Image 3">
        </div>
    </div>
</div>
</html>


<footer>
    <div class="footer-text">
        <h2>VANISH VEST</h2>
        <h3>Legyél a láthatatlanság mestere velünk!</h3>
        <p>Ha szeretnél láthatatlanná válni, akkor ez a megoldás neked való! Rendelj most!</p>
    </div>

    <div class="separator"></div>

    <div class="footer-link-container">
        <p style="font-size: 50px;"> &#129517; </p>
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