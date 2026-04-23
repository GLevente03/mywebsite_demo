<?php

class Login extends DatabaseConnection{
    protected function getUser($username, $pwd){
        $query = "SELECT pwd FROM users WHERE username = ? OR email = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$username, $username])){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch username or email from database");
            exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            throw new UserNotFoundException("User not found");
            exit();
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $passwordsMatch = password_verify($pwd, $pwdHashed[0]["pwd"]);

        if(!$passwordsMatch){
            $stmt = null;
            throw new WrongPasswordException("Wrong password");
            exit();
        }else{
            $query = "SELECT * FROM users WHERE username = ? OR email = ? AND pwd = ?;";
            $stmt = $this->connect()->prepare($query);

            if(!$stmt->execute([$username, $username, $pwd])){
                $stmt = null;
                throw new StatementFailedException("Failed to fetch password from database");
                exit();
            }

            if($stmt->rowCount() == 0){
                $stmt = null;
                throw new UserNotFoundException("User not found");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        }
    }

    protected function fetchUserById($user_id){
        $query = "SELECT * FROM users WHERE id = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$user_id])){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch from database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
