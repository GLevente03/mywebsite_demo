<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class SignupController extends Signup{
    private $full_name;
    private $user_name;
    private $email;
    private $pwd;
    private $pwd_again;
    private $token;
    private $translations;
    private $lang;

    public function __construct($full_name ,$user_name, $email, $pwd, $pwd_again, $token=null){
        session_start();

        if (!isset($_SESSION['lang']) && isset($_COOKIE['lang'])) {
            $_SESSION['lang'] = $_COOKIE['lang'];
        }

        $this->lang = $_SESSION['lang'] ?? 'en';
        $this->translations = require __DIR__ . "/lang/{$this->lang}.php";

        $this->full_name = $full_name;
        $this->user_name = $user_name;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwd_again = $pwd_again;
        $this->token = $token;
    }

    public function signUpUser(){
        session_start();
        if($this->emptyInput() == true){
            $_SESSION["full_name"] = $this->full_name;
            $_SESSION["user_name"] = $this->user_name;
            $_SESSION["email"] = $this->email;
            throw new EmptyInputException("Empty input");
            exit();
        }

        if($this->invalidEmail() == true){
            $_SESSION["user_name"] = $this->user_name;
            throw new InvalidEmailFormatException("Invalid e-mail format");
            exit();
        }

        if(!$this->checkPassword($this->pwd)){
            $_SESSION["user_name"] = $this->user_name;
            $_SESSION["email"] = $this->email;
            throw new WrongPasswordFormatException("Wrong password format: password must be at least 8 characters long, it must contain at least one special character, one number and one uppercase letter");
            exit();
        }

        if($this->passwordMatch() == false){
            $_SESSION["user_name"] = $this->user_name;
            $_SESSION["email"] = $this->email;
            throw new PasswordsDontMatchException("Passwords don't match.");
            exit();
        }

        if($this->usernameOrEmailTaken() == true){
            throw new UsernameOrEmailTakenException("Username or e-mail taken.");
            exit();
        }

        if($this->checkNumberOfAccountsRegisterredByIP() >= 6){
            throw new TooManyRegistrationAttemptsException("Too many registration attempts from the same IP address.");
            exit();
        }

        $token =  $this->setUser($this->full_name ,$this->user_name, $this->pwd, $this->email, $this->getIPaddress());
	$mail = new PHPMailer(true);
	$mailBody = '
		<!DOCTYPE html>
		<html lang="'.$this->lang.'">
		<head>
    			<meta charset="UTF-8">
    			<title>Regisztráció megerősítése</title>
		</head>
		<body style="background: linear-gradient(to top, #30cfd0 0%, #330867 100%); height: 100vh; background-repeat: no-repeat; align-items: center; padding: 20px;">
    			<div style="background-color: white; border-radius: 10px; padding: 5px; text-align: center; width:max-content;">
        			<img src="https://gasparlevente.com/images/logo.png" alt="Levi around the world logo" style="width: 300px;">
    			</div>
			 <h1 style="color: white; font-family: Arial, Helvetica, sans-serif;">'.$this->translations["greeting"].' '.$this->full_name.'!</h1>
   		 	 <h2 style="color: white; font-family: Arial, Helvetica, sans-serif;">'.$this->translations["thanks"].'</h2>
   		 	 <p style="color: white; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">'.$this->translations["click"].'</p>
   			 <p style="color: white; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">'.$this->translations["ignore"].'</p>
   			 <p style="color: white; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">'.$this->translations["validity"].'</p>
   			 <p style="color: white; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">'.$this->translations["dontreply"].'</p>
   			 <a href="https://gasparlevente.com/controller/verify.php?token='.$token.'" style="display: inline-block; border: none; border-radius: 30px; padding: 10px; color: #330867; font-weight: bold; width: 200px; font-size: 25px; background-color: white; text-align: center; margin-top: 50px; text-decoration: none;">'.$this->translations["confirm"].'</a>
		</body>
		</html>';
	try {
   		 // SMTP beállítás
   		 $mail->isSMTP();
		 $mail->CharSet    = 'UTF-8';
   		 $mail->Host       = 'smtp.gmail.com';
   		 $mail->SMTPAuth   = true;
   		 $mail->Username   = '';
   		 $mail->Password   = '';
   		 $mail->SMTPSecure = 'tls';
		 $mail->Port       = 587;

   		 // Feladó és címzett
   		 $mail->setFrom('gasparlevente@gasparlevente.com', 'Levi around the world');
   		 $mail->addAddress($this->email, $this->full_name);

   		 // Tartalom
   		 $mail->isHTML(true);
   		 $mail->Subject = $this->translations["subject"];
   		 $mail->Body    = $mailBody;
   		 $mail->AltBody = "Az alábbi linkre kattintva vagy a böngésző címsorába beillesztve erősítsd meg a regisztrációd!\nhttps://gasparlevente.com/controller/verify.php?token='.$token.'";

   		 $mail->send();
	} catch (Exception $e) {
   		 echo "Hiba történt: {$mail->ErrorInfo}";
	}

    }

    public function verify_token(){
        return $this->verifyUserByToken($this->token);
    }

    public function cleanDatabaseFromOldUnverifiedUsers(){
        $this->deleteOldUnverifiedUsers();
    }

    private function emptyInput(){
        if (empty($this->full_name) || empty($this->user_name) || empty($this->email) || empty($this->pwd) || empty($this->pwd_again)) {
            return true;
        }
        return false;
    }

    private function invalidEmail(){
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    private function passwordMatch(){
        if($this->pwd !== $this->pwd_again){
            return false;
        }
        return true;
    }

    private function usernameOrEmailTaken(){
        if(!$this->checkUser($this->user_name, $this->email)){
            return true;
        }
        return false;
    }

    private function getIPaddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP passed from proxy
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ipList[0]); // Az első a valódi IP lehet
        } else {
            // Alapértelmezett IP
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function checkNumberOfAccountsRegisterredByIP(){
        $IPs = $this->getAllRegisteredIP();
        $arrayLength = count($IPs);
        $IPcount = 0;
        for($i = 0; $i < $arrayLength; $i++){
            $fetchedIP = $IPs[$i]["ip_address"];
            $userIP = $this->getIPaddress();
            if($fetchedIP == $userIP){
                $IPcount++;
            }
        }
        return $IPcount;
    }

    private function checkPassword($pwd){
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pwd);
    }
}
