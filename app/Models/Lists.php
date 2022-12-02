<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Lists extends CoreModel
{

  static public $eventsType = [
    'anniversaire' => 'Anniversaire',
    'naissance' => 'Naissance',
    'mariage' => 'Mariage',
    'noël' => 'Noël'
  ];

  private $event;
  private $title;
  private $subtitle;
  private $message;


  /**
   * Get the value of event
   */
  public function getEvent()
  {
    return $this->event;
  }

  /**
   * Set the value of event
   *
   * @return  self
   */
  public function setEvent($event)
  {
    $this->event = $event;

    return $this;
  }

  /**
   * Get the value of title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of subtitle
   */
  public function getSubtitle()
  {
    return $this->subtitle;
  }
  
  /**
   * Set the value of subtitle
   *
   * @return  self
   */
  public function setSubtitle($subtitle)
  {
    $this->subtitle = $subtitle;
    
    return $this;
  }
  
  /**
   * Get the value of message
   */
  public function getMessage()
  {
    return $this->message;
  }
  
  /**
   * Set the value of message
   *
   * @return  self
   */
  public function setMessage($message)
  {
    $this->message = $message;
    
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
