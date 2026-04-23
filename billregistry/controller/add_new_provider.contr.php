<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();

    $provider_name = $_POST["provider_name"];
    $provider_account_number = $_POST["provider_account_number"];
    $provider_type = $_POST["provider_type"];
    $telephone = $_POST["telephone"];

    include __DIR__ . "/../../model/DatabaseConnection.php";
    include __DIR__ . "/../model/Provider.php";
    include __DIR__ . "/ProviderController.php";

    $provider = new ProviderController(trim($provider_name), trim($provider_account_number), trim($provider_type), trim($telephone), $_SESSION["userid"]);

    $provider->setProvider();
    header("Location: /billregistry/view/billregistry.php?providersaved=true");

} else{
    header("Location: /billregistry/view/billregistry.php?directaccess=true");
    die();
}
