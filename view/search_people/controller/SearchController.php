<?php
class SearchController extends Search{
    private $userName;
    private $senderId;
    private $receiverId;
    private $accepted;

    public function __construct($userName, $senderId = null, $receiverId = null, $accepted = null){
        $this->userName = $userName;
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
        $this->accepted = $accepted;
    }

    public function getUsers(){
        return $this->fetchUsers($this->userName);
    }

    public function setFriendRequest(){
        return $this->insertFriendRequest($this->senderId, $this->receiverId);
    }

    public function getFriendRequests(){
        return $this->fetchFriendRequests($this->senderId, $this->accepted);
    }

    public function removeFriend(){
        return $this->deleteFriend($this->senderId, $this->receiverId, $this->accepted);
    }

    public function allFriendRequests(){
        return $this->friendRequests($this->senderId);
    }

    public function acceptFriendRequest(){
        return $this->updateFriendRequest($this->senderId, $this->receiverId);
    }
}