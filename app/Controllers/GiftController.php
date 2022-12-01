<?php

namespace App\Controllers;

use App\Models\Gift;
use App\Models\Lists;
use App\Utils\Config;
use App\Utils\FlashMessage;

class GiftController extends CoreController
{
  /**
   * Ajouter un cadeau
   *
   * @param [in] $idList : id de la liste
   * @return void
   */
  public function add($idList)
  {
    if (isset($_POST['url_product']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['shop']) && isset($_POST['url_image_product']) && isset($_POST['preference'])) {
      $urlProduct = $_POST['url_product'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $urlImgProduct = $_POST['url_image_product'];

      // champs avec valeur par défault
      $shop = (!empty($_POST['shop'])) ? $_POST['shop'] : null;
      $preference = (!empty($_POST['preference'])) ? $_POST['preference'] : null;

      $newGift = new Gift();
      $newGift = $newGift->addGift($idList, $urlProduct, $name, $price, $shop, $urlImgProduct, $preference);

      FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été ajoutée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $lists = new Lists();
    $listById = $lists->findOne($idList);

    $this->render('gift/add', [
      'list_id' => $idList
    ]);
  }

  /**
   * Modifier un cadeau
   *
   * @param [int] $idList : id de la liste
   * @param [int] $idGift : id du cadeau
   * @return void
   */
  public function edit($idList, $idGift)
  {
    if (isset($_POST['url_product']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['shop']) && isset($_POST['url_image_product']) && isset($_POST['preference'])) {
      $urlProduct = $_POST['url_product'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $shop = $_POST['shop'];
      $urlImgProduct = $_POST['url_image_product'];
      $preference = $_POST['preference'];

      $editGift = new Gift();
      $editGift = $editGift->editGift($idGift, $urlProduct, $name, $price, $shop, $urlImgProduct, $preference);

      FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été modifié', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $gift = new Gift();
    $giftById = $gift->findOne($idGift);

    $this->render('gift/edit', [
      'gift_edit' => $giftById,
      'list_id' => $idList
    ]);
  }

  /**
   * Supprimer un cadeau
   *
   * @param [int] $idList : id de la liste
   * @param [int] $giftId : id du cadeau
   * @return void
   */
  public function delete($idList, $giftId)
  {
    $deleteGift = new Gift();
    $deleteGift = $deleteGift->deleteGift($giftId);

    FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été supprimé', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
