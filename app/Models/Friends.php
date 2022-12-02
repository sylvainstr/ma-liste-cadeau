<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Friends
{
  private $email;
  private $user_id;
  private $lists_id;

  public function __toString()
  {
    return $this->email;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUserId(int $user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of lists_id
   */
  public function getListsId()
  {
    return $this->lists_id;
  }

  /**
   * Set the value of lists_id
   *
   * @return  self
   */
  public function setListsId(int $lists_id)
  {
    $this->lists_id = $lists_id;

    return $this;
  }

  /**
   * Affiche tous les utilisateurs d'une liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return array
   */
  public function findShareLists($userId): array
  {
    $sql = "
    SELECT *
    FROM share_lists
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
  public function inviteFriend($email, $friendId, $idList)
  {
    $sql = "
          INSERT INTO share_lists (email, user_id, lists_id)
          VALUES ('$email', '$friendId', '$idList')
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
