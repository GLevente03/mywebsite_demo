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
        $longitude = $data["longitude"];
        $latitude = $data["latitude"];
        $location_updated_at = $data["location_updated_at"];

        $updateStatement = new DatabaseCommunication();

        try{
            $success = $updateStatement->update("UPDATE users SET latitude = ?, longitude = ?, location_updated_at = ? WHERE id = ?", $latitude, $longitude, $location_updated_at, $user_id);
            echo json_encode(["success" => $success, "message" => "Successfully updated user's location."]);
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