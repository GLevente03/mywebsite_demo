<?php
header("Content-Type: application/json");

// JSON bemenet beolvasása
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $bill_id = $data['bill_id'];

    session_start();
    include __DIR__ . "/../../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Search.php";
    include __DIR__ . "/SearchController.php";

    $bill = new SearchController("", "", "", "", $bill_id, $_SESSION["userid"]);
    $bill->deleteBill();

    echo json_encode(["status" => "success", "message" => "Adat fogadva", "receivedData" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => "Hibás vagy hiányzó adat"]);
}
