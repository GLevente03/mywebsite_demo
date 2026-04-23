<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();

    $bill_number = $_POST["bill_number"];
    $amount = $_POST["amount"];
    $paid_at = $_POST["paid_at"];
    $description = $_POST["description"];
    $provider_id = $_POST["provider_id"];

    include __DIR__ . "/../../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Bill.php";
    include __DIR__ . "/BillController.php";

    $bill = new BillController(trim($bill_number), trim($amount), trim($description), trim($paid_at), $_SESSION["userid"], $provider_id);

    $bill->setBill();
    header("Location: /billregistry/view/billregistry.php?billsaved=true");

} else{
    header("Location: /billregistry/view/billregistry.php?directaccess=true");
    die();
}
