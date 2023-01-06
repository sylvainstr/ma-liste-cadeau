<?php

namespace App\Models;

use PDO;
use App\Models\Gift;
use App\Utils\Database;
use App\Models\CoreModel;

class Event extends CoreModel
{

  private $name;
  private $description;
  private $targetUser;
  private $createdAt;
  private $createdBy;
  private $updatedAt;
  private $endAt;

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
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

    /**
   * Get the value of targetUser
   */ 
  public function getTargetUser()
  {
    return $this->targetUser;
  }

  /**
   * Set the value of targetUser
   *
   * @return  self
   */ 
  public function setTargetUser($targetUser)
  {
    $this->targetUser = $targetUser;

    return $this;
  }

  /**
   * Get the value of createdAt
   */ 
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  /**
   * Set the value of createdAt
   *
   * @return  self
   */ 
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get the value of createdBy
   */ 
  public function getCreatedBy()
  {
    return $this->createdBy;
  }

  /**
   * Set the value of createdBy
   *
   * @return  self
   */ 
  public function setCreatedBy($createdBy)
  {
    $this->createdBy = $createdBy;

    return $this;
  }

  /**
   * Get the value of updatedAt
   */ 
  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  /**
   * Set the value of updatedAt
   *
   * @return  self
   */ 
  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * Get the value of endAt
   */ 
  public function getEndAt()
  {
    return $this->endAt;
  }

  /**
   * Set the value of endAt
   *
   * @return  self
   */ 
  public function setEndAt($endAt)
  {
    $this->endAt = $endAt;

    return $this;
  } 
  
  /**
   * Affiche le(s) cadeau(x) d'une liste
   *
   * @return array
   */
  public function getGifts(): array
  {
    $sql = "
    SELECT *
    FROM gift
    WHERE lists_id = " . $this->getId()
    ;
    
    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Gift::class);
    
    return $result;
  }
  
  /**
   * Affiche toutes les listes
   *
   * @return array
   */
  public function findAll(): array
  {
    $sql = '
    SELECT *
    FROM lists
    ';
    
    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);
    
    return $result;
  }
  
  /**
   * affiche les lites d'un utilisateur
   *
   * @param [int] $idUser : identifiant de l'utilisateur
   * @return array
   */
  public function findByUserId($idUser): array
  {
    $sql = "
    SELECT *
    FROM lists where user_id = '$idUser'
    ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);

    return $result;
  }

    /**
   * affiche les lites paratagées d'un utilisateur
   *
   * @param [int] $idList : identifiant de la liste
   * @return Lists
   */
  public function getFriendList($idList): Lists
  {
    $sql = "
    SELECT *
    FROM lists where id = '$idList'
    ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(Lists::class);

    return $result;
  }

  /**
   * Affiche une liste
   *
   * @param [int] $idList : identifiant d'une liste
   * @return Lists
   */
  public function findOne($idList): Lists
  {
    $sql = "
          SELECT *
          FROM lists where id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(Lists::class);

    $verif = $pdoStatement->rowCount();
    $badId = false;
    if ($verif <= 0) {
      $badId = true;
    }

    return $result;
  }

  /**
   * Ajout d'une liste
   *
   * @param [string] $event : événement de la liste
   * @param [string] $title : titre de la liste
   * @param [string] $subtitle : soustitre de la liste
   * @param [string] $message : message de la liste
   * @return void
   */
  public function addList($event, $title, $subtitle, $message)
  {
    $sql = "
          INSERT INTO lists (event, title, subtitle, message, user_id)
          VALUES ('$event', '$title', '$subtitle', '$message', " . $_SESSION["user"]["id"] . ")
      ";

    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }

  /**
   * Modification d'une liste
   *
   * @param [int] $idList : identifiant de la liste
   * @param [string] $event : événement de la liste
   * @param [string] $title : titre de la liste
   * @param [string] $subtitle : soustitre de la liste
   * @param [string] $message : message de la liste
   * @return void
   */
  public function editList($idList, $event, $title, $subtitle, $message)
  {
    $sql = "
          UPDATE lists set
          event = '$event',
          title = '$title',
          subtitle = '$subtitle',
          message = '$message',
          updated_at = NOW()
          where id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  /**
   * Suppression d'une liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return void
   */
  public function deleteList($idList)
  {
    $sql = "
          DELETE from lists where id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }
}
