<?php
class Bill extends DatabaseConnection{
    protected function saveBill($bill_number, $amount, $description, $paid_at, $user_id, $provider_id){
        $query = "INSERT INTO bills (bill_number, amount, description, paid_at, user_id, provider_id) VALUES (?,?,?,?,?,?);";

        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$bill_number, $amount, $description, $paid_at, $user_id, $provider_id])){
            $stmt = null;
            header("Location: /billregistry/view/billregistry.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }

    protected function checkBillNumber($bill_number, $user_id){
        $query = "SELECT bill_number FROM bills WHERE bill_number = ? AND user_id = ?;";
        $stmt = $this->connect()->prepare($query);
        if(!$stmt->execute([$bill_number, $user_id])){
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

    protected function getProviders($user_id){
        $sql = "SELECT id, provider_name FROM providers WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
