<?php
session_start();

// Felhasznalok beolvaso funkcio
function readRegistrationsFromFile($filename)
{
  $registrations = [];

  // fajl letezesenek ellenorzese
  if (file_exists($filename)) {
    // beolvasas
    $json_data = file_get_contents($filename);

    // adatok dekodolasa
    $registrations = json_decode($json_data, true);
  }

  return $registrations;
}

// JSON fileba iras
function writeRegistrationsToFile($filename, $registrations)
{
  // ragisztraciok JSON-ba dekodolasa
  $json_data = json_encode($registrations, JSON_PRETTY_PRINT);

  // fileba iras
  file_put_contents($filename, $json_data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  // adatok kitoltesenek validalasa
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['error_msg'] = "Kérlek minden szükséges mezőt tölts ki!";
    exit();
  }

  // email formatum validalasa
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_msg'] = "Nem megfelelő formátumú e-mail.";
    header("Location: regisztracio.php");
    exit();
  }

  // jelszo egyezes validalasa
  if ($password !== $confirm_password) {
    $_SESSION['error_msg'] = "A két jelszó nem egyezik meg.";
    header("Location: regisztracio.php");
    exit();
  }

  $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/';
  if (!preg_match($pattern, $password)) {
    $_SESSION['error_msg'] = "A jelszónak legalább 8 karakter hosszúnak kell lennie, tartalmazzon legalább egy nagybetűt, egy kisbetűt és egy számot.";
    header("Location: regisztracio.php");
    exit();
  }

  // letezo felhasznalok beolvasasa
  $registrations = readRegistrationsFromFile('felhasznalok.json');

  // felhasznalonev ellenorzese
  foreach ($registrations as $registration) {
    if ($registration['username'] === $username || $registration['email'] === $email) {
      $_SESSION['error_msg'] = "A felhasználónév vagy e-mail már szerepel a rendszerünkben.";
      header("Location: regisztracio.php");
      exit();
    }
  }

  // uj adat hozzaadasa
  $new_registration = [
    'username' => $username,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
  ];

  $registrations[] = $new_registration;

  // a modositott regisztaciok elmentese
  writeRegistrationsToFile('felhasznalok.json', $registrations);


  $_SESSION['success_msg'] = "A regisztráció sikeres!";

  // a fouldalra kuldes
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Regisztráció</title>
  <link rel="stylesheet" href="./styles/regisztracio.css" />
  <link rel="stylesheet" href="./styles/altalanos.css" />
  <link rel="icon" type="image/png" href="./Images/main-gallery-1.png" />
  <script src="script.js"></script>
</head>

<body>
  <header>
    <nav class="nav-menu">
      <button onclick="toggleMenu()" class="hambi">&#129517;</a>
        <p>Regisztráció</p>
      </button>
      <ul>
        <li><a class="nav-link" href="./index.html">Főoldal</a></li>
        <li><a class="nav-link" href="./rolunk.html">Rólunk</a></li>
        <li><a class="nav-link" href="./galeria.html">Galéria</a></li>
        <li><a class="current" href="./regisztracio.php">Regisztráció</a></li>
        <li><a class="nav-link" href="./rendeles.html">Rendelés</a></li>
      </ul>

      <div class="mini-menu">
        <ul>
          <li><a href="./index.html">Főoldal</a></li>
          <li><a href="./rolunk.html">Rólunk</a></li>
          <li><a href="./galeria.html">Galéria</a></li>
          <li><a href="./regisztracio.html">Regisztráció</a></li>
          <li><a href="./rendeles.html">Rendelés</a></li>
        </ul>
      </div>
      <h1 id="menu-h1">VANISH VEST</h1>
      <button>Rendelés</button>
    </nav>
  </header>


  <div class="content">
    <img src="./Images/registration.jpeg" alt="">
    <div class="middle">
      <div class="main">
        <p>
          Ne habozz tovább! Tedd meg az első lépést a varázslatos élet felé a
          Vanish Vest segítségével. A lehetőségek végtelenek, és csak rád várnak,
          hogy felfedezd őket. Legyél láthatatlan – legyél szabad. Legyél te a
          világ valóságos varázslója a Vanish Vest-tel!
        </p>
      </div>
      <div class="container">
        <form action="regisztracio.php" method="POST">
          <h2>Regisztráció</h2>
          <div class="form-group">
            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" />
          </div>
          <div class="form-group">
            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" />
          </div>
          <div class="form-group">
            <label for="confirm_password">Jelszó megerősítése:</label>
            <input type="password" id="confirm_password" name="confirm_password" />
          </div>
          <button type="submit">Regisztráció</button>
        </form>

        <?php
        if (isset($_SESSION['error_msg'])) {
          echo '<p>' . $_SESSION['error_msg'] . '</p>';
          unset($_SESSION['error_msg']); // Clear error message
        }
        ?>

      </div>
    </div>
    <img src="./Images/registration.jpeg" alt="">
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