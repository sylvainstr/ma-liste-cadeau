<?php

namespace App\Controllers;

use App\Models\Lists;
use App\Utils\Config;

class ListController extends CoreController
{
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

  public function add()
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $newList = new Lists();
      $newList = $newList->addList($event, $title, $subtitle, $message);

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $this->render('list/add');
  }

  public function edit($id)
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $editList = new Lists();
      $editList = $editList->editList($id, $event, $title, $subtitle, $message);

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

  public function delete($id)
  {
    $deleteList = new Lists();
    $deleteList = $deleteList->deleteList($id);

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
