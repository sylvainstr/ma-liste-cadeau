<?php

namespace App\Controllers;

use App\Models\Gift;
use App\Repository\GiftRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;

class GiftController extends CoreController
{
  /**
   * Ajouter un cadeau
   *
   * @return void
   */
  public function add()
  {
    if (isset($_POST['url_product']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['shop']) && isset($_POST['url_image_product']) && isset($_POST['rank'])) {
      $urlProduct = $_POST['url_product'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $urlImgProduct = $_POST['url_image_product'];

      // champs avec valeur par défault
      $shop = (!empty($_POST['shop'])) ? $_POST['shop'] : null;
      $rank = (!empty($_POST['rank'])) ? $_POST['rank'] : null;

      $userId = $_SESSION['user']['id'];

      try {
        $newGift = new Gift($urlProduct, $name, $price, $shop, $urlImgProduct, $rank, $userId);
        $gitRepo = new GiftRepository();
        $gitRepo->save($newGift);
      } catch (\Exception $exception) {
        var_dump($exception->getMessage());        
      }

      FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été ajoutée', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "cadeaux");
      exit;
    }

    $this->render('gift/add');
  }

  /**
   * Modifier un cadeau
   *
   * @param [int] $idGift : id du cadeau
   * @return void
   */
  public function edit($giftId)
  {

    $gitRepo = new GiftRepository();
    $gift = $gitRepo->findOne($giftId);
    
    if (!$gift) {
      die('Le cadeau n\'existe pas');
    }

    if (isset($_POST['url_product']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['shop']) && isset($_POST['url_image_product']) && isset($_POST['rank'])) {
      $urlProduct = $_POST['url_product'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $shop = $_POST['shop'];
      $urlImgProduct = $_POST['url_image_product'];
      $rank = $_POST['rank'];

      try {

        $gift->setUrlProduct($urlProduct);
        $gift->setName($name);
        $gift->setPrice($price);
        $gift->setShop($shop);
        $gift->setUrlImageProduct($urlImgProduct);
        $gift->setRank($rank);
        
        $gitRepo->edit($gift);

      } catch (\Exception $exception) {
        var_dump($exception->getMessage());
      }

      FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été modifié', 'FLASH_SUCCESS');

      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "cadeaux");
      exit;
    }

  

    $this->render('gift/edit', [
      'gift_edit' => $gift
    ]);
  }

  /**
   * Supprimer un cadeau
   *
   * @param [int] $giftId : id du cadeau
   * @return void
   */
  public function delete($giftId)
  {
    $deleteGift = new GiftRepository();
    $deleteGift = $deleteGift->delete($giftId);

    FlashMessage::create_flash_message('list_add_success', 'Votre cadeau a été supprimé', 'FLASH_SUCCESS');

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl" . "cadeaux");
    exit;
  }
}
