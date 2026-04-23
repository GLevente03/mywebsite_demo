<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $bill_number = $_POST['bill-number'];
    $from_date = $_POST['from-date'];
    $to_date = $_POST['to-date'];
    $provider_id = $_POST['provider_id'];

    session_start();
    include __DIR__ . "/../../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Search.php";
    include __DIR__ . "/SearchController.php";

    $entries = new SearchController($bill_number, $from_date, $to_date, $provider_id, "", $_SESSION["userid"]);
    $_SESSION["results"] = $entries->getBillEntries();
    header("Location: /billregistry/view/billregistry.php?searchsuccess=true");
} else{
    header("Location: /billregistry/view/billregistry.php");
    die();
}
