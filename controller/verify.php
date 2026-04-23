<?php
include __DIR__ . "/../model/DatabaseConnection.php";
include __DIR__ . "/../model/Signup.php";
include __DIR__ . "/../model/SignupController.php";

$token = $_GET['token'] ?? '';
$new_user = new SignupController(null, null, null, null, null, $token);
$status = $new_user->verify_token();
if($status == 1){
    echo "Sikeres azonosítás!";
}else{
    echo "Sikertelen azonosítás! :(";
}
