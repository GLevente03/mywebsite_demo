<?php
class BillController extends Bill{
    private $bill_number;
    private $amount;
    private $description;
    private $paid_at;
    private $user_id;
    private $provider_id;

    public function __construct($bill_number, $amount, $description, $paid_at, $user_id, $provider_id)
    {
        $this->bill_number = $bill_number;
        $this->amount = $amount;
        $this->description = $description;
        $this->paid_at = $paid_at;
        $this->user_id = $user_id;
        $this->provider_id = $provider_id;
    }
    public function setBill(){
        if($this->emptyInput()){
            session_start();
            $_SESSION["bill_number"] = $this->bill_number;
            $_SESSION["amount"] = $this->amount;
            if(!empty($this->description)){
                $_SESSION["description"] = $this->description;
            }
            $_SESSION["paid_at"] = $this->paid_at;
            header("Location: /billregistry/view/billregistry.php?error=emptybillinput");
            exit();
        }

        if(!$this->checkBillNumber($this->bill_number, $this->user_id)){
            header("Location: /billregistry/view/billregistry.php?error=alreadyregistered");
            exit();
        }

        if(!$this->checkProviderValidity($this->user_id)){
            header("Location: /billregistry/view/billregistry.php?error=unknownprovider");
            exit();
        }

        $this->saveBill($this->bill_number, $this->amount, $this->description, $this->paid_at, $this->user_id, $this->provider_id);
    }

    private function emptyInput(){
        if (empty($this->bill_number) || empty($this->amount) || empty($this->paid_at) || empty($this->user_id) || empty($this->provider_id)) {
            return true;
        }
        return false;
    }

    private function checkProviderValidity($user_id){
        $providers = $this->getProviders($user_id);
        for($i = 0; $i < count($providers); $i++){
            if($this->provider_id == $providers[$i]["id"]){
                return true;
            }
        }
        return false;
    }
}
