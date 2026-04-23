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
            $activities = $selection->select('SELECT a.trip_id, a.name, a.date_from, a.date_to, a.notes, a.longitude, a.latitude, a.color, a.system_image, u.full_name AS "added_by_name" FROM activity a JOIN users u ON a.added_by = u.id WHERE a.trip_id = ?;', $trip_id);
            echo json_encode(["activities" => $activities]);
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