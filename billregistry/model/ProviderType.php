<?php
class ProviderType extends DatabaseConnection
{
    public function getProvidersByUser($userId)
    {
        $sql = "SELECT id, provider_name FROM providers WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}