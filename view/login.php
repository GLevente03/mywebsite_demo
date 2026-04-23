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
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/signup.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <form action="/controller/login.contr.php" method="post">
        <input type="text" placeholder="Felhasználónév" name="user_name">
        <input type="password" placeholder="Jelszó" name="pwd">
        <button type="submit">Bejelentkezés</button>
    </form>
	<script src="scripts/change-lang.js"></script>
	<script src="scripts/hamburger-menu-toggle.js"></script>
</body>
</html>
