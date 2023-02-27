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
    $eventsShare = $eventRepo->findByShareUserId($userId);

    $this->render('event/list', [
      'events' => $events,
      'events_share' => $eventsShare
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
    $gifts = $giftRepo->findByUserId($eventById->getTargetUser());

    $alreadyOffer = [];

    foreach ($gifts as $gift) {
      $alreadyOffer[$gift->getId()] = $giftRepo->isAlreadyTaken($eventId, $gift->getId());
    }

    $this->render('event/read', [
      'event_read' => $eventById,
      'gifts' => $gifts,
      'target_user' => $targetUser,
      'users_event' => $usersEvent,
      'already_offer' => $alreadyOffer
    ]);
  }


  public function offer($eventId, $giftId)
  {
    $eventRepo = new EventRepository();
    $eventById = $eventRepo->findOne($eventId);

    $name = $eventById->getName();
    $description = $eventById->getDescription();
    $targetUser = $eventById->getTargetUser();
    $createdBy = $eventById->getCreatedBy();
    $endAt = $eventById->getEndAt();

    $event = new Event($name, $description, $targetUser, $createdBy, $endAt);

    $giftRepo = new GiftRepository();

    if (!$giftRepo->isAlreadyTaken($eventId, $giftId)) {

      $giftOffer = $giftRepo->giftOffer($event, $eventId, $giftId, $_SESSION['user']['id']);
      FlashMessage::create_flash_message('buy_gift_success', 'Ce cadeau a bien été offert', 'FLASH_SUCCESS');
    } else {
      FlashMessage::create_flash_message('buy_gift_error', 'Ce cadeau a déjà été offert', 'FLASH_ERROR');
    }

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "evenements/" . $eventId);
    exit;
  }

  /**
   * Ajouter une événement
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
        // ajoute celui qui crée l'annonce dans la liste des invités
        $result = $userRepo->addUserOfEvent($idEvent, $createdBy);

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
   * Modifier une événement
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
   * Rechercher un ami
   *
   * @param string $searchUsers : recherche de l'utilisateur
   * @return
   */
  public function searchFriendEvent($searchUsers)
  {

    $userRepo = new UserRepository();
    $users = $userRepo->searchUsers($searchUsers);

    $usersList = [];

    foreach ($users as $user) {
      $usersList[] = [
        'id' => $user->getId(),
        'email' => $user->getEmail(),
        'name' => $user->getName()
      ];
    }

    header('Content-Type: application/json; charset=utf-8');
   
    echo json_encode($usersList);
  }

  /**
   * Ajouter un ami à l'événement
   *
   * @param int $eventId : id de l'événement
   * @param int $userId : id de l'utilisateur
   * @return
   */
  public function addFriendEvent($eventId, $userId)
  {

    $userRepo = new UserRepository();

    $alreadyInvit = $userRepo->isInvit($eventId, $userId);

    if ($alreadyInvit) {
      return Response::send(400, null, "Votre ami a déjà été ajouté à l'événement");
    } else {
      
      $result = $userRepo->addUserOfEvent($eventId, $userId);

      
      if (!$result) {
        return Response::send(400, 'Votre ami n\'a pas pu être ajouté à l\'événement');
      } else {
        
        $user = $userRepo->findOne($userId);

        http_response_code(200);
        header('Content-Type: application/json');

        echo     json_encode([
          'id' => $user->getId(),
          'name' => $user->getName()
        ]);
      }
    }
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
