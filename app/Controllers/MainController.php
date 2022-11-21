<?php

namespace App\Controllers;

class MainController extends CoreController
{
  /**
   * Affiche la page d'acceuil
   *
   * @return void
   */
  public function home()
  {
    $this->render('main/home');
  }

  /**
   * Affiche la page contact
   *
   * @return void
   */
  public function contact()
  {
    $this->render('contact');
  }
}
