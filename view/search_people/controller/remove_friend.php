<?php
header("Content-type: application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    include_once __DIR__ . "/../../../model/DatabaseConnection.php";
    include_once __DIR__ . "/../model/Search.php";
    include_once __DIR__ . "/../../../controller/Exception.php";
    include_once "SearchController.php";

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $api_key = "Dhf63HFI72cq954ysgWbvc943DJSW";

    if($data){
        $received_api_key = $data['api_key'];
        if($received_api_key == $api_key){
            try {
                $sender_id = (int)$data['sender_id'];
                $receiver_id = (int)$data['receiver_id'];
                $accepted= (int)$data['accepted'];
                $userController = new SearchController(null, $sender_id, $receiver_id , $accepted);
                $success = $userController->removeFriend();
                echo json_encode(["success" => $success, "message" => "Friend/Request successfully deleted."]);
            } catch (StatementFailedException $e) {
                echo json_encode(["code" => "400", "type" => "stmt_failed", "message" => $e->getMessage()]);
                http_response_code(400);
            }
        }else{
            echo json_encode(["code" => "401", "type" => "invalid_api_key", "message" => "Invalid or missing API key. Please provide a valid key."]);
	        http_response_code(401);
        }
    }else{
        echo json_encode(["code" => "400", "type" => "wrong_or_missing_data", "message" => "Hibás vagy hiányzó adat"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["code" => "405", "type" => "method_not_allowed", "message" => "Only POST method allowed"]);
    http_response_code(405);
}