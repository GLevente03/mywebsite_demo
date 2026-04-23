<?php
    include __DIR__ . "/../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Signup.php";
    include __DIR__ . "/../model/SignupController.php";

    $users = new SignupController(null, null, null, null, null);
    $users->cleanDatabaseFromOldUnverifiedUsers();
