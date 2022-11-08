<?php

namespace App\Controllers;

class CoreController {

  public function render(string $template) {

    require_once __DIR__ . '/../Views/header.tpl.php';
    require_once __DIR__ . "/../Views/main/" . $template . ".tpl.php";
    require_once __DIR__ . '/../Views/footer.tpl.php';

  }

  public function renderList(string $template) {

    require_once __DIR__ . '/../Views/header.tpl.php';
    require_once __DIR__ . "/../Views/list/" . $template . ".tpl.php";
    require_once __DIR__ . '/../Views/footer.tpl.php';

  }

}