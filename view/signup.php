<?php
    session_start();
    if (!isset($_SESSION['lang']) && isset($_COOKIE['lang'])) {
        $_SESSION['lang'] = $_COOKIE['lang'];
    }
    
    $lang = $_SESSION['lang'] ?? 'en';
    
    $translations = require __DIR__ . "/lang/{$lang}.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="styles/signup.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <form action="/controller/signup.contr.php" method="post">
        <input type="text" placeholder="Teljes név" name="full_name" value="<?php if(isset($_SESSION["full_name"])){ echo htmlspecialchars($_SESSION["user_name"]); } ?>">
        <input type="text" placeholder="Felhasználónév" name="user_name" value="<?php if(isset($_SESSION["user_name"])){ echo htmlspecialchars($_SESSION["user_name"]); } ?>">
        <input type="email" placeholder="Email" name="email" value="<?php if(isset($_SESSION["email"])){ echo htmlspecialchars($_SESSION["email"]); } ?>">
        <input type="password" name="pwd" placeholder="Jelszó">
        <input type="password" name="pwd_again" placeholder="Jelszó mégegyszer">
        <button type="submit">Regisztrálok</button>
    </form>
    <div class="feedback-msg">
        <?php
            if($_GET["error"] == "emptyinput"){
                echo '<p class="error">Töltsön ki minden mezőt!</p>';
                session_destroy();
            }
            if($_GET["error"] == "invalidemail"){
                echo '<p class="error">Érvénytelen e-mail formátum!</p>';
                session_destroy();
            }
            if($_GET["error"] == "passwordsnotmatch"){
                echo '<p class="error">A jelszók nem egyeznek!</p>';
                session_destroy();
            }
            if($_GET["error"] == "unameoremailtaken"){
                echo '<p class="error">Ezt a felhasználónevet vagy e-mail címet már regisztrálták!</p>';
                session_destroy();
            }
        ?>
    </div>
	<script src="scripts/change-lang.js"></script>
	<script src="scripts/hamburger-menu-toggle.js"></script>
</body>
</html>
