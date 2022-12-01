<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $absoluteUrl ?>/assets/css/style.css">

  <title>Ma liste de cadeaux</title>
</head>

<body>

  <header>
    <a href="<?= $absoluteUrl ?>">Home</a>

    <h1>HEADER</h1>


    <?php if (!isset($_SESSION["user"])) : ?>
      <a href="<?= $absoluteUrl ?>connexion">Se connecter</a>
      <a href="<?= $absoluteUrl ?>inscription">S'inscrire</a>
    <?php else : ?>
      <a href="<?= $absoluteUrl ?>liste">Mes Listes</a>
      <a href="<?= $absoluteUrl ?>deconnexion">Se Déconnecter</a>
    <?php endif; ?>

  </header>

  <p>
    <?php
    App\Utils\FlashMessage::display_all_flash_messages(); ?>
  </p>

  <div class="wrapper">