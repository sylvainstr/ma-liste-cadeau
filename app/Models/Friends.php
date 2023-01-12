<?php

namespace App\Models;

class Friends
{
  private $userId;
  private $friendId;

  /**
   * Get the value of userId
   */ 
  public function getUserId()
  {
    return $this->userId;
  }

  /**
   * Set the value of userId
   *
   * @return  self
   */ 
  public function setUserId($userId)
  {
    $this->userId = $userId;

    return $this;
  }

  /**
   * Get the value of friendId
   */ 
  public function getFriendId()
  {
    return $this->friendId;
  }

  /**
   * Set the value of friendId
   *
   * @return  self
   */ 
  public function setFriendId($friendId)
  {
    $this->friendId = $friendId;

    return $this;
  } 
}
