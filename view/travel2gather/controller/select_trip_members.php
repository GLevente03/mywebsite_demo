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
        $trip_id = $data["trip_id"];

        $selection = new DatabaseCommunication();

        try{
            $users = $selection->select('SELECT users.id, username, full_name, admin, latitude, longitude, location_updated_at FROM users JOIN trip_user ON users.id = trip_user.user_id WHERE trip_user.trip_id = ?;', $trip_id);
            echo json_encode(["success" => true, "message" => "Users successfully fetched.", "users" => $users]);
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