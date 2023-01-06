<?php

namespace App\Controllers;

use App\Repository\UserRepository;

class ListController extends CoreController
{
  /**
   * Renvoi la liste de cadeaux par utilisateurs
   *
   * @return void
   */
  public function browse()
  {
    $userId = $_SESSION['user']['id'];

    $giftRepo = new UserRepository();
    $gifts = $giftRepo->findByUserId($userId);

    $this->render('list/list', [
      'gifts' => $gifts
    ]);
  }
  
}
