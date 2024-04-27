<?php
    session_start();
    
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];

        $users = json_decode(file_get_contents('./adatbázis/felhasznalok.json'), true);
        $username = $_SESSION["username"];
        $userIndex = array_search($username, array_column($users, 'username'));

        $regOrProf = '<li><a class="nav-link" href="./profil.php">Profil</a></li>';
        $navButton = '<i style="font-size:25px;padding:5px"class="fa fa-shopping-cart"></i> <?php echo $cartLength ?>';

        $username = $users[$userIndex]['username'];
        $email = $users[$userIndex]['email'];
        $address = $users[$userIndex]['address'];
        $phone = $users[$userIndex]['phone'];
        $fullName = $users[$userIndex]['fullName'];

        $isAdmin = !$users[$userIndex]['admin'] ? '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>' : '<li><a class=" nav-link"  href="./megrendelesek.php">Megrendelések</a></li>';

        $cartLength = $users[$userIndex]['cart']['quantity'];

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $orders = [];
            $orders = json_decode((file_get_contents("./adatbázis/megrendelesek.json")), true);

            $new_order = [
                'username' => $username,
                'fullName' => $fullName,
                'address' => $address,
                'phone'=> $phone,
                'email' => $email,
                'size' => $_POST["meret"],
                "color"=> $_POST["szin"],
                "quantity"=> $_POST["darab"],
                "done" => "false"
            ];
            $orders[] = $new_order;

            $json_data = json_encode($orders, JSON_PRETTY_PRINT);
            file_put_contents("./adatbázis/megrendelesek.json", $json_data);
        }
    }

    else{

        $username = '';
        $email = 'E-mail';
        $address = 'Megrendelési cím';
        $phone = 'Telefonszám';
        $fullName = 'Teljes Név';


        $isAdmin = '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>';
        $cartLength = "";
        $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
        $navButton = '<a style="color: #ffffff" href="./bejelentkezes.php">Bejelentkezes</a>';

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
    }

    
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés</title>
    <link rel="stylesheet" href="./styles/rendeles.css">
    <link rel="stylesheet" href="./styles/altalanos.css">
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
                <p>Rendelés</p>
            </button>
            <ul>
                <li ><a class=" nav-link" href="./index.php">Főoldal</a></li>
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
            <button><?php echo $navButton ?><p style="display:inline"><?php echo $cartLength ?></p></button>
        </nav>
    </header>

    <div class="main">
    <div class="content">
        <p style="text-align: start;">&#11088;</p>
        <h2>Megrendelés adatai:</h2>
        <form action="rendeles.php" method="POST">
            <div class="form-group">
                <label for="meret">Méret:</label>
                <select id="meret" name="meret" required>
                    <option value="">Méret</option>
                    <option value="extrasmall">XS</option>
                    <option value="small">S</option>
                    <option value="medium">M</option>
                    <option value="large">L</option>
                    <option value="extralarge">XL</option>
                </select>
            </div>
            <div class="form-group">
                <label for="szin">Szín:</label>
                <select  id="szin" name="szin" required>
                    <option value="">Szín</option>
                    <option value="kek">Kék</option>
                    <option value="zold">Zöld</option>
                    <option value="szurke">Szürke</option>
                </select>
            </div>
            <div class="form-group">
                <label for="darab">Darab:</label>
                <input type="number" id="darab" name="darab" min="1" placeholder="1" required>
            </div>
        <table class="merettabla">
            <tr>
              <th>Méretezés</th>
              <th>Hossz</th>
              <th>Szélesség</th>
            </tr>
            <tr>
              <td>S</td>
              <td>150 cm</td>
              <td>70 cm</td>
            </tr>
            <tr>
              <td>M</td>
              <td>170 cm</td>
              <td>85 cm</td>
            </tr>
            <tr>
              <td>L</td>
              <td>190 cm</td>
              <td>100 cm</td>
            </tr>
          </table>
          <?php
            $filledFields = 0;
            if (!empty($_POST['meret'])) $filledFields++;
            if (!empty($_POST['darab'])) $filledFields++;
            if (!empty($_POST['szin'])) $filledFields++;
    
            // If at least three fields are filled, show "Add to Basket" button; otherwise, show "Order" button
            if ($filledFields >= 3) {
                echo '<button type="submit" name="addToBasket">A kosárba!</button>';
            } else {
                echo '<button type="submit" name="order">Megrendelem!</button>';
            }
          ?>
          <p style="text-align: end;">&#11088;</p>
    </div>
    <div class="image-container">
        <img src="./Images/megrendeles.jpeg" alt="">
    <button type="submit">Megrendelem!</button>
</div>
    <div class="content">
        <p style="text-align: end;">&#11088;</p>
        <h2>Szállítási adatok:</h2>
            <div class="form-group">
                <label for="megrendelo">Megrendelő neve:</label>
                <input type="text" id="megrendelo" name="megrendelo" placeholder="<?php echo $fullName ?>" required>
            </div>
            <div class="form-group">
                <label for="cim">Megrendelési cím:</label>
                <input  type="text" id="cim" name="cim" placeholder="<?php echo $address ?>" required>
            </div>
            <div class="form-group">
                <label for="telefon">Telefonszám:</label>
                <input  type="text" id="telefon" name="telefon" placeholder="<?php echo $phone ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input  type="text" id="email" name="email" placeholder="<?php echo $email ?>" required>
            </div>
            <button id="min-button" type="submit">Megrendelem!</button>
            <button id="min-reset" type="reset">Adatok törlése!</button>
        </form>
        <p style="text-align: start;">&#11088;</p>
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
