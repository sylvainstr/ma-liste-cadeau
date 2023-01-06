<?php

use App\Controllers\ErrorController;
use App\Routes\Router;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router($_GET['url']);

$router->get('/', "Main#home");

// je consulte mes listes de cadeaux
$router->get('/liste', "List#browse");

// j'ajoute un cadeau à ma liste
$router->get('/liste/cadeau/ajouter', "Gift#add");
$router->post('/liste/cadeau/ajouter', "Gift#add");

// je modifie un cadeau à ma liste
$router->get('/liste/cadeau/modifier/:giftid', "Gift#edit");
$router->post('/liste/cadeau/modifier/:giftid', "Gift#edit");

// je supprime un cadeau à ma liste
$router->get('/liste/cadeau/supprimer/:giftid', "Gift#delete");

// j'invite une utilisateur à ma liste d'amis
$router->get('/liste/inviter/amis', "Friends#invit");
$router->post('/liste/inviter/amis', "Friends#invit");

// je consulte mon événement
$router->get('/evenement/:id', "Event#read");

// je consulte les utilisateurs d'un événement
$router->get('/evenement/:id/amis', "Friends#browse");

// j'invite une utilisateur à mon événement
$router->get('/evenement/:id/inviter/amis', "Friends#addFriend");
$router->post('/evenement/:id/inviter/amis', "Friends#addFriend");

// je supprime un utilisateur de mon événement
$router->get('/evenement/:id/amis/:id/supprimer', "Friends#deleteFriend");

// je supprime tout les utilisateurs de mon événement
$router->get('/evenement/:id/amis/supprimer', "Friends#deleteAllFriends");

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