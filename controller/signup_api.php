<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $apiKey = "Dhf63HFI72cq954ysgWbvc943DJSW";
    $receivedApiKey = $data["api_key"];

    if($receivedApiKey == $apiKey){
        $full_name = $data["full_name"];
        $user_name = $data["user_name"];
        $email = $data["email"];
        $pwd = $data["pwd"];
        $pwd_again = $data["pwd_again"];

        include __DIR__ . "/../model/DatabaseConnection.php";
        include __DIR__ . "/../model/Signup.php";
        include __DIR__ . "/../model/SignupController.php";
        include "Exception.php";

        $newUser = new SignupController($full_name, $user_name, $email, $pwd, $pwd_again);

        try {
            $newUser->signUpUser();
            echo json_encode(["code" => "200", "success" => true]);
            exit();
        } catch(StatementFailedException $e){
            echo json_encode(["code" => "500", "success" => false, "message" => $e->getMessage()]);
		http_response_code(500);
            exit();
        }catch(EmptyInputException $e){
            echo json_encode(["code" => "400", "success" => false, "message" => $e->getMessage()]);
		http_response_code(400);
            exit();
        }catch(InvalidEmailFormatException $e){
            echo json_encode(["code" => "400", "success" => false, "message" => $e->getMessage()]);
		http_response_code(400);
            exit();
        }catch(WrongPasswordFormatException $e){
            echo json_encode(["code" => "400", "success" => false, "message" => $e->getMessage()]);
		http_response_code(400);
            exit();
        }catch(PasswordsDontMatchException $e){
            echo json_encode(["code" => "400", "success" => false, "message" => $e->getMessage()]);
		http_response_code(400);
            exit();
        }catch(UsernameOrEmailTakenException $e){
            echo json_encode(["code" => "409", "success" => false, "message" => $e->getMessage()]);
		http_response_code(409);
            exit();
        }catch(TooManyRegistrationAttemptsException $e){
            echo json_encode(["code" => "429", "success" => false, "message" => $e->getMessage()]);
		http_response_code(429);
            exit();
        }
        
    }else{
        echo json_encode(["code" => "401", "success" => false, "message" => "Invalid or missing API key. Please provide a valid key."]);
	http_response_code(401);
    }
}else{
    echo json_encode(["code" => "405", "success" => false, "message" => "This endpoint only supports POST requests."]);
	http_response_code(405);
}
