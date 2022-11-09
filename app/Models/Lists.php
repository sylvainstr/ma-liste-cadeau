<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Lists extends CoreModel
{

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

}