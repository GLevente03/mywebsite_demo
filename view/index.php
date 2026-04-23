<?php
    session_start();
    if (!isset($_SESSION['lang']) && isset($_COOKIE['lang'])) {
        $_SESSION['lang'] = $_COOKIE['lang'];
    }
    
    $lang = $_SESSION['lang'] ?? 'en';
    
    $translations = require __DIR__ . "/lang/{$lang}.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levi around the world</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <div class="grand-canyon-profile">
        <img src="images/grand-canyon-profile.jpeg" alt="I'm standing on a rock in the Grand Canyon.">
    </div>
    <div class="welcome-text">
        <p><?php echo $translations['welcome']; ?></p>
    </div>
    <script src="scripts/change-lang.js"></script>
	<script src="scripts/hamburger-menu-toggle.js"></script>
</body>
</html>
