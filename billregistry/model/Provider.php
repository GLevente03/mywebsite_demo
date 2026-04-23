<?php
class Provider extends DatabaseConnection{
   
   protected function saveProvider($name, $accountNumber, $providerType, $telephone, $userId){
        $query = "INSERT INTO providers (provider_name, account_number, provider_type, telephone, user_id) VALUES (?, ?, ?, ?, ?);";

        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$name, $accountNumber, $providerType, $telephone, $userId])){
            $stmt = null;
            header("Location: /billregistry/view/billregistry.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
   }

   protected function checkProvider($name, $accountNumber, $telephone, $uid){
        $query = "SELECT provider_name FROM providers WHERE (provider_name = ? OR account_number = ? OR telephone = ?) AND user_id = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$name, $accountNumber, $telephone, $uid])){
            $stmt = null;
            header("Location: /billregistry/view/billregistry.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() > 0){
            return false;
        }else{
            return true;
        }
        $stmt = null;
   }
}
