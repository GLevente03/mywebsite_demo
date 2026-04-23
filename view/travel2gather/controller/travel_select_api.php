<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once __DIR__ . "/../../../model/DatabaseConnection.php";
    include_once __DIR__ . "/../model/DatabaseCommunication.php";
    include_once __DIR__ . "/../../../controller/Exception.php";

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $apiKey = "";
    $receivedApiKey = $data["api_key"];

    if($receivedApiKey == $apiKey){
        $user_id = $data["user_id"];

        $selection = new DatabaseCommunication();

        try{
            $trips = $selection->select("SELECT t.id, t.name, t.date_from, t.date_to FROM trip t JOIN trip_user tu ON t.id = tu.trip_id WHERE tu.user_id = ?;", $user_id);
            echo json_encode(["trips" => $trips]);
            exit();
        }catch(StatementFailedException $e){
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
            http_response_code(400);
            exit();
        }catch(EmptyInputException $e){
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
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