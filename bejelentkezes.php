<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
</head>
<body>
    <?php
    session_start();

    // Adatok validalasa
    function validateUser($username, $password) {
        $users = json_decode(file_get_contents('felhasznalok.json'), true);

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

    <h2>Bejelentkezés</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label>Felhasználónév:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Jelszó:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Bejelentkezés</button>
        </div>
    </form>
</body>
</html>
