<?php

namespace App\Controllers;

use App\Models\Event;
use App\Repository\EventRepository;
use App\Repository\FriendsRepository;
use App\Repository\GiftRepository;
use App\Repository\UserRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;
use App\Utils\Response;

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
   * @param int $eventId : id de l'événement
   * @return void
   */
  public function read($eventId)
  {
    $eventRepo = new EventRepository();
    $eventById = $eventRepo->findOne($eventId);

    $userRepo = new UserRepository();
    $targetUser = $userRepo->findOne($eventById->getTargetUser());

    // l'id n'existe pas
    if (empty($eventById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $usersEvent = $userRepo->findFriendsByEventId($eventId);

    $giftRepo = new GiftRepository();
    $gifts = $giftRepo->findByEventId($eventId);

    $this->render('event/read', [
      'event_read' => $eventById,
      'gifts' => $gifts,
      'target_user' => $targetUser,
      'users_event' => $usersEvent
    ]);
  }

  /**
   * Ajouter une liste
   *
   * @return void
   */
  public function add()
  {
    if (
      isset($_POST['name']) &&
      isset($_POST['description']) &&
      isset($_POST['target_user']) &&
      isset($_POST['invit-friend']) &&
      isset($_POST['end_at'])
    ) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $targetUser = $_POST['target_user'];
      $invitFriends = $_POST['invit-friend'];
      $createdBy = $_SESSION['user']['id'];
      $endAt = $_POST['end_at'];


      try {
        $newEvent = new Event($name, $description, $targetUser, $createdBy, $endAt);
        $eventRepo = new EventRepository();
        $idEvent = $eventRepo->save($newEvent);
        $newEvent->setId($idEvent);

        // enregistrement des invités
        $userRepo = new UserRepository();

        foreach ($invitFriends as $friendId) {
          $user = $userRepo->findOne($friendId);

          if ($user) {
            $eventRepo->addFriend($newEvent, $user);
          }
        }
      } catch (\Exception $exception) {
        var_dump($exception->getMessage());
      }

      FlashMessage::create_flash_message('event_add_success', 'Votre événement a été ajouté', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "evenements");
      exit;
    }

    $userId = $_SESSION['user']['id'];

    $friendRepo = new FriendsRepository();
    $friends = $friendRepo->findFriendsByUserId($userId);

    $this->render('event/add', [
      'friends' => $friends
    ]);
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

    if (
      isset($_POST['name']) &&
      isset($_POST['description']) &&
      isset($_POST['target_user']) &&
      isset($_POST['invit-friend']) &&
      isset($_POST['end_at'])
    ) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $targetUser = $_POST['target_user'];
      $invitFriends = $_POST['invit-friend'];
      $createdBy = $_SESSION['user']['id'];
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

    $userId = $_SESSION['user']['id'];

    $friendRepo = new FriendsRepository();
    $friends = $friendRepo->findFriendsByUserId($userId);

    $this->render('event/edit', [
      'event_edit' => $event,
      'friends' => $friends
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

    FlashMessage::create_flash_message('event_delete_success', 'Votre événement a été supprimée', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "evenements");
    exit;
  }

  /**
   * ajouter un ami à l'événement
   *
   * @param int $eventId : id de l'événement
   * @return void
   */
  public function addFriendEvent($eventId, $userId)
  {
    $userRepo = new UserRepository();
    $newUser = $userRepo->addUserOfEvent($eventId, $userId);

    if (!$newUser) {
      return Response::send(400, 'Votre ami n\'a pas pu être ajouté de l\'événement');
    }

    return Response::send(200);
  }

  /**
   * Supprime un ami de l'événement
   *
   * @param int $eventId : id de l'événement
   * @return void
   */
  public function deleteFriendEvent($eventId, $userId)
  {
    $userRepo = new UserRepository();
    $result = $userRepo->deleteUserOfEvent($userId, $eventId);

    if (!$result) {
      return Response::send(400, 'Votre ami n\'a pas pu être supprimé de l\'événement');
    }
    
    return Response::send(200);
  }
}
