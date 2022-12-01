<?php

namespace App\Controllers;

use App\Models\Friends;
use App\Models\Lists;
use App\Models\User;
use App\Utils\Config;
use App\Utils\FlashMessage;

class FriendsController extends CoreController
{

  /**
   * Renvoi les utilisateurs d'une liste
   *
   * @return void
   */
  public function browse($idList)
  {

    $friends = new Friends();
    $friends = $friends->findAllFriends($idList);

    $this->render('list/friends', [
      'friends' => $friends,
      'list_id' => $idList
    ]);
  }


  /**
   * Ajoute un utilisateur à ma liste
   *
   * @param [int] $idList : identifiant de la liste
   * @return void
   */
  public function addFriend($idList)
  {
    if (isset($_POST['email'])) {

      $email = $_POST['email'];

      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Ce n'est pas un email");
      }


      $newFriend = new User();
      $newFriend = $newFriend->searchUser($email);

      $alreadyFriend = new User();
      $alreadyFriend = $alreadyFriend->searchUserFriends($email);

      // si l'utilisateur n'existe pas en BDD
      if (!$newFriend) {
        die("Cette utilisateur n'existe pas");
      }
      // L'utilisateur ne peut pas se partager sa propre liste
      elseif ($email == $_SESSION["user"]['email']) {
        die("Vous avez déjà accés à cette liste");
      } 
      // si l'utilisateur existe déjà en BDD
      elseif ($alreadyFriend) {
        die("Cette utilisateur a déjà accés à cette liste");
      }


      /** @var User */
      $newFriend = $newFriend;

      $friendId = $newFriend->getId();
      $friend = new Friends();
      $friend = $friend->inviteFriend($email, $friendId, $idList);

      FlashMessage::create_flash_message('list_add_success', 'L\'utilisateur ami a été ajoutée à votre liste', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "liste/" . $idList);
      exit;
    }

    $lists = new Lists();
    $listId = $lists->findOne($idList);

    $this->render('list/add-friend', [
      'list_id' => $listId
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
