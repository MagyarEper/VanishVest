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

    $cartLength = $users[$userIndex]['cart']['quantity'] ? $users[$userIndex]['cart']['quantity'] : "0";
    $navButton = '<i style="font-size:25px;padding:5px"class="fa fa-shopping-cart"></i>';
    $isAdmin = !$users[$userIndex]['admin'] ? '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>' : '<li><a class=" nav-link"  href="./megrendelesek.php">Megrendelések</a></li>';

} else {
    $regOrProf = '<li><a class="nav-link" href="./regisztracio.php">Regisztráció</a></li>';
    $navButton = '<a style="color: #ffffff" href="./bejelentkezes.php">Bejelentkezes</a>';
    $cartLength = "";
    $isAdmin = '<li><a class=" nav-link"  href="./rendeles.php">Rendelés</a></li>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES["gallery_pic"]) && $_FILES["gallery_pic"]["error"] == UPLOAD_ERR_OK) {
        $uploadDirectory = "gallery_pictures/";
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        $fileName = basename($_FILES["gallery_pic"]["name"]);
        $targetFilePath = $uploadDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["gallery_pic"]["tmp_name"], $targetFilePath);
        $gallery_pic = json_decode(file_get_contents('./adatbázis/gallery_pictures.json'));
        $new_pic = [
            'id' => rand(),
            'uploader' => $username ? $username : 'anonymus',
            'picture' => $targetFilePath,
        ];
        $gallery_pic[] = $new_pic;
        file_put_contents('./adatbázis/gallery_pictures.json', json_encode($gallery_pic, JSON_PRETTY_PRINT));
    }

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
    <link rel="icon" type="image/png" href="./Images/main-gallery-1.png" />
    <script src="script.js"></script>
</head>

<body>
    <header>
        <nav class="nav-menu">
            <button onclick="toggleMenu()" class="hambi">&#129517;</a>
                <p>Galéria</p>
            </button>
            <ul>
                <li><a class=" nav-link" href="./index.php">Főoldal</a></li>
                <li><a class=" nav-link" href="./rolunk.php">Rólunk</a></li>
                <li><a class="current" href="./galeria.php">Galéria</a></li>
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

    <div class="main">
        <div class="gallery">
            <div class="image" id="upload">
            <form method="POST" action="galeria.php" enctype="multipart/form-data">
                <input id="browseButton" type="file" name="gallery_pic" accept="image/*">
                <input id="uploadButton" type="submit" value="Feltöltés">
            </form>
        </div>

            <?php
            $json = file_get_contents('./adatbázis/gallery_pictures.json');
            $galleryData = json_decode($json, true);

            foreach ($galleryData as $image) {
                echo '<div>';
                echo '<div >';
                    echo '<p style="position: absolute; color: #ffffff"> Feltöltő: '. $image['uploader'] .'</p>';
                echo '</div>';
                echo '<div class="image">';
                    echo '<img src="' . $image['picture'] . '" alt="Image">';
                echo '</div>';
                echo '</div>';
            }
            ?>
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