<?php

namespace App\Controllers;

class CoreController {
  /**
   * Renvoi vers le template $template en lui passant des données
   *
   * @param string $template Path du template
   * @param array $variables Variable utilisable dans le template
   * @return void
   */
  public function render(string $template, $variables = []) {

    // transform les clés en variables
    // exemple : ['list' => 12] devient $list = 12;
    extract($variables);
    unset($variables);
    
    require_once __DIR__ . '/../Views/header.tpl.php';
    require_once __DIR__ . "/../Views/" . $template . ".tpl.php";
    require_once __DIR__ . '/../Views/footer.tpl.php';

  }
}