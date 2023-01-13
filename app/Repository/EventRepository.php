<?php

namespace App\Repository;

use PDO;
use App\Utils\Database;
use App\Models\Event;
use Exception;

class EventRepository
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getPDO();
  }

  /**
   * affiche les événements d'un utilisateur
   *
   * @param [int] $userId : identifiant de l'utilisateur
   * @return array
   */
  public function findByUserId($userId): array
  {
    $sql = "
    SELECT *
    FROM event where created_by = '$userId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Event::class, ['name', 'description', 'target_user', 'created_by', 'end_at']);
    $result = $pdoStatement->fetchAll();

    return $result;
  }

  /**
   * Affiche un événement
   *
   * @param [int] $eventId : identifiant d'un événement
   * @return void
   */
  public function findOne($eventId)
  {
    $sql = "
          SELECT *
          FROM event where id = '$eventId'
      ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Event::class, ['name', 'description', 'target_user', 'created_by', 'end_at']);
    $result = $pdoStatement->fetch();

    return $result;
  }

  /**
   * Ajout d'une événement
   *
   * @param [string] $event : différents champs du cadeau
   * @return void
   */
  public function save($event)
  {
    $sql = "
            INSERT INTO event (
              name,
              description,
              target_user,
              created_at,
              created_by,
              updated_at, 
              end_at
            )
            VALUES (
              :name,
              :description,
              :target_user,
              NOW(),
              :created_by,
              NOW(),
              :end_at
              )
           ";

    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('name', $event->getName());
    $pdoStatement->bindValue('description', $event->getDescription());
    $pdoStatement->bindValue('target_user', $event->getTargetUser());
    $pdoStatement->bindValue('created_by', $_SESSION['user']['id']);
    $pdoStatement->bindValue('end_at', $event->getEndAt());

    $result = $pdoStatement->execute();
    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }
  }

  /**
   * Modification d'un événement
   *
   * @param [string] $gift : différents champs de l'événement
   * @return void
   */
  public function edit($event)
  {
    $sql = "
            UPDATE event SET 
              name = :name,
              description = :description,
              target_user = :target_user,
              created_by = :created_by,
              updated_at = NOW(),
              end_at = :end_at
            WHERE 
              id = :id
          ";


    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('name', $event->getName());
    $pdoStatement->bindValue('description', $event->getDescription());
    $pdoStatement->bindValue('target_user', $event->getTargetUser());
    $pdoStatement->bindValue('created_by', $event->getCreatedBy());
    $pdoStatement->bindValue('end_at', $event->getEndAt());
    $pdoStatement->bindValue('id', $event->getId());

    $result = $pdoStatement->execute();

    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }
  }

  /**
   * Suppression d'un événement
   *
   * @param [int] $eventId : identifiant de l'événement
   * @return void
   */
  public function delete($eventId)
  {
    $sql = "
          DELETE from event where id = '$eventId'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  /**
   * affiche les événements paratagées d'un utilisateur
   *
   * @param [int] $eventId : identifiant de l'événement
   * @return Event
   */
  public function getFriendEvent($eventId): Event
  {
    $sql = "
    SELECT *
    FROM event where id = '$eventId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $result = $pdoStatement->fetchObject(Event::class);

    return $result;
  }
}
