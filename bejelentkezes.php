<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="./styles/bejelentkezes.css">
    <link rel="stylesheet" href="./styles/altalanos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" 
    type="image/png" 
    href="./Images/main-gallery-1.png"/>
    <script src="script.js"></script>
</head>
<body>
    <?php
    session_start();

    // Adatok validalasa
    function validateUser($username, $password) {
        $users = json_decode(file_get_contents('./adatbázis/felhasznalok.json'), true);

        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                return true; 
            }
        }
        return false;
    }

    // Adatok elkuldese
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (validateUser($username, $password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("Location: profil.php");
            exit();
        } else {
            echo "<p style='color: red;'>Hibás felhasználónév vagy jelszó.</p>";
        }
    }
    ?>

<div>
    <div class="container">
        <h2>Bejelentkezés:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label>Felhasználó:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Jelszó:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Bejelentkezés</button>
        </div>
        <p>Még nincs fiókod? <a href="./regisztracio.php">Regisztrálj!</a></p>
    </form>
    </div>
    </div>
</body>
</html>
