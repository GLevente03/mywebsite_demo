<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    include __DIR__ . "/../model/DatabaseConnection.php";
	include __DIR__ . "/Login.php";
	include __DIR__ . "/LoginController.php";
	include "Exception.php";

    $userController = new LoginController($user_name, $pwd);

    try {
        $user = $userController->loginUser();

        session_start();
        $_SESSION["userid"] = $user[0]["id"];
        $_SESSION["username"] = $user[0]["username"];
        $_SESSION["fullName"] = $user[0]["full_name"];
        $_SESSION["admin"] = $user[0]["admin"];
        
        header("Location: /index.php?error=none");
        exit();
    } catch (StatementFailedException $e) {
        header("Location: /signup.php?error=stmtfailed");
        exit();
    } catch (UserNotFoundException $e){
        header("Location: /login.php?error=usernotfound");
        exit();
    } catch (WrongPasswordException $e){
        header("Location: /login.php?error=wrongpwd");
        exit();
    } catch (EmptyInputException $e){
        header("Location: /login.php?error=emptyinput");
        exit();
    }
}else{
    header("Location: /login.php?error=accessdenied");
    die();
}
