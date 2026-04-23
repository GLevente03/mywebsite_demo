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
        $name = $data["name"];
        $date_from = $data["date_from"];
        $date_to = $data["date_to"];
        $trip_id = $data["trip_id"];
        $notes = $data["notes"];
        $added_by = $data["added_by"];
        $longitude = $data["longitude"];
        $latitude = $data["latitude"];
        $color = $data["color"];
        $system_image = $data["system_image"];

        $insertion = new DatabaseCommunication();

        try{
            $trip_id = $insertion->insert("INSERT INTO activity (trip_id, name, date_from, date_to, notes, added_by, longitude, latitude, color, system_image	
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $trip_id, $name, $date_from, $date_to, $notes, $added_by, $longitude, $latitude, $color, $system_image);
            echo json_encode(["success" => true, "message" => "Trip successfully added."]);
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