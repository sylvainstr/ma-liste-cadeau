<?php

namespace App\Repository;

use PDO;
use App\Models\User;
use App\Utils\Database;
use Exception;

class UserRepository
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getPDO();
  }

  /**
   * Ajout d'un utilisateur
   *
   * @param [string] $user : nom de l'utilisateur
   * @return void
   */
  public function add($user)
  {

    $sql = "
          INSERT INTO user (name, email, password, role)
          VALUES ('" . $user->getName() . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "', '[\"ROLE_USER\"]')
      ";

    $this->pdo->exec($sql);
  }

  /**
   * Affiche l'utilisateur correspondant à l'email
   *
   * @param [string] $email
   * @return User
   */
  public function findByEmail($email)
  {
    $sql = "
          SELECT * FROM user
          WHERE email = '$email'         
      ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['name', 'email', 'password']);
    $user = $pdoStatement->fetch();

    return $user;
  }

  /**
   * Affiche l'utilisateur correspondant à l'id
   *
   * @param [int] $id
   * @return User
   */
  public function findOne($id)
  {
    $sql = "
          SELECT * FROM user
          WHERE id = '$id'         
      ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['name', 'email', 'password']);
    $user = $pdoStatement->fetch();

    return $user;
  }

  /**
   * cherche mes amis par le eventId
   *
   * @param [int] $eventId : identifiant de l'événement
   * @return void
   */
  public function findFriendsByEventId($eventId)
  {
    $sql = "
          SELECT user.*
          FROM user_event
          INNER JOIN user ON user_event.user_id = user.id
          WHERE event_id = '$eventId'
      ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['name', 'email', 'password']);
    $result = $pdoStatement->fetchAll();

    return $result;
  }


  /**
   * Recherche un utilisateur
   * 
   * @param [string] $searchUsers : résultat de la recherche
   * @return
   */
  public function searchUsers($searchUsers)
  {
    $friendsRepo = new FriendsRepository();
    $friendsId = $friendsRepo->getFriendsIdByUserId($_SESSION['user']['id']);

    $sql = "
            SELECT id, email, name, password
            FROM user            
            WHERE id IN (" . implode(",", $friendsId) . ") AND 
            name LIKE CONCAT('%', :searchUsers, '%')
            OR email LIKE CONCAT('%', :searchUsers, '%')
          ";

    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('userId', $_SESSION['user']['id']);
    $pdoStatement->bindValue('searchUsers', $searchUsers, PDO::PARAM_STR);

    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['name', 'email', 'password']);
    $pdoStatement->execute();
    $users = $pdoStatement->fetchAll();

    return $users;
  }

  /**
   * Ajouter un utilisateur à un événement
   * 
   * @param [int] $eventId : identifiant de l'événement
   * @param [int] $userId : identifiant de l'utilisateur
   * @return void
   */
  public function addUserOfEvent($eventId, $userId)
  {
    $sql = "
            INSERT INTO user_event (
              user_id,
              event_id
            )
            VALUES (
              :user_id,
              :event_id
            )
          ";
          
    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('user_id', $userId);
    $pdoStatement->bindValue('event_id', $eventId);

    $result = $pdoStatement->execute();
    
    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }

    return $result;
  }

  /**
   * Supprimer un utilisateur d'un événement
   * 
   * @param [int] $eventId : identifiant de l'utilisateur
   * @param [int] $userId : identifiant de l'utilisateur
   * @return void
   */
  public function deleteUserOfEvent($userId, $eventId)
  {
    $sql = "
            DELETE FROM user_event
            WHERE user_id = '$userId'
            AND event_id = '$eventId'
          ";

    return $this->pdo->query($sql);
  }
}
