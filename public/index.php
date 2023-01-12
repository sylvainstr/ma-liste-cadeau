<?php

use App\Controllers\ErrorController;
use App\Routes\Router;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router($_GET['url']);

$router->get('/', "Main#home");

// je consulte ma liste de cadeaux
$router->get('/cadeaux', "List#browse");

// j'ajoute un cadeau à ma liste
$router->get('/cadeaux/ajouter', "Gift#add");
$router->post('/cadeaux/ajouter', "Gift#add");

// je modifie un cadeau à ma liste
$router->get('/cadeaux/modifier/:giftid', "Gift#edit");
$router->post('/cadeaux/modifier/:giftid', "Gift#edit");

// je supprime un cadeau à ma liste
$router->get('/cadeaux/supprimer/:giftid', "Gift#delete");

// je consulte mes amis
$router->get('/amis', "Friends#browse");

// j'ajoute une utilisateur à ma liste d'amis
$router->get('/amis/invitation', "Friends#invit");
$router->post('/amis/invitation', "Friends#invit");

// je supprime un utilisateur de mon événement
$router->get('/amis/supprimer/:friendid', "Friends#deleteFriend");

// je consulte mon événement
$router->get('/evenement/:id', "Event#read");

// j'invite une utilisateur à mon événement
$router->get('/evenement/:id/inviter/amis', "Friends#addFriend");
$router->post('/evenement/:id/inviter/amis', "Friends#addFriend");


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