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

  public function findById($id): array
  {
    $sql = "
          SELECT *
          FROM lists where user_id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);

    return $result;
  }

  public function findOne($id)
  {
    $sql = "
          SELECT *
          FROM lists where id = '$id'
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

  public function addList($event, $title, $subtitle, $message)
  {
    $sql = "
          INSERT INTO lists (event, title, subtitle, message, user_id)
          VALUES ('$event', '$title', '$subtitle', '$message', " . $_SESSION["user"]["id"] . ")
      ";

    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }

  public function editList($id, $event, $title, $subtitle, $message)
  {
    $sql = "
          UPDATE lists set
          event = '$event',
          title = '$title',
          subtitle = '$subtitle',
          message = '$message',
          updated_at = NOW()
          where id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  public function deleteList($id)
  {
    $sql = "
          DELETE from lists where id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }
}
