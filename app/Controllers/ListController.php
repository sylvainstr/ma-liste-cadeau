<?php

namespace App\Controllers;

use App\Utils\Config;
use App\Repository\GiftRepository;

class ListController extends CoreController
{
  /**
   * Renvoi la liste de cadeaux par utilisateurs
   *
   * @return void
   */
  public function browse()
  {

    if (!isset($_SESSION["user"])) {
      // si l'utilisateur n'est pas connecté on redirige vers la page d'acceuil
      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }

    $userId = $_SESSION['user']['id'];

    $giftRepo = new GiftRepository();
    $gifts = $giftRepo->findByUserId($userId);

    $this->render('list/list', [
      'gifts' => $gifts
    ]);
  }
  
}
