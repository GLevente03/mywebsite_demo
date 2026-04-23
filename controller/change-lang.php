<?php
header("Content-Type: application/json");

// JSON bemenet beolvasása
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    session_start();
    $lang = $data['lang'];

    $_SESSION['lang'] = $lang;
    echo json_encode(["status" => "success", "message" => "Adat fogadva", "receivedData" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => "Hibás vagy hiányzó adat"]);
}