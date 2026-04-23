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
            $userName = $data['user_name'];
            $userController = new SearchController($userName);
            $usersFound = $userController->getUsers();
            echo json_encode(["success" => true, "message" => "Adat fogadva", "users" => $usersFound]);
        } catch (StatementFailedException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
            http_response_code(500);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Hibás vagy hiányzó adat"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "code" =>"405", "message" => "This endpoint only supports POST requests."]);
    http_response_code(405);
}

