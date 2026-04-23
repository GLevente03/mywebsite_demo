<?php
class DatabaseCommunication extends DatabaseConnection{
    function insert($query, ...$params){
        $conn = $this->connect();
    
        $stmt = $conn->prepare($query);
    
        foreach ($params as $param) {
            if(empty($param)){
                throw new EmptyInputException("Empty input field");
            }
        }
    
        if(!$stmt->execute($params)){
            throw new StatementFailedException("Failed to insert into database");
        }
    
        return $conn->lastInsertId();
    }

    function select($query, ...$params){
        $conn = $this->connect();
    
        $stmt = $conn->prepare($query);
    
        foreach ($params as $param) {
            if(empty($param)){
                throw new EmptyInputException("Empty input field");
            }
        }
    
        if(!$stmt->execute($params)){
            throw new StatementFailedException("Failed to insert into database");
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function update($query, ...$params){
        $conn = $this->connect();
    
        $stmt = $conn->prepare($query);
    
        foreach ($params as $param) {
            if(empty($param)){
                throw new EmptyInputException("Empty input field");
            }
        }
    
        if(!$stmt->execute($params)){
            throw new StatementFailedException("Failed to insert into database");
        }
    
        return true;
    }
}