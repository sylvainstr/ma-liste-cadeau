<?php

namespace App\Controllers;

use App\Models\Event;
use App\Repository\EventRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;

class EventController extends CoreController
{
  /**
   * Renvoi les événements par utilisateurs
   *
   * @return void
   */
  public function browse()
  {
    if (!isset($_SESSION["user"])) {
      // si l'utilisateur n'est pas connecté on redirige vers la page d'acceuil
      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $userId = $_SESSION['user']['id'];

    $eventRepo = new EventRepository();
    $events = $eventRepo->findByUserId($userId);

    $this->render('event/list', [
      'events' => $events
    ]);
  }

  /**
   * Consulter un événement
   * 
   * @param int $eventId : id de la liste
   * @return void
   */
  public function read($eventId)
  {
    $eventRepo = new EventRepository();
    $eventById = $eventRepo->findOne($eventId);

    // l'id n'existe pas
    if (empty($eventById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $this->render('event/read', [
      'event_read' => $eventById
    ]);
  }


  /**
   * Ajouter une liste
   *
   * @return void
   */
  public function add()
  {
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['target_user']) && isset($_POST['created_by']) && isset($_POST['end_at'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $targetUser = $_POST['target_user'];
      $createdBy = $_POST['created_by'];
      $endAt = $_POST['end_at'];

      try {
        $newEvent = new Event($name, $description, $targetUser, $createdBy, $endAt);
        $eventRepo = new EventRepository();
        $eventRepo->save($newEvent);
      } catch (\Exception $exception) {
        var_dump($exception->getMessage());
      }

      FlashMessage::create_flash_message('event_add_success', 'Votre événement a été ajouté', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "evenements");
      exit;
    }

    $this->render('event/add');
  }

  /**
   * Modifier une liste
   *
   * @param int $eventId : id de la liste
   * @return void
   */
  public function edit($eventId)
  {
    $eventRepo = new EventRepository();
    $event = $eventRepo->findOne($eventId);

    if (!$event) {
      FlashMessage::create_flash_message('error', 'L\'événement n\'existe pas', 'FLASH_ERROR');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "evenements");
      exit;
    }

    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['target_user']) && isset($_POST['created_by']) && isset($_POST['end_at'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $targetUser = $_POST['target_user'];
      $createdBy = $_POST['created_by'];
      $endAt = $_POST['end_at'];

      try {
        $event->setName($name);
        $event->setDescription($description);
        $event->setTargetUser($targetUser);
        $event->setCreatedBy($createdBy);
        $event->setEndAt($endAt);

        $eventRepo->edit($event);
      } catch (\Exception $exception) {
        var_dump($exception->getMessage());
      }

      FlashMessage::create_flash_message('event_edit_success', 'Votre événement a été modifié', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "evenements");
      exit;
    }

    $this->render('event/edit', [
      'event_edit' => $event
    ]);
  }

  /**
   * Supprimer un événement
   *
   * @param int $eventId : id de l'événement
   * @return void
   */
  public function delete($eventId)
  {
    $deleteEvent = new EventRepository();
    $deleteEvent = $deleteEvent->delete($eventId);

    FlashMessage::create_flash_message('event_add_success', 'Votre événement a été supprimée', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "evenements");
    exit;
  }
}
