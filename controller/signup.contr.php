<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $full_name = $_POST["full_name"];
    $user_name = $_POST["user_name"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwd_again = $_POST["pwd_again"];

    include __DIR__ . "/../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Signup.php";
    include __DIR__ . "/../model/SignupController.php";
	include "Exception.php";

	$newUser = new SignupController($full_name, $user_name, $email, $pwd, $pwd_again);
    try{
        $newUser->signUpUser();
        header("Location: /signup.php?error=none");
        exit();
    }catch(StatementFailedException $e){
        header("Location: /signup.php?error=stmtfailed");
        exit();
    }catch(EmptyInputException $e){
        header("Location: /signup.php?error=emptyinput");
        exit();
    }catch(InvalidEmailFormatException $e){
        header("Location: /signup.php?error=invalidemailformat");
        exit();
    }catch(WrongPasswordFormatException $e){
        header("Location: /signup.php?error=wrongpwdformat");
        exit();
    }catch(PasswordsDontMatchException $e){
        header("Location: /signup.php?error=passwordsnotmatch");
        exit();
    }catch(UsernameOrEmailTakenException $e){
        header("Location: /signup.php?error=unameoremailtaken");
        exit();
    }catch(TooManyRegistrationAttemptsException $e){
        header("Location: /signup.php?error=toomanyregistrationsattempts");
        exit();
    }
}else{
    header("Location: /signup.php");
	http_response_code(405);
    die();
}
