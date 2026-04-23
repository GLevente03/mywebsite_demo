<?php

class Signup extends DatabaseConnection{

    protected function setUser($full_name ,$username, $pwd, $email, $ip_address){
        $token = bin2hex(random_bytes(32));
        $query = "INSERT INTO users (full_name, username, pwd, email, ip_address, verification_token) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($query);

        $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);

        if(!$stmt->execute([$full_name, $username, $hashed_pwd, $email, $ip_address, $token])){
            $stmt = null;
            throw new StatementFailedException("Failed to insert user credentials into database");
            exit();
        }
        $stmt = null;
        return $token;
    }

    protected function checkUser($username, $email){
        $stmt = $this->connect()->prepare("SELECT username FROM users WHERE username = ? OR email = ?;");

        if(!$stmt->execute([$username, $email])){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch username or email from database");
            exit();
        }

        if($stmt->rowCount() > 0){
            return false;
        }else{
            return true;
        }
    }

    protected function getAllRegisteredIP(){
        $stmt = $this->connect()->prepare("SELECT ip_address FROM users;");
        
        if(!$stmt->execute()){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch IP address from database");
            exit();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function verifyUserByToken($token) {
        $sql = "SELECT id FROM users WHERE verification_token = :token AND is_verified = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch();
        if ($user) {
            $sql = "UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            return $stmt->execute([':id' => $user['id']]);
        }
        return false;
    }

    protected function deleteOldUnverifiedUsers() {
        $sql = "DELETE FROM users WHERE is_verified = 0 AND created_at < (NOW() - INTERVAL 24 HOUR)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }
}
