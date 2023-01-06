<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

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

  /**
   * Affiche tous les utilisateurs d'une liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return array
   */
  public function findShareEvents($userId): array
  {
    $sql = "
    SELECT *
    FROM friends
    WHERE user_id = '$userId'
    ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Friends::class);

    return $result;
  }

  /**
   * Ajoute un invité à une liste
   *
   * @param [string] $email : email de l'inviter
   * @param [int] $friendId : identifiant de l'utilisateut à ajouter
   * @param [int] $idList : identifiant de la liste
   * @return void
   */
  public function inviteFriend($friendId)
  {
    $sql = "
          INSERT INTO share_lists (user_id)
          VALUES ('$friendId')
      ";
    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }


  /**
   * Supprime un utilisateur de la liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return void
   */
  public function deleteFriend($idFriend)
  {
    $sql = "
          DELETE from share_lists where user_id = '$idFriend'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  /**
   * Supprime tout les utilisateurs de la liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return void
   */
  public function deleteAllFriends($idList)
  {
    $sql = "
          DELETE from share_lists where lists_id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

}
