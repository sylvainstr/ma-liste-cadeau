<?php

namespace App\Controllers;

use App\Models\Lists;
use App\Utils\Config;
use App\Utils\FlashMessage;

class ListController extends CoreController
{
  /**
   * Renvoi les listes par utilisateurs
   *
   * @return void
   */
  public function browse()
  {
    $id = $_SESSION['user']['id'];

    $lists = new Lists();
    $lists = $lists->findByUserId($id);

    $this->render('list/list', [
      'lists' => $lists
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
    $lists = new Lists();
    $listById = $lists->findOne($idList);

    // l'id n'existe pas
    if (empty($listById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $gifts = $listById->getGifts();

    $this->render('list/read', [
      'list_read' => $listById,
      'gifts' => $gifts
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

      $newList = new Lists();
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

      $editList = new Lists();
      $editList = $editList->editList($idList, $event, $title, $subtitle, $message);

      FlashMessage::create_flash_message('list_add_success', 'Votre liste a été modifiée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $list = new Lists();
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
    $deleteList = new Lists();
    $deleteList = $deleteList->deleteList($idList);

    FlashMessage::create_flash_message('list_add_success', 'Votre liste a été supprimée', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
