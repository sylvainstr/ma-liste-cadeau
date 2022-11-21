<?php

use App\Controllers\ErrorController;
use App\Routes\Router;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router($_GET['url']);

$router->get('/', "Main#home");

// je consulte mes listes de cadeaux
$router->get('/liste', "List#browse");

// je crée ma liste de cadeaux
$router->get('/liste/ajouter', "List#add");
$router->post('/liste/ajouter', "List#add");

// je modifie ma liste de cadeaux
$router->get('/liste/modifier/:id', "List#edit");
$router->post('/liste/modifier/:id', "List#edit");

// je consulte ma liste
$router->get('/liste/:id', "List#read");

// je supprime ma liste de cadeaux
$router->get('/liste/supprimer/:id', "List#delete");

// j'ajoute un cadeau à ma liste
$router->get('/liste/:id/cadeau/ajouter', "Gift#add");
$router->post('/liste/:id/cadeau/ajouter', "Gift#add");

// je modifie un cadeau à ma liste
$router->get('/liste/:id/cadeau/modifier/:giftid', "Gift#edit");
$router->post('/liste/:id/cadeau/modifier/:giftid', "Gift#edit");

// je supprime un cadeau à ma liste
$router->get('/liste/:id/cadeau/supprimer/:giftid', "Gift#delete");

// j'accéde au formulaire d'inscription
$router->get('/inscription', "User#register");
$router->post('/inscription', "User#register");

// j'accéde au formulaire de connexion
$router->get('/connexion', "User#login");
$router->post('/connexion', "User#login");

// je me déconnecte
$router->get('/deconnexion', "User#logout");

$router->get('/contact', "Main#contact");

try {
  $router->run();
}
catch (Exception $e) {
  if ($e->getCode() === 404) {
    $errorController = new ErrorController();
    $errorController->notFound();
  }
}