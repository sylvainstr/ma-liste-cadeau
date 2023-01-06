<?php

namespace App\Repository;

use PDO;
use App\Models\User;
use App\Utils\Database;

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
   * affiche les cadeaux d'un utilisateur
   *
   * @param [int] $userId : identifiant de l'utilisateur
   * @return array
   */
  public function findByUserId($userId)
  {
    $sql = "
    SELECT *
    FROM gift where user_id = '$userId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class, ['name', 'email', 'password']);
    $result = $pdoStatement->fetch();

    return $result;
  }

  /**
   * Affiche l'utilisateur correspondant à l'email de la table friends
   *
   * @param [string] $email : email de l'utilisateur
   * @return void
   */
  public function searchUserFriends($email)
  {
    $sql = "
          SELECT * FROM friends
          WHERE email = '$email'        
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $this->pdo->query($sql);
    $result = $pdoStatement->fetchObject(User::class);

    return $result;
  }
}
