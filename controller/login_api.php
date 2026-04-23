<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $apiKey = "Dhf63HFI72cq954ysgWbvc943DJSW";
    $receivedApiKey = $data["api_key"];

    if($receivedApiKey == $apiKey){
        $user_name = $data["user_name"];
        $pwd = $data["pwd"];

        include __DIR__ . "/../model/DatabaseConnection.php";
        include __DIR__ . "/Login.php";
        include __DIR__ . "/LoginController.php";
        include "Exception.php";

        $userController = new LoginController($user_name, $pwd);

    try {
        $user = $userController->loginUser();

        echo json_encode(["id" => $user[0]["id"], "username" => $user[0]["username"], "full_name" => $user[0]["full_name"], "admin" => $user[0]["admin"], "longitude" => $user[0]["longitude"], "latitude" => $user[0]["latitude"], "location_updated_at" => $user[0]["location_updated_at"]]);
        exit();
    } catch (StatementFailedException $e) {
        echo json_encode(["code" => "500", "type" => "stmtfailed", "message" => $e->getMessage()]);
	    http_response_code(500);
        exit();
    } catch (UserNotFoundException $e){
        echo json_encode(["code" => "401", "type" => "usernotfound", "message" => $e->getMessage()]);
	    http_response_code(401);
        exit();
    } catch (WrongPasswordException $e){
        echo json_encode(["code" => "401", "type" => "wrongpwd", "message" => $e->getMessage()]);
	    http_response_code(401);
        exit();
    } catch (EmptyInputException $e){
        echo json_encode(["code" => "400", "type" => "emptyinput", "message" => $e->getMessage()]);
	    http_response_code(400);
        exit();
    }
        
    }else{
        echo json_encode(["code" => "401", "type" => "invalid_api_key", "message" => "Invalid or missing API key. Please provide a valid key."]);
	    http_response_code(401);
    }
}else{
    echo json_encode(["code" => "405", "type" => "method_not_allowed", "message" => "This endpoint only supports POST requests."]);
	http_response_code(405);
}
