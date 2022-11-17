<?php

namespace App\Controllers;

use App\Models\Gift;
use App\Utils\Config;

class GiftController extends CoreController
{

    /**
   * Renvoi les cadeau d'une liste
   *
   * @return void
   */
  public function browse()
  {
    $id = $_SESSION['user']['id'];

    $gift = new Gift();
    $gift = $gift->findById($id);

    $this->render('gift/gift', [
      'gift' => $gift
    ]);
  }

  /**
   * consultation d'un cadeau par l'id
   *
   * @param int $id : id du cadeau
   * @return void
   */
  public function read($id)
  {
    $gift = new Gift();
    $giftById = $gift->findOne($id);

    // l'id n'existe pas
    if (empty($giftById)) {
      $errorController = new ErrorController();
      return $errorController->notFound();
    }

    $this->render('gift/read', [
      'gift_read' => $giftById
    ]);
  }

  /**
   * Ajouter un cadeau
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

      $newGift = new Gift();
      $newGift = $newGift->addGift($event, $title, $subtitle, $message);


      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $this->render('gift/add');
  }

  /**
   * Modifier un cadeau
   *
   * @param int $id : id d'un cadeau
   * @return void
   */
  public function edit($id)
  {
    if (isset($_POST['event']) && isset($_POST['title']) && isset($_POST['message'])) {
      $event = $_POST['event'];
      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $message = $_POST['message'];

      $editGift = new Gift();
      $editGift = $editGift->editGift($id, $event, $title, $subtitle, $message);

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $gift = new Gift();
    $giftById = $gift->findOne($id);

    $this->render('gift/edit', [
      'gift_edit' => $giftById
    ]);
  }

  /**
   * Supprimer un cadeau
   *
   * @param int $id : id du cadeau
   * @return void
   */
  public function delete($id)
  {
    $deleteGift = new Gift();
    $deleteGift = $deleteGift->deleteGift($id);

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}