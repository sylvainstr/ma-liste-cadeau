<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class User extends CoreModel
{

  private $email;
  private $password;
  private $name;
  private $role;


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
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of name
   */ 
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */ 
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

    /**
   * Get the value of role
   */ 
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @return  self
   */ 
  public function setRole($role)
  {
    $this->role = $role;

    return $this;
  }

  /**
   * Ajout d'un utilisateur
   *
   * @param [string] $name : nom de l'utilisateur
   * @param [string] $email : email de l'utilisateur
   * @param [string] $password : mot de passe de l'utilisateur
   * @param [string] $role : role de l'utilisateur
   * @return void
   */
  public function addUser($name, $email, $password)
  {
    $sql = "
          INSERT INTO user (name, email, password, role)
          VALUES ('$name', '$email', '$password', '[\"ROLE_USER\"]')
      ";

    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }

  /**
   * Affiche l'utilisateur correspondant à l'email
   *
   * @param [string] $email
   * @return void
   */
  public function searchUser($email)
  {
    $sql = "
          SELECT * FROM user
          WHERE email = '$email'         
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(User::class);
    
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
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(User::class);
    
    return $result;
  }

}