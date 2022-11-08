<?php

use App\Routes\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router($_GET['url']);

$router->get('/', "Main#home");

// je consulte mes listes de cadeaux
$router->get('/listes', "List#list");

// je consulte ma liste
$router->get('/liste/:id', function ($id) {
  echo 'Ma liste';
});

// je crée ma liste de cadeaux
$router->get('/liste/ajouter', function () {
  echo "Je crée ma liste de cadeaux";
});

// je modifie ma liste de cadeaux
$router->get('/liste//id/modifier', function () {
  echo "Je modifie ma liste de cadeaux";
});

// je supprime ma liste de cadeaux
$router->get('/liste/id/supprimer', function () {
  echo "Je supprime ma liste de cadeaux";
});

// j'ajoute un cadeau à ma liste
$router->get('/liste/id/cadeau/ajouter', function () {
  echo "J'ajoute mon cadeau";
});

// je modifie un cadeau à ma liste
$router->get('/liste/id/cadeau/modifier', function () {
  echo "Je modifie mon cadeau";
});

// je supprime un cadeau à ma liste
$router->get('/liste/id/cadeau/supprimer', function () {
  echo "Je supprime mon cadeau";
});


// $router->get('/test/:slug-:id', "List#list")
//   ->with('id', '[0-9]+')
//   ->with('slug', '([a-z\-0-9]+)');

$router->get('/connexion', function () {
  echo "Connexion";
});

$router->get('/inscription', function () {
  echo "Inscription";
});

$router->get('/contact', function () {
  echo "Contact";
});

$router->run();
