<?php
    session_start();
    if (!isset($_SESSION["userid"])) {
        header("Location: login.php?error=accessdenied");
        exit();
    }

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
    <title>Profilom</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <div style="margin-top: 70px;">Welcome <?php echo htmlspecialchars($_SESSION["fullName"]); ?>!</div>
    <a href="/billregistry/view/billregistry.php">Számlanyilvántartó rendszer</a>
    <?php if($_SESSION["admin"] == true){ ?>
        <a href="/smart_home/view/dashboard.php">Okos otthon vezérlő</a>
    <?php } ?>
	<script src="scripts/hamburger-menu-toggle.js"></script>
	<script src="scripts/change-lang.js"></script>
</body>
</html>
