<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class User extends CoreModel
{

  private $email;
  private $password;
  private $name;


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

  public function addUser($name, $email, $password)
  {
    $sql = "
          INSERT INTO user (name, email, password)
          VALUES ('$name', '$email', '$password')
      ";

    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }

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
}