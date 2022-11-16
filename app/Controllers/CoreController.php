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

    // On crée une variable qui contient l'url aboslu (donc complet) du dossier du projet
    // On n'aura plus qu'à utiliser uniquement cette variable dans nos templates
    $absoluteUrl =  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['BASE_URI'] . '/';
    
    require_once __DIR__ . '/../Views/header.tpl.php';
    require_once __DIR__ . "/../Views/" . $template . ".tpl.php";
    require_once __DIR__ . '/../Views/footer.tpl.php';

  }
}