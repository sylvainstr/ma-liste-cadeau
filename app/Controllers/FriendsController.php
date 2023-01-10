<?php

namespace App\Controllers;

use App\Models\Friends;
use App\Repository\FriendsRepository;
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

      // je récupére l'utilisateur corrrespondant à l'email
      $userRepo = new UserRepository();
      $newFriend = $userRepo->findByEmail($email);

      $friendId = $newFriend->getId();
      $alreadyFriend = new FriendsRepository();
      $alreadyFriend = $alreadyFriend->searchUserFriends($friendId);

      // si l'utilisateur n'existe pas en BDD
      if (!$newFriend) {
        FlashMessage::create_flash_message('error', 'Cet utilisateur n\'existe pas', 'FLASH_ERROR');
        die("Cet utilisateur n'existe pas");
      }
      // L'utilisateur ne peut pas se partager sa propre liste
      elseif ($email == $_SESSION["user"]['email']) {
        FlashMessage::create_flash_message('error', 'Vous ne pouvez pas vous ajouter vous même en ami', 'FLASH_ERROR');
        die('Vous ne pouvez pas vous ajouter vous même en ami');
      }
      // si l'utilisateur existe déjà en BDD
      elseif ($alreadyFriend) {
        FlashMessage::create_flash_message('error', 'Cet utilisateur fait déjà parti de vos amis', 'FLASH_ERROR');
        die('Cet utilisateur fait déjà parti de vos amis');
      }

      $friend = new FriendsRepository();
      $friend = $friend->addFriend($friendId);

      FlashMessage::create_flash_message('list_add_success', 'Votre ami a été ajouté', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "liste");
      exit;
    }

    $this->render('friends/invit-friend');
  }

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
   * Supprime un utilisateur de la liste
   *
   * @param int $userId : id de l'utilisateur
   * @return void
   */
  public function deleteFriend($userId)
  {
    $deleteFriend = new FriendsRepository();
    $deleteFriend = $deleteFriend->deleteFriend($userId);

    FlashMessage::create_flash_message('list_add_success', 'L\' utilisateur a été supprimé de votre liste', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "liste");
    exit;
  }

}
