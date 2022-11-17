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
  public function list()
  {
    $id = $_SESSION['user']['id'];

    $lists = new Lists();
    $lists = $lists->findById($id);

    $this->render('list/list', [
      'lists' => $lists
    ]);
  }

  /**
   * consultation de la liste par l'id
   *
   * @param int $id : id de la liste
   * @return void
   */
  public function read($id)
  {
    $lists = new Lists();
    $listById = $lists->findOne($id);

    // l'id n'existe pas
    if (empty($listById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $this->render('list/read', [
      'list_read' => $listById
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
   * @param int $id : id de la liste
   * @return void
   */
  public function edit($id)
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $editList = new Lists();
      $editList = $editList->editList($id, $event, $title, $subtitle, $message);

      FlashMessage::create_flash_message('list_add_success', 'Votre liste a été modifiée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $list = new Lists();
    $listById = $list->findOne($id);

    $this->render('list/edit', [
      'list_edit' => $listById
    ]);
  }

  /**
   * Supprimer une liste
   *
   * @param int $id : id de la liste
   * @return void
   */
  public function delete($id)
  {
    $deleteList = new Lists();
    $deleteList = $deleteList->deleteList($id);

    FlashMessage::create_flash_message('list_add_success', 'Votre liste a été supprimée', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
