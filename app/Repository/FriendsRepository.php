<?php

namespace App\Repository;

use PDO;
use App\Utils\Database;
use App\Models\Friends;
use App\Models\User;
use Exception;

class FriendsRepository
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getPDO();
  }

  /**
   * Affiche l'utilisateur correspondant au user_id de la table friends
   *
   * @param [string] $userId : identifiant de l'utilisateur
   * @return void
   */
  public function searchUserFriends($userId)
  {
    $sql = "
          SELECT * FROM friends
          WHERE user_id = '$userId'
      ";

    $pdoStatement = $this->pdo->query($sql);
    $result = $pdoStatement->fetchObject(Friends::class);

    return $result;
  }

  /**
   * Affiche tous mes amis
   *
   * @param [int] $userId : identifiant de l'utilisateur
   * @return array
   */
  public function findFriendsByUserId($userId): array
  {
    $sql = "
          SELECT friends.friend_id
          FROM friends
          WHERE friends.user_id = '$userId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $usersId1 = $pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);

    $sql = "
    SELECT friends.user_id
    FROM friends
    WHERE friends.friend_id = '$userId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $usersId2 = $pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);

    $usersId = array_merge($usersId1, $usersId2);

    $sql = "
          SELECT *
          FROM user
          WHERE id IN (" . implode(",", $usersId) . ")
      ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['email', 'password', 'name', 'role']);
    $result = $pdoStatement->fetchAll();

    return $result;
  }

  /**
   * Ajoute un ami
   *
   * @param [int] $userId : identifiant de l'utilisateur à ajouter
   * @return void
   */
  public function addFriend($friendId)
  {
    $sql = "
          INSERT INTO friends (user_id, friend_id)
          VALUES (:user_id, :friend_id)
      ";

    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('user_id', $_SESSION['user']['id']);
    $pdoStatement->bindValue('friend_id', $friendId);

    $result = $pdoStatement->execute();
    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }
  }


  /**
   * Supprime un ami de ma liste
   *
   * @param [int] $friendId : identifiant de l'utilisateur
   * @return void
   */
  public function deleteFriend($friendId)
  {
    $sql = "
          DELETE from friends where user_id = '" . $_SESSION['user']['id'] . "' AND friend_id = '$friendId'
      ";

    $this->pdo->query($sql);
  }
}
