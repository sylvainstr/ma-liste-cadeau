<?php

namespace App\Controllers;

use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;

class FriendsController extends CoreController
{

  /**
   * Renvoi les utilisateurs d'un événement
   *
   * @return void
   */
  public function browse()
  {

    $friends = new FriendsRepository();
    $userId = $_SESSION['user']['id'];
    $friends = $friends->findFriendsByUserId($userId);

    $this->render('friends/list', [
      'friends' => $friends
    ]);
  }

  /**
   * invite un utilisateur à ma liste d'amis
   *
   * @return void
   */
  public function invit()
  {
    if (isset($_POST['email'])) {

      $email = $_POST['email'];

      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        FlashMessage::create_flash_message('error', "Ce n'est pas un email", 'FLASH_ERROR');
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl" . "amis/invitation");
      }

      // je récupére l'utilisateur correspondant à l'email
      $userRepo = new UserRepository();
      $newFriend = $userRepo->findByEmail($email);

      // si l'utilisateur n'existe pas en BDD
      if (!$newFriend) {
        FlashMessage::create_flash_message('error', 'Cet utilisateur n\'existe pas', 'FLASH_ERROR');
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl" . "amis/invitation");
      }
      // L'utilisateur ne peut pas se partager sa propre liste
      elseif ($email == $_SESSION["user"]['email']) {
        FlashMessage::create_flash_message('error', 'Vous ne pouvez pas vous ajouter vous même en ami', 'FLASH_ERROR');
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl" . "amis/invitation");
        exit;
      }

      $friendId = $newFriend->getId();
      $alreadyFriend = new FriendsRepository();
      $alreadyFriend = $alreadyFriend->searchUserFriends($friendId);

      // si l'utilisateur existe déjà en BDD
      if (!$alreadyFriend) {
        FlashMessage::create_flash_message('error', 'Cet utilisateur fait déjà parti de vos amis', 'FLASH_ERROR');
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl" . "amis/invitation");
        exit;
      }

      $friend = new FriendsRepository();
      $friend = $friend->addFriend($friendId);

      FlashMessage::create_flash_message('friend_add_success', 'Votre ami a été ajouté', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "amis");
      exit;
    }

    $this->render('friends/invit-friend');
  }



  /**
   * Supprime un utilisateur de la liste
   *
   * @param int $userId : id de l'utilisateur
   * @return void
   */
  public function deleteFriend($userId)
  {
    $deleteFriend = new FriendsRepository();
    $deleteFriend = $deleteFriend->deleteFriend($userId);

    FlashMessage::create_flash_message('friend_add_success', 'L\' utilisateur a été supprimé de vos amis', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "amis");
    exit;
  }
}
