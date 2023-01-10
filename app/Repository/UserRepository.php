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
}
