<?php

namespace App\Controllers;

use App\Models\Friends;
use App\Models\Event;
use App\Utils\Config;
use App\Utils\FlashMessage;

class EventController extends CoreController
{
  /**
   * Renvoi les listes par utilisateurs
   *
   * @return void
   */
  public function browse()
  {
    $userId = $_SESSION['user']['id'];

    $lists = new Event();
    $lists = $lists->findByUserId($userId);

    $friend = new Friends();
    $shareLists = $friend->findShareLists($userId);

    $friendList = new Event();

    $arrayList = [];

    foreach ($shareLists as $shareList) {
      $arrayList[]= $friendList->getFriendList($shareList->getListsId());
    }

    $this->render('list/list', [
      'lists' => $lists,
      'friend_lists' => $arrayList
    ]);
  }

  /**
   * Consultation de la liste par l'id
   *
   * @param int $idList : id de la liste
   * @return void
   */
  public function read($idList)
  {
    $friends = new Friends();
    $friends = $friends->findShareLists($idList);

    $lists = new Event();
    $listById = $lists->findOne($idList);

    // l'id n'existe pas
    if (empty($listById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $gifts = $listById->getGifts();

    $this->render('list/read', [
      'list_read' => $listById,
      'gifts' => $gifts,
      'friends' => $friends
    ]);
  }

  /**
   * Ajouter une liste
   *
   * @return void
   */
  public function add()
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $newList = new Event();
      $newList = $newList->addList($event, $title, $subtitle, $message);

      FlashMessage::create_flash_message('list_add_success', 'Votre liste a été ajoutée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $this->render('list/add');
  }

  /**
   * Modifier une liste
   *
   * @param int $idList : id de la liste
   * @return void
   */
  public function edit($idList)
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $editList = new Event();
      $editList = $editList->editList($idList, $event, $title, $subtitle, $message);

      FlashMessage::create_flash_message('list_add_success', 'Votre liste a été modifiée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $list = new Event();
    $listById = $list->findOne($idList);

    $this->render('list/edit', [
      'list_edit' => $listById
    ]);
  }

  /**
   * Supprimer une liste
   *
   * @param int $idList : id de la liste
   * @return void
   */
  public function delete($idList)
  {
    $deleteList = new Event();
    $deleteList = $deleteList->deleteList($idList);

    FlashMessage::create_flash_message('list_add_success', 'Votre liste a été supprimée', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
