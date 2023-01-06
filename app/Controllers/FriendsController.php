<?php

namespace App\Controllers;

use App\Models\Friends;
use App\Models\Event;
use App\Models\User;
use App\Repository\UserRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;

class FriendsController extends CoreController
{

  /**
   * invite un utilisateur à ma liste d'amis
   *
   * @param [int] $idList : identifiant de l'événement
   * @return void
   */
  public function invit()
  {
    if (isset($_POST['email'])) {

      $email = $_POST['email'];

      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        FlashMessage::create_flash_message('error', "Ce n'est pas un email", 'FLASH_ERROR');
        die("Ce n'est pas un email");
      }

      $userRepo = new UserRepository();
      $newFriend = $userRepo->findByEmail($email);

      $alreadyFriend = new UserRepository();
      $alreadyFriend = $alreadyFriend->searchUserFriends($email);

      // si l'utilisateur n'existe pas en BDD
      if (!$newFriend) {
        FlashMessage::create_flash_message('error', 'Cette utilisateur n\'existe pas', 'FLASH_ERROR');
        die("Cette utilisateur n'existe pas");
      }
      // L'utilisateur ne peut pas se partager sa propre liste
      elseif ($email == $_SESSION["user"]['email']) {
        FlashMessage::create_flash_message('error', 'Vous avez déjà accés à cette liste', 'FLASH_ERROR');
        die("Vous avez déjà accés à cette liste");
      }
      // si l'utilisateur existe déjà en BDD
      elseif ($alreadyFriend) {
        FlashMessage::create_flash_message('error', 'Cette utilisateur a déjà accés à cette liste', 'FLASH_ERROR');
        die("Cette utilisateur a déjà accés à cette liste");
      }

      $friendId = $newFriend->getId();
      $friend = new Friends();
      $friend = $friend->inviteFriend($friendId);

      FlashMessage::create_flash_message('list_add_success', 'L\'utilisateur ami a été ajoutée à votre liste', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "liste/");
      exit;
    }

    $this->render('list/invit-friend');
  }

  /**
   * Renvoi les utilisateurs d'un événement
   *
   * @return void
   */
  public function browse($idEvent)
  {

    $friends = new Friends();
    $friends = $friends->findShareEvents($idEvent);

    $this->render('event/friends', [
      'friends' => $friends,
      'event_id' => $idEvent
    ]);
  }


  /**
   * Supprime un utilisateur de la liste
   *
   * @param int $idList : id de la liste
   * @param int $idList : id de l'utilisateur
   * @return void
   */
  public function deleteFriend($idList, $idFriend)
  {
    $deleteFriend = new Friends();
    $deleteFriend = $deleteFriend->deleteFriend($idFriend);

    FlashMessage::create_flash_message('list_add_success', 'L\' utilisateur a été supprimé de votre liste', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "liste/" . $idList);
    exit;
  }

  /**
   * Supprime tout les utilisateurs de la liste
   *
   * @param int $idList : id de la liste
   * @return void
   */
  public function deleteAllFriends($idList)
  {
    $deleteFriends = new Friends();
    $deleteFriends = $deleteFriends->deleteAllFriends($idList);

    FlashMessage::create_flash_message('list_add_success', 'Les utilisateurs ont été supprimé de votre liste', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "liste/" . $idList);
    exit;
  }
}
