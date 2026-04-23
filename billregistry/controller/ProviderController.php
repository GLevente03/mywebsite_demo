<?php
class ProviderController extends Provider{
    private $name;
    private $accountNumber;
    private $providerType;
    private $telephone;
    private $uid;

    public function __construct($name, $accountNumber, $providerType, $telephone, $uid)
    {
        $this->name = $name;
        $this->accountNumber = $accountNumber;
        $this->providerType = $providerType;
        $this->telephone = $telephone;
        $this->uid = $uid;
    }

    public function setProvider(){
        if($this->emptyInput() == true){
            $_SESSION["provider_name"] = $this->name;
            $_SESSION["provider_account_number"] = $this->accountNumber;
            $_SESSION["provider_type"] = $this->providerType;
            $_SESSION["telephone"] = $this->telephone;
            header("Location: /billregistry/view/billregistry.php?error=emptyinput");
            exit();
        }

        if(!$this->checkProvider($this->name, $this->accountNumber, $this->telephone, $this->uid)){
            header("Location: /billregistry/view/billregistry.php?error=alreadyregistered");
            exit();
        }

        if($this->checkWrongAccountNumberFormat() == true){
            header("Location: /billregistry/view/billregistry.php?error=wrongaccountnumberformat");
            exit();
        }

        if($this->checkProviderTypeOptions() == false){
            header("Location: /billregistry/view/billregistry.php?error=nothingselected");
            exit();
        }
        $this->saveProvider($this->name, $this->accountNumber, $this->providerType, $this->telephone, $this->uid);
    }

    private function emptyInput(){
        if (empty($this->name) || empty($this->accountNumber) || empty($this->providerType) || empty($this->telephone)) {
            return true;
        }
        return false;
    }

    private function checkWrongAccountNumberFormat(){
        if(!preg_match('/[0-9]{8}-[0-9]{8}-[0-9]{8}/', $this->accountNumber)){
            return true;
        }
        return false;
    }

    private function checkProviderTypeOptions(){
        if(isset($this->providerType) && !empty($this->providerType)){
            $valid_options = ['water', 'gas', 'electricity', 'phone', 'sewer', 'garbage', 'else'];
            if(in_array($this->providerType, $valid_options)){
                return true;
            }
        }
        return false;
    }
}
