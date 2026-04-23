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
    <title>Levi around the world</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>

    <style>
        .maintenance-container{
            font-family: Arial, Helvetica, sans-serif;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            row-gap: 15px;
        }
        h1{
            font-size: 35px;
        }
        h2{
            font-size: 25px;
        }
    </style>
</head>
<body style="display: flex; align-items:center; justify-content:center">
    <?php
        include_once "header.php";
    ?>
    <div class="maintenance-container">
        <h1>This section of the website is currently under maintenance</h1>
        <h2>Please, look back later!</h2>
        <img style="height:300px;" src="images/maintenance.png" alt="Website is under maintenance.">
    </div>
	<script src="scripts/hamburger-menu-toggle.js"></script>
</body>
</html>
