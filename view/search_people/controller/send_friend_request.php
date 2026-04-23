<?php
header("Content-type: application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){

    include_once __DIR__ . "/../../../model/DatabaseConnection.php";
    include_once __DIR__ . "/../model/Search.php";
    include_once __DIR__ . "/../../../controller/Exception.php";
    include_once "SearchController.php";

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if($data){
        try {
            $sender_id = $data['sender_id'];
            $receiver_id= $data['receiver_id'];
            $userController = new SearchController(null, $sender_id, $receiver_id);
            $status = $userController->setFriendRequest();
            echo json_encode(["success" => $status, "message" => "Adat fogadva"]);
        } catch (StatementFailedException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
            http_response_code(400);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Hibás vagy hiányzó adat"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Only POST method allowed"]);
    http_response_code(405);
}