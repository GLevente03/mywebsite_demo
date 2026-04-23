<?php
session_start();
class Search extends DatabaseConnection{

    protected function fetchUsers($userName){
        $query = "SELECT id, username, full_name, admin, latitude, longitude, location_updated_at FROM users WHERE LOWER(username) LIKE LOWER(CONCAT('%', ?, '%'));";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$userName])){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch from database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function insertFriendRequest($senderId, $receiverId){
        $query = "INSERT INTO friends (sender_id, receiver_id) VALUES (?, ?);";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$senderId, $receiverId])){
            $stmt = null;
            throw new StatementFailedException("Failed to insert into database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return true;
    }

    protected function fetchFriendRequests($sender_id, $accepted){
        $query = "SELECT receiver_id, sent_at FROM friends WHERE sender_id = ? AND accepted = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$sender_id, $accepted])){
            $stmt = null;
            throw new StatementFailedException("Failed to insert into database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function deleteFriend($sender_id, $receiver_id, $accepted){
        $query = "DELETE FROM friends WHERE sender_id = ? AND receiver_id = ? AND accepted = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$sender_id, $receiver_id, $accepted])){
            $stmt = null;
            throw new StatementFailedException("Failed to insert into database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return true;
    }

    protected function friendRequests($user_id){
        $query = "SELECT sender_id, receiver_id, accepted, sent_at FROM friends WHERE sender_id = ? OR receiver_id = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$user_id, $user_id])){
            $stmt = null;
            throw new StatementFailedException("Failed to fetch from database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function updateFriendRequest($sender_id, $receiver_id){
        $query = "UPDATE friends SET accepted = 1 WHERE sender_id = ? AND receiver_id = ?;";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute([$sender_id, $receiver_id])){
            $stmt = null;
            throw new StatementFailedException("Failed to insert into database");
            //header("Location: ../view/dashboard.php?error=stmtfailed");
            exit();
        }
        return true;
    }
}