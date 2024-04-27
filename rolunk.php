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
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rólunk</title>
  <link rel="stylesheet" href="./styles/altalanos.css" />
  <link rel="stylesheet" href="./styles/rolunk.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="icon" type="image/png" href="./Images/main-gallery-1.png" />
  <script src="script.js"></script>

</head>

<body>
  <header>
    <nav class="nav-menu">
      <button onclick="toggleMenu()" class="hambi">&#129517;</a>
        <p>Rólunk</p>
      </button>
      <ul>
        <li><a class="nav-link" href="./index.php">Főoldal</a></li>
        <li><a class="current" href="./rolunk.php">Rólunk</a></li>
        <li><a class="nav-link" href="./galeria.php">Galéria</a></li>
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
      <button><?php echo $navButton ?>
        <p style="display:inline"><?php echo $cartLength ?></p>
      </button>
    </nav>
  </header>

  <div class="content">
    <div class="paragraph-container">
      <img class="content-image" src="./Images/rolunk1.jpeg" alt="" />
      <p class="paragraph-p">
        Bemutatjuk a Vanish Vest köpenyt, egy forradalmi márka, amely a
        divat-technológia iparágának élén áll, és a láthatatlanságot célzó
        korszerű köpenyekre specializálódott gyártója. A Vanish Vest olyan
        kiválóságból született, ami a legmodernebb technológia és a látomásos
        tervezés összefonódásából ered. Így a Vanish Vest megváltoztatta
        azoknak a határait, amit a viselhető láthatatlanság terén
        lehetségesnek gondoltak.
      </p>
    </div>
    <div class="paragraph-container">
      <p class="paragraph-p">
        A Vanish Vest köpenyek aprólékos figyelemmel készülnek, és fejlett
        nanotechnológiát alkalmaznak, hogy tökéletesen beleolvadjanak a
        környezetükbe, gyakorlatilag láthatatlanná téve a viselőjüket a szabad
        szem előtt. Legyen szó akár a nyüzsgő városi utcák diszkrét
        átszeléséről, akár a vadonba való eltűnésről, a Vanish Vest mindig
        segít, szó szerint.
      </p>
      <img class="content-image" src="./Images/Rolunk2.jpeg" alt="" />
    </div>
    <div class="paragraph-container">
      <img class="content-image" src="./Images/rolunk3.jpeg" alt="" />
      <p class="paragraph-p">
        De a Vanish Vest nemcsak a láthatatlanságról szól. Mellényeiket
        kényelemre és sokoldalúságra tervezték, könnyű anyagokat használva,
        hogy a viselőjük könnyedén mozoghasson, anélkül hogy tartóssági
        szempontból kompromisszumot kellene kötni. A különféle stílusok és
        testreszabási lehetőségek széles választéka mellett minden mellény
        tökéletesen ötvözi a formát és a funkciót, az éppen aktuális modern
        kalandorok, városi felfedezők vagy titkos ügynökök igényeinek
        megfelelően.
      </p>
    </div>
  </div>

  <footer>
    <div class="footer-text">
      <h2>VANISH VEST</h2>
      <h3>Legyél a láthatatlanság mestere velünk!</h3>
      <p>
        Ha szeretnél láthatatlanná válni, akkor ez a megoldás neked való!
        Rendelj most!
      </p>
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