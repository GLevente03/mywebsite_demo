<?php
class Search extends DatabaseConnection{
    protected function fetchBillEntries($bill_number, $from_date, $to_date, $provider_id, $userId){
        $conditions = [];
        $params = [];

        if (!empty($bill_number)) {
            $conditions[] = "bills.bill_number LIKE :bill_number";
            $params[':bill_number'] = "%".$bill_number."%";
        }

        if (!empty($from_date)) {
            $conditions[] = "bills.paid_at >= :from_date";
            $params[':from_date'] = $from_date;
        }

        if (!empty($to_date)) {
            $conditions[] = "bills.paid_at <= :to_date";
            $params[':to_date'] = $to_date;
        }

        if (!empty($provider_id)) {
            $conditions[] = "bills.provider_id = :provider_id";
            $params[':provider_id'] = $provider_id;
        }

        $params[':user_id'] = $userId;

        $query = "SELECT bills.*, providers.provider_name FROM bills INNER JOIN providers ON bills.provider_id = providers.id";
        if(!empty($conditions)){
            $query .= " WHERE " . implode(" AND ", $conditions) . " AND bills.user_id = :user_id;";
        }
        
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute($params)){
            $stmt = null;
            header("Location: /billregistry/view/billregistry.php?error=stmtfailed");
            exit();
        }
        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else{
            $results = false;
        }
        $stmt = null;

        return $results;
    }

    protected function eraseBill($id, $user_id){
        $query = "DELETE FROM bills WHERE id = :id AND user_id = :user_id;";

        $stmt = $this->connect()->prepare($query);
        $params[':id'] = $id;
        $params[':user_id'] = $user_id;
        if(!$stmt->execute($params)){
            $stmt = null;
            header("Location: /billregistry/view/billregistry.php?error=stmtfailed");
            exit();
        }

    }
}
